<?php

namespace App\Http\Controllers\Telecaller;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display Telecaller Dashboard with personal leads metrics and follow-up alerts.
     */
    public function index(Request $request)
    {
        $currentAuthUser = auth()->user();
        $isAdmin = $currentAuthUser->isAdmin();
        
        $telecallers = $isAdmin ? \App\Models\User::role('Telecaller')->get() : collect();
        
        // Determine target user
        if ($isAdmin && $request->filled('user_id')) {
            $targetUser = \App\Models\User::find($request->user_id) ?? $currentAuthUser;
        } elseif ($isAdmin && $telecallers->isNotEmpty()) {
            $targetUser = $telecallers->first();
        } else {
            $targetUser = $currentAuthUser;
        }

        $userId = $targetUser->id;

        // Target user lead statistics
        $totalAssigned = Student::where('assigned_to', $userId)->count();
        $pendingCalls = Student::where('assigned_to', $userId)->where('status', 'New')->count();
        $followupsToday = Student::where('assigned_to', $userId)->whereDate('next_followup_at', today())->count();
        $interestedCount = Student::where('assigned_to', $userId)->where('status', 'Interested')->count();
        $convertedCount = Student::where('assigned_to', $userId)->where('status', 'Converted')->count();
        $notInterestedCount = Student::where('assigned_to', $userId)->where('status', 'Not Interested')->count();

        // Target user status breakdown
        $statusCounts = Student::where('assigned_to', $userId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Today's Follow-up Schedule
        $todayFollowups = Student::where('assigned_to', $userId)
            ->whereDate('next_followup_at', today())
            ->orderBy('next_followup_at', 'asc')
            ->take(8)
            ->get();

        // Recent Call Remarks logged by target user
        $recentRemarks = StudentRemark::with('student')
            ->where('user_id', $userId)
            ->latest()
            ->take(8)
            ->get();

        // Recently Assigned Leads (New)
        $newAssignedLeads = Student::where('assigned_to', $userId)
            ->where('status', 'New')
            ->latest('assigned_at')
            ->take(6)
            ->get();

        return view('telecaller.dashboard', compact(
            'targetUser',
            'telecallers',
            'isAdmin',
            'totalAssigned',
            'pendingCalls',
            'followupsToday',
            'interestedCount',
            'convertedCount',
            'notInterestedCount',
            'statusCounts',
            'todayFollowups',
            'recentRemarks',
            'newAssignedLeads'
        ));
    }
}
