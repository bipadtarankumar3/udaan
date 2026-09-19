<?php

namespace App\Http\Controllers\Telecaller;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentRemark;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display listing of leads assigned to current telecaller.
     */
    public function index(Request $request)
    {
        $currentAuthUser = auth()->user();
        $isAdmin = $currentAuthUser->isAdmin();
        $telecallers = $isAdmin ? \App\Models\User::role('Telecaller')->get() : collect();

        // Determine filter target
        $targetUserId = null;
        if ($isAdmin) {
            if ($request->filled('user_id') && $request->user_id !== 'all') {
                $targetUserId = $request->user_id;
            } elseif (!$request->filled('user_id') && $telecallers->isNotEmpty()) {
                $targetUserId = $telecallers->first()->id;
            }
        } else {
            $targetUserId = $currentAuthUser->id;
        }

        $query = Student::with(['remarks.user', 'assignedTelecaller'])
            ->latest('updated_at');

        if ($targetUserId) {
            $query->where('assigned_to', $targetUserId);
        }

        // Search
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('alt_phone', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('course_interested', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by Follow-up
        if ($request->filled('followup')) {
            if ($request->followup === 'today') {
                $query->whereDate('next_followup_at', today());
            } elseif ($request->followup === 'overdue') {
                $query->where('next_followup_at', '<', now())->whereNotIn('status', ['Converted', 'Closed', 'Not Interested']);
            } elseif ($request->followup === 'upcoming') {
                $query->where('next_followup_at', '>', now());
            }
        }

        $students = $query->paginate(15)->withQueryString();

        // Metrics for badges
        $metricsQuery = Student::query();
        if ($targetUserId) {
            $metricsQuery->where('assigned_to', $targetUserId);
        }

        $totalAssigned = (clone $metricsQuery)->count();
        $newCount = (clone $metricsQuery)->where('status', 'New')->count();
        $followupsToday = (clone $metricsQuery)->whereDate('next_followup_at', today())->count();

        return view('telecaller.students.index', compact('students', 'totalAssigned', 'newCount', 'followupsToday', 'isAdmin', 'telecallers', 'targetUserId'));
    }

    /**
     * Display student detail and timeline.
     */
    public function show(Student $student)
    {
        // Telecaller can view their own assigned students
        if ($student->assigned_to !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access to this student record.');
        }

        $student->load(['assignedTelecaller', 'remarks.user']);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'student' => $student,
                'remarks' => $student->remarks,
            ]);
        }

        return view('telecaller.students.show', compact('student'));
    }

    /**
     * Store new call remark and update student status.
     */
    public function storeRemark(Request $request, Student $student)
    {
        if ($student->assigned_to !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'You are not assigned to this student lead.');
        }

        $validated = $request->validate([
            'call_outcome' => ['required', 'string', Rule::in([
                'Connected',
                'Busy',
                'Not Reachable',
                'Wrong Number',
                'Switched Off',
                'Callback Requested',
                'Interested',
                'Not Interested',
                'Converted',
            ])],
            'status' => ['required', 'string', Rule::in([
                'New',
                'Contacted',
                'Interested',
                'Follow-up',
                'Not Interested',
                'Converted',
                'Closed',
            ])],
            'remarks' => ['required', 'string', 'min:3'],
            'next_followup_at' => ['nullable', 'date'],
        ]);

        // Create Remark entry
        $remark = StudentRemark::create([
            'student_id' => $student->id,
            'user_id' => auth()->id(),
            'call_outcome' => $validated['call_outcome'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks'],
            'next_followup_at' => $validated['next_followup_at'] ?? null,
        ]);

        // Update Student lead status and current remarks
        $student->update([
            'status' => $validated['status'],
            'last_contacted_at' => now(),
            'next_followup_at' => $validated['next_followup_at'] ?? ($validated['status'] === 'Converted' || $validated['status'] === 'Closed' ? null : $student->next_followup_at),
            'current_remarks' => $validated['remarks'],
        ]);

        return redirect()->back()->with('success', "Call logged & status updated for {$student->name}!");
    }
}
