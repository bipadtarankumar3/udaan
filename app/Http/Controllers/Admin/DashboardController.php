<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentRemark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display Admin Dashboard with KPI stats and Telecaller performance.
     */
    public function index()
    {
        // KPI Metrics
        $totalStudents = Student::count();
        $unassignedCount = Student::whereNull('assigned_to')->count();
        $assignedCount = Student::whereNotNull('assigned_to')->count();
        $convertedCount = Student::where('status', 'Converted')->count();
        $followupsTodayCount = Student::whereDate('next_followup_at', today())->count();
        $telecallersCount = User::role('Telecaller')->where('status', 'active')->count();

        // Status breakdown
        $statusCounts = Student::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Source breakdown
        $sourceCounts = Student::select('source', DB::raw('count(*) as count'))
            ->groupBy('source')
            ->pluck('count', 'source')
            ->toArray();

        // Telecaller Performance Matrix
        $telecallers = User::role('Telecaller')
            ->withCount([
                'assignedStudents as total_assigned',
                'assignedStudents as contacted_count' => function ($q) {
                    $q->whereIn('status', ['Contacted', 'Interested', 'Follow-up', 'Converted', 'Not Interested']);
                },
                'assignedStudents as converted_count' => function ($q) {
                    $q->where('status', 'Converted');
                },
                'assignedStudents as followups_today' => function ($q) {
                    $q->whereDate('next_followup_at', today());
                },
                'remarks as total_remarks'
            ])
            ->get();

        // Recent Remarks / Activity Stream
        $recentRemarks = StudentRemark::with(['student', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // Recent Student Leads
        $recentStudents = Student::with(['assignedTelecaller'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'unassignedCount',
            'assignedCount',
            'convertedCount',
            'followupsTodayCount',
            'telecallersCount',
            'statusCounts',
            'sourceCounts',
            'telecallers',
            'recentRemarks',
            'recentStudents'
        ));
    }
}
