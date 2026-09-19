@extends('layouts.app')

@section('title', 'My Assigned Leads Queue')
@section('header', 'Assigned Student Leads')

@section('content')
<div class="space-y-6" x-data="{
    remarkModalOpen: false,
    historyModalOpen: false,
    selectedStudent: null,
    historyRemarks: [],
    
    openRemarkModal(student) {
        this.selectedStudent = student;
        this.remarkModalOpen = true;
    },
    openHistoryModal(student) {
        this.selectedStudent = student;
        this.historyRemarks = student.remarks || [];
        this.historyModalOpen = true;
    },
    setFollowupPreset(hours) {
        const d = new Date();
        d.setHours(d.getHours() + hours);
        const iso = d.toISOString().slice(0, 16);
        const input = document.getElementById('telecaller_queue_followup');
        if (input) input.value = iso;
    }
}">

    @if(isset($isAdmin) && $isAdmin)
        <!-- Admin Workspace Switcher Bar -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base shadow-sm shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-amber-950 uppercase tracking-wide flex items-center gap-1.5">
                        <span>Admin Calling Queue Inspection</span>
                    </h4>
                    <p class="text-xs text-amber-800 mt-0.5">
                        Viewing active counseling leads and call logs across staff members.
                    </p>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-2.5">
                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-users"></i>
                    <span>Staff List</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to Admin Dashboard</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Filter & Header Card -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold font-heading text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-phone-volume text-orange-600"></i>
                    <span>{{ isset($isAdmin) && $isAdmin ? 'Telecaller Lead Queue' : 'My Active Calling Queue' }}</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Call applicants directly, update counseling status, and schedule future follow-ups</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700">
                    Allocated: <strong class="text-slate-900">{{ $totalAssigned }}</strong>
                </span>
                @if($newCount > 0)
                    <span class="px-3 py-1.5 rounded-xl bg-orange-50 border border-orange-200 text-xs font-bold text-orange-700">
                        {{ $newCount }} New Calls
                    </span>
                @endif
            </div>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('telecaller.students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 pt-3 border-t border-slate-100">
            @if(isset($isAdmin) && $isAdmin)
                <div>
                    <select name="user_id" class="w-full px-3 py-2 bg-amber-50/50 border border-amber-300 rounded-xl text-amber-950 font-medium text-xs focus:outline-none focus:ring-2 focus:ring-amber-500" onchange="this.form.submit()">
                        <option value="all" {{ request('user_id') === 'all' ? 'selected' : '' }}>All Counselors</option>
                        @foreach($telecallers as $t)
                            <option value="{{ $t->id }}" {{ (request('user_id') == $t->id || (!request()->filled('user_id') && isset($targetUserId) && $targetUserId == $t->id)) ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Search -->
            <div class="{{ isset($isAdmin) && $isAdmin ? 'lg:col-span-2' : 'lg:col-span-2' }} relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search name, father name, phone, address..." 
                    class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white" onchange="this.form.submit()">
                    <option value="">All Call Statuses</option>
                    @foreach(['New', 'Contacted', 'Interested', 'Follow-up', 'Not Interested', 'Converted', 'Closed'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Follow-up Filter -->
            <div>
                <select name="followup" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white" onchange="this.form.submit()">
                    <option value="">All Follow-up Timing</option>
                    <option value="today" {{ request('followup') == 'today' ? 'selected' : '' }}>🚨 Due Today ({{ $followupsToday }})</option>
                    <option value="overdue" {{ request('followup') == 'overdue' ? 'selected' : '' }}>⚠️ Overdue Follow-ups</option>
                    <option value="upcoming" {{ request('followup') == 'upcoming' ? 'selected' : '' }}>📅 Upcoming Follow-ups</option>
                </select>
            </div>

            <!-- Filter submit -->
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold border border-slate-200 transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'followup', 'priority']))
                    <a href="{{ route('telecaller.students.index') }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 rounded-xl text-xs border border-slate-200 transition" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Assigned Leads Table -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 pl-5">Student & Father Name</th>
                        <th class="py-3.5 px-3">Mobile & WhatsApp</th>
                        <th class="py-3.5 px-3">Qualification</th>
                        <th class="py-3.5 px-3">Address</th>
                        <th class="py-3.5 px-3 text-center">Status</th>
                        <th class="py-3.5 px-3">Follow-up Schedule</th>
                        <th class="py-3.5 px-3">Last Remark / Notes</th>
                        <th class="py-3.5 pr-5 text-right">Call Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 pl-5">
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $student->name }}</p>
                                    @if($student->father_name)
                                        <p class="text-[11px] text-slate-500">Father: <span class="text-slate-700 font-medium">{{ $student->father_name }}</span></p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-3">
                                <div class="flex items-center gap-2">
                                    <a 
                                        href="tel:{{ $student->phone }}" 
                                        class="font-mono text-emerald-600 hover:text-emerald-700 font-bold text-xs flex items-center gap-1.5"
                                        title="Click to Call"
                                    >
                                        <i class="fa-solid fa-phone text-[10px]"></i>
                                        <span>{{ $student->phone }}</span>
                                    </a>
                                    @if($student->whatsapp_no)
                                        <a 
                                            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->whatsapp_no) }}?text=Hello%20{{ urlencode($student->name) }},%20I%20am%20calling%20from%20Uddan%20Educational%20Foundation%20regarding%20your%20counselling%20application." 
                                            target="_blank" 
                                            class="text-emerald-500 hover:text-emerald-600 p-1 hover:bg-slate-100 rounded" 
                                            title="Chat on WhatsApp"
                                        >
                                            <i class="fa-brands fa-whatsapp text-sm"></i>
                                        </a>
                                    @endif
                                </div>
                                @if($student->whatsapp_no && $student->whatsapp_no !== $student->phone)
                                    <p class="font-mono text-slate-400 text-[10px] mt-0.5">WA: {{ $student->whatsapp_no }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 border border-slate-200 font-medium text-[11px]">
                                    {{ $student->qualification ?? 'General' }}
                                </span>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $student->gender ?? '' }}</p>
                            </td>
                            <td class="py-3.5 px-3 max-w-[170px]">
                                <p class="text-slate-700 truncate" title="{{ $student->address }}">{{ $student->address ?? '—' }}</p>
                                <p class="text-[10px] text-slate-400">{{ $student->city ?? '' }}</p>
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $student->status_badge_class }}">
                                    {{ $student->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3">
                                @if($student->next_followup_at)
                                    @php
                                        $isToday = $student->next_followup_at->isToday();
                                        $isPast = $student->next_followup_at->isPast() && !$isToday;
                                    @endphp
                                    <div class="{{ $isToday ? 'text-amber-700 font-bold' : ($isPast ? 'text-rose-700 font-semibold' : 'text-slate-600') }}">
                                        <p class="text-xs flex items-center gap-1">
                                            <i class="fa-regular fa-clock text-[10px]"></i>
                                            <span>{{ $student->next_followup_at->format('M d, h:i A') }}</span>
                                        </p>
                                        <p class="text-[10px] {{ $isToday ? 'text-amber-600' : 'text-slate-400' }}">
                                            {{ $isToday ? 'Today' : $student->next_followup_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @else
                                    <span class="text-slate-400 text-xs italic">Not scheduled</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-3 max-w-xs">
                                @if($student->current_remarks)
                                    <p class="text-[11px] text-slate-700 truncate" title="{{ $student->current_remarks }}">
                                        "{{ $student->current_remarks }}"
                                    </p>
                                    <button 
                                        type="button" 
                                        @click="openHistoryModal({{ json_encode($student) }})" 
                                        class="text-[10px] text-orange-600 hover:underline font-bold mt-0.5 flex items-center gap-1"
                                    >
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        <span>History ({{ $student->remarks->count() }})</span>
                                    </button>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">No remarks yet</span>
                                @endif
                            </td>
                            <td class="py-3.5 pr-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        @click="openHistoryModal({{ json_encode($student) }})" 
                                        class="p-2 text-slate-400 hover:text-orange-600 hover:bg-slate-100 rounded-xl transition" 
                                        title="View Call History"
                                    >
                                        <i class="fa-solid fa-timeline text-xs"></i>
                                    </button>

                                    <button 
                                        type="button" 
                                        @click="openRemarkModal({{ json_encode($student) }})" 
                                        class="px-3.5 py-1.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-sm transition cursor-pointer"
                                    >
                                        <i class="fa-solid fa-phone"></i>
                                        <span>Log Call</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-headset text-3xl mb-2 opacity-40"></i>
                                <p class="text-sm font-semibold text-slate-600">No leads found in your calling queue.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>

    <!-- Modal 1: Log Call & Submit Remark -->
    <div 
        x-show="remarkModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative" @click.outside="remarkModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Log Call & Update Status</h3>
                        <p class="text-xs text-slate-500">Student: <strong class="text-slate-900" x-text="selectedStudent?.name"></strong> (<span x-text="selectedStudent?.phone" class="font-mono text-emerald-600 font-bold"></span>)</p>
                    </div>
                </div>
                <button @click="remarkModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'/telecaller/students/' + selectedStudent?.id + '/remark'" method="POST" class="space-y-4">
                @csrf

                <!-- Quick info box -->
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs space-y-1">
                    <div class="flex justify-between text-slate-700">
                        <span>Father: <strong class="text-slate-900" x-text="selectedStudent?.father_name || 'N/A'"></strong></span>
                        <span>Qualification: <strong class="text-orange-700" x-text="selectedStudent?.qualification || 'N/A'"></strong></span>
                    </div>
                    <p class="text-slate-500 truncate">Address: <span class="text-slate-700" x-text="selectedStudent?.address || 'N/A'"></span></p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Call Outcome *
                        </label>
                        <select name="call_outcome" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="Connected">Connected</option>
                            <option value="Interested">Interested (Wants Counseling)</option>
                            <option value="Callback Requested">Callback Requested</option>
                            <option value="Busy">Busy</option>
                            <option value="Not Reachable">Not Reachable</option>
                            <option value="Switched Off">Switched Off</option>
                            <option value="Wrong Number">Wrong Number</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Converted">Converted (Confirmed Admission)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Update Lead Status *
                        </label>
                        <select name="status" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="Contacted">Contacted</option>
                            <option value="Interested">Interested</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Converted">Converted</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Schedule Next Follow-up (Optional)
                        </label>
                        <div class="flex items-center gap-1.5">
                            <button type="button" @click="setFollowupPreset(4)" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded text-[10px] text-slate-700 font-medium">
                                In 4 Hrs
                            </button>
                            <button type="button" @click="setFollowupPreset(24)" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded text-[10px] text-slate-700 font-medium">
                                Tomorrow
                            </button>
                        </div>
                    </div>
                    <input type="datetime-local" id="telecaller_queue_followup" name="next_followup_at" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Counseling Remarks / Notes *
                    </label>
                    <textarea 
                        name="remarks" 
                        rows="3" 
                        required 
                        placeholder="Write student reaction, preferred course/college, scholarship query, or parent feedback..." 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="remarkModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-md transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-check"></i>
                        <span>Save & Submit Remark</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Call History & Past Remarks -->
    <div 
        x-show="historyModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative" @click.outside="historyModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-timeline"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Call History: <span x-text="selectedStudent?.name" class="text-orange-600"></span></h3>
                        <p class="text-xs text-slate-500">Previous counseling notes and call dispositions</p>
                    </div>
                </div>
                <button @click="historyModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="max-h-72 overflow-y-auto custom-scrollbar space-y-2.5">
                <template x-if="historyRemarks.length === 0">
                    <div class="text-center py-8 text-slate-400 text-xs">
                        No previous remarks on this lead.
                    </div>
                </template>

                <template x-for="rem in historyRemarks" :key="rem.id">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900" x-text="rem.user ? rem.user.name : 'System'"></span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-orange-100 text-orange-700 border border-orange-200 uppercase" x-text="rem.call_outcome"></span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-200 text-slate-700" x-text="rem.status"></span>
                            </div>
                            <span class="text-[10px] text-slate-400" x-text="new Date(rem.created_at).toLocaleString()"></span>
                        </div>
                        <p class="text-slate-700 italic bg-white p-2 rounded-lg border border-slate-200" x-text="rem.remarks"></p>
                        <template x-if="rem.next_followup_at">
                            <p class="text-[10px] text-amber-700 font-bold flex items-center gap-1">
                                <i class="fa-regular fa-calendar-check"></i>
                                <span>Scheduled Next: <strong x-text="new Date(rem.next_followup_at).toLocaleString()"></strong></span>
                            </p>
                        </template>
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-between pt-4 mt-4 border-t border-slate-100">
                <button 
                    type="button" 
                    @click="historyModalOpen = false; openRemarkModal(selectedStudent)" 
                    class="px-4 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm"
                >
                    <i class="fa-solid fa-phone"></i>
                    <span>Log New Call Now</span>
                </button>
                <button type="button" @click="historyModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                    Close
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
