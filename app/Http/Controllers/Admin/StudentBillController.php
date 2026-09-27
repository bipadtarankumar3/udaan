<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StudentBillController extends Controller
{
    /**
     * Display a listing of student bills & receipts with metrics and filters.
     */
    public function index(Request $request)
    {
        $query = StudentBill::with(['student', 'creator'])->latest('billing_date')->latest('id');

        // Search by Invoice No, Student Name, Phone, Email, Transaction ID, Course
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%")
                  ->orWhere('student_phone', 'like', "%{$search}%")
                  ->orWhere('student_email', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%")
                  ->orWhere('course_name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Filter by Payment Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }

        // Filter by Payment Method
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by Student ID
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Filter by Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('billing_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('billing_date', '<=', $request->date_to);
        }

        // Compute KPIs / Overview metrics
        $metrics = [
            'total_invoiced' => (float) StudentBill::sum('total_payable'),
            'total_paid' => (float) StudentBill::sum('paid_amount'),
            'total_due' => (float) StudentBill::sum('due_amount'),
            'paid_count' => StudentBill::where('payment_status', 'paid')->count(),
            'partial_count' => StudentBill::where('payment_status', 'partially_paid')->count(),
            'unpaid_count' => StudentBill::where('payment_status', 'unpaid')->count(),
            'total_bills' => StudentBill::count(),
        ];

        $bills = $query->paginate(15)->withQueryString();

        // Active students for billing dropdown
        $students = Student::select('id', 'name', 'phone', 'email', 'father_name', 'course_interested')
            ->orderBy('name')
            ->get();

        return view('admin.billings.index', compact('bills', 'metrics', 'students'));
    }

    /**
     * Store a newly created bill in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'student_name' => 'required|string|max:255',
            'student_phone' => 'required|string|max:20',
            'student_email' => 'nullable|email|max:255',
            'student_father_name' => 'nullable|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
            'billing_date' => 'required|date',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['discount'] = $validated['discount'] ?? 0.00;
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0.00;
        $validated['paid_amount'] = $validated['paid_amount'] ?? 0.00;
        $validated['created_by'] = auth()->id();

        if ($validated['paid_amount'] > 0) {
            $validated['paid_at'] = now();
        }

        $bill = StudentBill::create($validated);

        return redirect()->route('admin.billings.index')
            ->with('success', "Invoice #{$bill->invoice_no} created successfully for {$bill->student_name}!");
    }

    /**
     * Display the printable official Invoice & Fee Receipt.
     */
    public function show(StudentBill $billing)
    {
        $bill = $billing->load(['student', 'creator']);
        return view('admin.billings.show', compact('bill'));
    }

    /**
     * Update the specified bill in storage.
     */
    public function update(Request $request, StudentBill $billing)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'student_name' => 'required|string|max:255',
            'student_phone' => 'required|string|max:20',
            'student_email' => 'nullable|email|max:255',
            'student_father_name' => 'nullable|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:paid,partially_paid,unpaid,cancelled',
            'payment_method' => 'nullable|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
            'billing_date' => 'required|date',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['discount'] = $validated['discount'] ?? 0.00;
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0.00;
        $validated['paid_amount'] = $validated['paid_amount'] ?? 0.00;

        $billing->update($validated);

        return redirect()->route('admin.billings.index')
            ->with('success', "Invoice #{$billing->invoice_no} updated successfully!");
    }

    /**
     * Quick Record Payment against an invoice.
     */
    public function recordPayment(Request $request, StudentBill $billing)
    {
        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $newPaid = floatval($billing->paid_amount) + floatval($validated['payment_amount']);
        $billing->paid_amount = $newPaid;
        $billing->payment_method = $validated['payment_method'];
        if (!empty($validated['transaction_id'])) {
            $billing->transaction_id = $validated['transaction_id'];
        }
        $billing->paid_at = $validated['payment_date'] ?? now();
        if (!empty($validated['notes'])) {
            $billing->notes = trim(($billing->notes ? $billing->notes . "\n" : "") . "Payment received on " . now()->format('d M Y') . ": ₹" . number_format($validated['payment_amount'], 2) . " via " . $validated['payment_method'] . " (" . $validated['notes'] . ")");
        }
        $billing->save();

        return redirect()->route('admin.billings.index')
            ->with('success', "Payment of ₹" . number_format($validated['payment_amount'], 2) . " recorded for Invoice #{$billing->invoice_no}!");
    }

    /**
     * Remove the specified bill from storage.
     */
    public function destroy(StudentBill $billing)
    {
        $invoiceNo = $billing->invoice_no;
        $billing->delete();

        return redirect()->route('admin.billings.index')
            ->with('success', "Invoice #{$invoiceNo} has been removed successfully.");
    }

    /**
     * Export billing transactions to CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = StudentBill::latest('billing_date')->latest('id');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('billing_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('billing_date', '<=', $request->date_to);
        }

        $bills = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="student_billing_ledger_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function () use ($bills) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Invoice No',
                'Billing Date',
                'Student Name',
                'Phone',
                'Father Name',
                'Course',
                'Billing Purpose',
                'Base Amount (INR)',
                'Discount (INR)',
                'Tax Amount (INR)',
                'Total Payable (INR)',
                'Paid Amount (INR)',
                'Due Amount (INR)',
                'Payment Status',
                'Payment Method',
                'Transaction ID',
                'Due Date',
                'Created At'
            ]);

            foreach ($bills as $b) {
                fputcsv($file, [
                    $b->invoice_no,
                    $b->billing_date?->format('Y-m-d'),
                    $b->student_name,
                    $b->student_phone,
                    $b->student_father_name,
                    $b->course_name,
                    $b->title,
                    $b->amount,
                    $b->discount,
                    $b->tax_amount,
                    $b->total_payable,
                    $b->paid_amount,
                    $b->due_amount,
                    strtoupper($b->payment_status),
                    $b->payment_method,
                    $b->transaction_id,
                    $b->due_date?->format('Y-m-d'),
                    $b->created_at?->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
