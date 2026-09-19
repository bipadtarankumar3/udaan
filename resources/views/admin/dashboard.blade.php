@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Command Center')

@section('content')
<div class="space-y-6">

    <!-- Top Hero Banner with Uddan Educational Foundation identity -->
    <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm relative overflow-hidden">
        <!-- Subtle warm accent bar -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-600 via-orange-500 to-amber-500"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 relative z-10 pt-1">
            <div class="flex items-start gap-4">
                <div class="p-2.5 bg-slate-50 rounded-2xl border border-slate-200 shrink-0 hidden sm:block">
                    <img src="{{ asset('images/logo-icon.svg') }}" alt="Uddan" class="h-10 w-10">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-md bg-red-50 text-red-700 border border-red-200 text-[10px] font-bold uppercase tracking-wider">
                            Awareness Program 2025
                        </span>
                        <span class="text-slate-500 text-xs font-medium">• Bihar Student Credit Card (DRCC) Counseling</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black font-heading text-slate-900 mt-1">
                        Uddan Educational Foundation <span class="text-orange-600 font-normal">Counseling Central</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Overview of student counseling applications, telecaller lead distribution, and daily outreach.
                    </p>
                </div>
            </div>

            <!-- Fast Action Shortcuts -->
            <div class="flex items-center flex-wrap gap-2.5">
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm shadow-red-500/20 transition">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Manage & Assign Leads</span>
                </a>
                <a href="{{ route('admin.students.sample-csv') }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-download text-orange-600"></i>
                    <span>Sample CSV</span>
                </a>
            </div>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Total Leads -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Applicants</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 mt-1.5">{{ number_format($totalStudents) }}</h3>
                    <p class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-graduation-cap"></i> Registered Students
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 border border-red-100 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Unassigned Leads -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Unassigned Leads</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-orange-600 mt-1.5">{{ number_format($unassignedCount) }}</h3>
                    <p class="text-[11px] text-orange-700 font-semibold mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-bolt"></i> Needs Assignment
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
        </div>

        <!-- Follow-ups Today -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Follow-ups Today</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-amber-600 mt-1.5">{{ number_format($followupsTodayCount) }}</h3>
                    <p class="text-[11px] text-amber-700 font-semibold mt-1 flex items-center gap-1">
                        <i class="fa-regular fa-clock"></i> Scheduled For Today
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
            </div>
        </div>

        <!-- Converted / Confirmed -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Confirmed Admissions</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-emerald-600 mt-1.5">{{ number_format($convertedCount) }}</h3>
                    <p class="text-[11px] text-emerald-700 font-semibold mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i> Counseling Converted
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Main Grid: Telecaller Leaderboard & Pipeline Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Telecaller Performance Table (2 Cols) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold font-heading text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-headset text-orange-600"></i>
                        <span>Telecaller Team Progress & Calling Stats</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Real-time caller activity, conversions, and remark count</p>
                </div>
                <span class="px-2.5 py-1 rounded-lg bg-orange-50 text-orange-700 border border-orange-200 text-xs font-bold">
                    {{ $telecallers->count() }} Active Counselors
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold">
                            <th class="py-3 pl-3">Counselor / Telecaller</th>
                            <th class="py-3 text-center">Assigned Leads</th>
                            <th class="py-3 text-center">Contacted</th>
                            <th class="py-3 text-center">Today's Due</th>
                            <th class="py-3 text-center">Converted</th>
                            <th class="py-3 text-center">Total Remarks</th>
                            <th class="py-3 text-center">Conversion</th>
                            <th class="py-3 text-right pr-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($telecallers as $t)
                            @php
                                $conversionRate = $t->total_assigned > 0 ? round(($t->converted_count / $t->total_assigned) * 100, 1) : 0;
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 pl-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-red-600 to-orange-500 text-white flex items-center justify-center font-bold text-xs">
                                            {{ substr($t->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-xs">{{ $t->name }}</p>
                                            <p class="text-[10px] text-slate-500">{{ $t->phone ?? $t->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 text-center font-semibold text-slate-800">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-mono">
                                        {{ $t->total_assigned }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-center font-semibold text-blue-600">
                                    {{ $t->contacted_count }}
                                </td>
                                <td class="py-3.5 text-center font-semibold {{ $t->followups_today > 0 ? 'text-amber-600 font-bold' : 'text-slate-400' }}">
                                    {{ $t->followups_today }}
                                </td>
                                <td class="py-3.5 text-center font-semibold text-emerald-600">
                                    {{ $t->converted_count }}
                                </td>
                                <td class="py-3.5 text-center font-semibold text-slate-700">
                                    <span class="px-2 py-0.5 rounded-md bg-orange-50 text-orange-700 border border-orange-100 font-mono text-[11px]">
                                        {{ $t->total_remarks }} logs
                                    </span>
                                </td>
                                <td class="py-3.5 text-center font-bold text-emerald-600">
                                    {{ $conversionRate }}%
                                </td>
                                <td class="py-3.5 text-right pr-3">
                                    <a 
                                        href="{{ route('telecaller.dashboard', ['user_id' => $t->id]) }}" 
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-700 border border-orange-200 text-xs font-semibold transition"
                                        title="View {{ $t->name }}'s Workspace"
                                    >
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        <span>View Dashboard</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-6 text-center text-slate-400">
                                    No telecaller accounts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Stage Distribution Widget (1 Col) -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold font-heading text-slate-900 flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-chart-pie text-orange-600"></i>
                    <span>Application Pipeline</span>
                </h3>
                <p class="text-xs text-slate-500 mb-4">Status of registered students</p>

                <div class="space-y-3">
                    @php
                        $statuses = [
                            'New' => ['color' => 'bg-emerald-500', 'text' => 'text-emerald-700'],
                            'Contacted' => ['color' => 'bg-blue-500', 'text' => 'text-blue-700'],
                            'Interested' => ['color' => 'bg-amber-500', 'text' => 'text-amber-700'],
                            'Follow-up' => ['color' => 'bg-purple-500', 'text' => 'text-purple-700'],
                            'Converted' => ['color' => 'bg-teal-500', 'text' => 'text-teal-700'],
                            'Not Interested' => ['color' => 'bg-rose-500', 'text' => 'text-rose-700'],
                            'Closed' => ['color' => 'bg-slate-400', 'text' => 'text-slate-600'],
                        ];
                    @endphp

                    @foreach($statuses as $stName => $stMeta)
                        @php
                            $count = $statusCounts[$stName] ?? 0;
                            $percent = $totalStudents > 0 ? round(($count / $totalStudents) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-bold {{ $stMeta['text'] }}">{{ $stName }}</span>
                                <span class="text-slate-600 font-mono">{{ $count }} ({{ $percent }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="{{ $stMeta['color'] }} h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Assigned: <strong class="text-slate-800">{{ $assignedCount }}</strong></span>
                <span>Unassigned: <strong class="text-orange-600 font-bold">{{ $unassignedCount }}</strong></span>
            </div>
        </div>

    </div>

    <!-- Live Telecaller Call Feed -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-base font-bold font-heading text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-orange-600"></i>
                    <span>Live Telecaller Call Logs & Counseling Notes</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Real-time audit log of telecaller calls, parent discussions, and status updates</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 flex items-center gap-1">
                <span>View all students</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="space-y-3">
            @forelse($recentRemarks as $rem)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 hover:border-slate-300 transition flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-700 border border-orange-200 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div class="flex items-center flex-wrap gap-2">
                                <span class="font-bold text-slate-900 text-sm">{{ $rem->student->name ?? 'Unknown Student' }}</span>
                                @if($rem->student?->father_name)
                                    <span class="text-xs text-slate-500">(Father: {{ $rem->student->father_name }})</span>
                                @endif
                                
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-orange-100 text-orange-700 border border-orange-200">
                                    {{ $rem->call_outcome }}
                                </span>
                                
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $rem->student?->status_badge_class }}">
                                    {{ $rem->status }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-700 mt-1.5 italic bg-white p-2.5 rounded-lg border border-slate-200">
                                "{{ $rem->remarks }}"
                            </p>

                            @if($rem->next_followup_at)
                                <p class="text-[11px] text-amber-700 font-semibold mt-1.5 flex items-center gap-1.5">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <span>Follow-up Scheduled: <strong>{{ $rem->next_followup_at->format('M d, Y h:i A') }}</strong></span>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="text-left md:text-right shrink-0 pl-12 md:pl-0 border-t md:border-t-0 pt-2 md:pt-0 border-slate-200">
                        <p class="text-xs font-bold text-slate-800">
                            <i class="fa-solid fa-headset text-orange-600 mr-1"></i>
                            {{ $rem->user->name ?? 'System' }}
                        </p>
                        <p class="text-[10px] text-slate-400 mt-0.5">
                            {{ $rem->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-400">
                    <i class="fa-solid fa-headset text-3xl mb-2 opacity-50"></i>
                    <p class="text-sm">No counseling remarks logged yet.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
