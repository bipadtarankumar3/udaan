<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentRemark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students with comprehensive filters.
     */
    public function index(Request $request)
    {
        $query = Student::with(['assignedTelecaller', 'remarks.user'])->latest('id');

        // Filter by Search (name, father_name, phone, whatsapp_no, city, address, qualification)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('whatsapp_no', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('qualification', 'like', "%{$search}%")
                  ->orWhere('course_interested', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Qualification
        if ($request->filled('qualification')) {
            $query->where('qualification', $request->qualification);
        }

        // Filter by Gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by Priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by Assignment (Telecaller or Unassigned)
        if ($request->filled('assigned_to')) {
            if ($request->assigned_to === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
        }

        // Filter by Follow-up date
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

        // Telecallers for assignment dropdown
        $telecallers = User::role('Telecaller')->where('status', 'active')->orderBy('name')->get();

        // Metrics for summary badges
        $totalStudents = Student::count();
        $unassignedStudents = Student::whereNull('assigned_to')->count();
        $convertedStudents = Student::where('status', 'Converted')->count();

        return view('admin.students.index', compact(
            'students',
            'telecallers',
            'totalStudents',
            'unassignedStudents',
            'convertedStudents'
        ));
    }

    /**
     * Store a newly created student counseling lead.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'dob' => ['nullable', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp_no' => ['nullable', 'string', 'max:20'],
            'qualification' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'string', Rule::in(['Male', 'Female', 'Other'])],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'course_interested' => ['nullable', 'string', 'max:255'],
            'source' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', Rule::in(['New', 'Contacted', 'Interested', 'Follow-up', 'Not Interested', 'Converted', 'Closed'])],
            'priority' => ['required', 'string', Rule::in(['Low', 'Medium', 'High'])],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'current_remarks' => ['nullable', 'string'],
        ]);

        if (!empty($validated['assigned_to'])) {
            $validated['assigned_at'] = now();
            $validated['assigned_by'] = auth()->id();
        }

        $student = Student::create($validated);

        if (!empty($validated['current_remarks'])) {
            StudentRemark::create([
                'student_id' => $student->id,
                'user_id' => auth()->id(),
                'call_outcome' => 'New Lead Added',
                'status' => $student->status,
                'remarks' => $validated['current_remarks'],
            ]);
        }

        return redirect()->route('admin.students.index')->with('success', "Student '{$student->name}' registered successfully!");
    }

    /**
     * Display student details and full remarks timeline.
     */
    public function show(Student $student)
    {
        $student->load(['assignedTelecaller', 'assignedBy', 'remarks.user']);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'student' => $student,
                'remarks' => $student->remarks,
            ]);
        }

        $telecallers = User::role('Telecaller')->where('status', 'active')->orderBy('name')->get();

        return view('admin.students.show', compact('student', 'telecallers'));
    }

    /**
     * Update the specified student lead.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'dob' => ['nullable', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp_no' => ['nullable', 'string', 'max:20'],
            'qualification' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'string', Rule::in(['Male', 'Female', 'Other'])],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'course_interested' => ['nullable', 'string', 'max:255'],
            'source' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', Rule::in(['New', 'Contacted', 'Interested', 'Follow-up', 'Not Interested', 'Converted', 'Closed'])],
            'priority' => ['required', 'string', Rule::in(['Low', 'Medium', 'High'])],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        // Detect assignment change
        if ($student->assigned_to != $validated['assigned_to']) {
            $validated['assigned_at'] = !empty($validated['assigned_to']) ? now() : null;
            $validated['assigned_by'] = !empty($validated['assigned_to']) ? auth()->id() : null;
        }

        $student->update($validated);

        return redirect()->back()->with('success', "Student '{$student->name}' details updated successfully!");
    }

    /**
     * Remove the specified student lead.
     */
    public function destroy(Student $student)
    {
        $name = $student->name;
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', "Student lead '{$name}' deleted successfully.");
    }

    /**
     * Bulk Assign selected students to a Telecaller.
     */
    public function bulkAssign(Request $request)
    {
        $validated = $request->validate([
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['integer', 'exists:students,id'],
            'telecaller_id' => ['required', 'exists:users,id'],
        ]);

        $telecaller = User::findOrFail($validated['telecaller_id']);

        $updatedCount = Student::whereIn('id', $validated['student_ids'])->update([
            'assigned_to' => $telecaller->id,
            'assigned_at' => now(),
            'assigned_by' => auth()->id(),
        ]);

        return redirect()->route('admin.students.index')->with(
            'success',
            "Successfully assigned {$updatedCount} student(s) to {$telecaller->name}!"
        );
    }

    /**
     * Bulk Upload students via CSV with Counseling Form columns.
     */
    public function bulkUpload(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
            'default_telecaller_id' => ['nullable', 'exists:users,id'],
            'default_source' => ['nullable', 'string'],
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        if (!$handle) {
            return back()->with('error', 'Unable to open CSV file.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return back()->with('error', 'The uploaded CSV file is empty.');
        }

        // Clean and normalize header columns
        $normalizedHeader = array_map(function ($col) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9_]/', '', str_replace([' ', '-', '.'], '_', $col))));
        }, $header);

        $insertedCount = 0;
        $skippedCount = 0;
        $errors = [];
        $rowNumber = 1;

        $defaultTelecallerId = $request->filled('default_telecaller_id') ? $request->default_telecaller_id : null;
        $defaultSource = $request->filled('default_source') ? $request->default_source : 'Bulk Upload';

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                // Skip blank lines
                if (empty(array_filter($row))) {
                    continue;
                }

                $data = @array_combine($normalizedHeader, $row);
                if (!$data) {
                    $skippedCount++;
                    $errors[] = "Row {$rowNumber}: Column mismatch.";
                    continue;
                }

                $name = trim($data['name'] ?? $data['student_name'] ?? '');
                $fatherName = trim($data['father_name'] ?? $data['fathers_name'] ?? $data['father'] ?? '');
                $dob = trim($data['date_of_birth'] ?? $data['dob'] ?? '');
                $phone = trim($data['mobile_no'] ?? $data['mobile'] ?? $data['phone'] ?? $data['contact'] ?? '');
                $whatsappNo = trim($data['whatsapp_no'] ?? $data['whatsapp'] ?? $phone);
                $qualification = trim($data['qualification'] ?? $data['education'] ?? '');
                $gender = trim($data['gender'] ?? '');
                $address = trim($data['address'] ?? '');
                $city = trim($data['city'] ?? $data['location'] ?? '');
                $course = trim($data['course_interested'] ?? $data['course'] ?? '');
                $source = trim($data['source'] ?? $defaultSource);
                $priority = trim($data['priority'] ?? 'Medium');
                $remarks = trim($data['remarks'] ?? $data['current_remarks'] ?? '');

                if (empty($name) || empty($phone)) {
                    $skippedCount++;
                    $errors[] = "Row {$rowNumber}: Name and Mobile No are required.";
                    continue;
                }

                if (!in_array($priority, ['Low', 'Medium', 'High'])) {
                    $priority = 'Medium';
                }

                // Format dob if present
                $parsedDob = null;
                if (!empty($dob)) {
                    $timestamp = strtotime($dob);
                    if ($timestamp !== false) {
                        $parsedDob = date('Y-m-d', $timestamp);
                    }
                }

                $student = Student::create([
                    'name' => $name,
                    'father_name' => !empty($fatherName) ? $fatherName : null,
                    'dob' => $parsedDob,
                    'phone' => $phone,
                    'whatsapp_no' => !empty($whatsappNo) ? $whatsappNo : $phone,
                    'qualification' => !empty($qualification) ? $qualification : null,
                    'gender' => in_array(ucfirst(strtolower($gender)), ['Male', 'Female', 'Other']) ? ucfirst(strtolower($gender)) : null,
                    'address' => !empty($address) ? $address : null,
                    'city' => !empty($city) ? $city : null,
                    'course_interested' => !empty($course) ? $course : null,
                    'source' => !empty($source) ? $source : $defaultSource,
                    'status' => 'New',
                    'priority' => $priority,
                    'assigned_to' => $defaultTelecallerId,
                    'assigned_at' => $defaultTelecallerId ? now() : null,
                    'assigned_by' => $defaultTelecallerId ? auth()->id() : null,
                    'current_remarks' => !empty($remarks) ? $remarks : null,
                ]);

                if (!empty($remarks)) {
                    StudentRemark::create([
                        'student_id' => $student->id,
                        'user_id' => auth()->id(),
                        'call_outcome' => 'Bulk Import Note',
                        'status' => 'New',
                        'remarks' => $remarks,
                    ]);
                }

                $insertedCount++;
            }

            DB::commit();
            fclose($handle);

            $msg = "Bulk upload completed: {$insertedCount} student counseling application(s) imported successfully.";
            if ($skippedCount > 0) {
                $msg .= " ({$skippedCount} rows skipped due to missing required fields).";
            }

            return redirect()->route('admin.students.index')->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Error processing CSV file: ' . $e->getMessage());
        }
    }

    /**
     * Download sample CSV template with counseling form fields.
     */
    public function downloadSampleCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="counselling_students_sample.csv"',
        ];

        $columns = [
            'name',
            'father_name',
            'date_of_birth',
            'mobile_no',
            'whatsapp_no',
            'qualification',
            'gender',
            'address',
            'city',
            'course_interested',
            'source',
            'priority',
            'remarks'
        ];

        $sampleRows = [
            [
                'Ramesh Kumar',
                'Rajesh Kumar',
                '2004-05-15',
                '9876543211',
                '9876543211',
                '12th Pass',
                'Male',
                'Vill- Danapur, Ward 2',
                'Patna',
                'B.Tech Engineering',
                'Counseling Form',
                'High',
                'Inquired for Bihar Credit Card eligibility.'
            ],
            [
                'Pooja Kumari',
                'Santosh Prasad',
                '2003-11-20',
                '9876543212',
                '9876543212',
                'Graduation',
                'Female',
                'Station Road, Near Gate 1',
                'Gaya',
                'B.Sc Nursing',
                'Website Form',
                'Medium',
                'Wants counseling letter for government quota.'
            ],
            [
                'Amit Singh',
                'Bipin Singh',
                '2005-01-10',
                '9876543213',
                '9876543213',
                '10th Pass',
                'Male',
                'Zero Mile Chowk',
                'Muzaffarpur',
                'Polytechnic Diploma',
                'Counseling Form',
                'Medium',
                'Interested in Electrical Engineering.'
            ],
        ];

        $callback = function () use ($columns, $sampleRows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($sampleRows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Add remark from admin panel.
     */
    public function addRemark(Request $request, Student $student)
    {
        $validated = $request->validate([
            'call_outcome' => ['required', 'string'],
            'status' => ['required', 'string', Rule::in(['New', 'Contacted', 'Interested', 'Follow-up', 'Not Interested', 'Converted', 'Closed'])],
            'remarks' => ['required', 'string'],
            'next_followup_at' => ['nullable', 'date'],
        ]);

        StudentRemark::create([
            'student_id' => $student->id,
            'user_id' => auth()->id(),
            'call_outcome' => $validated['call_outcome'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks'],
            'next_followup_at' => $validated['next_followup_at'] ?? null,
        ]);

        $student->update([
            'status' => $validated['status'],
            'last_contacted_at' => now(),
            'next_followup_at' => $validated['next_followup_at'] ?? $student->next_followup_at,
            'current_remarks' => $validated['remarks'],
        ]);

        return back()->with('success', 'Remark and call log added successfully!');
    }
}
