@extends('layouts.app')

@section('title', 'Counselor Calling Dashboard')
@section('header', 'My Calling Dashboard')

@section('content')
<div class="space-y-6" x-data="{
    remarkModalOpen: false,
    selectedStudent: null,
    openRemarkModal(student) {
        this.selectedStudent = student;
        this.remarkModalOpen = true;
    },
    setFollowupPreset(hours) {
        const d = new Date();
        d.setHours(d.getHours() + hours);
        const iso = d.toISOString().slice(0, 16);
        const input = document.getElementById('telecaller_modal_followup');
        if (input) input.value = iso;
    }
}">

    @if(isset($isAdmin) && $isAdmin)
        <!-- Admin Workspace Switcher Bar -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base shadow-sm shrink-0">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-amber-950 uppercase tracking-wide flex items-center gap-1.5">
                        <span>Admin Inspection Mode</span>
                        <span class="px-2 py-0.5 rounded-full bg-amber-200/80 text-[10px] font-bold text-amber-900">Viewing as Staff</span>
                    </h4>
                    <p class="text-xs text-amber-800 mt-0.5">
                        You are viewing the personal dashboard of: <strong class="text-amber-950 font-bold">{{ $targetUser->name }}</strong> ({{ $targetUser->email }})
                    </p>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-2.5">
                <form method="GET" action="{{ route('telecaller.dashboard') }}" class="flex items-center gap-2">
                    <label class="text-xs font-bold text-amber-900 whitespace-nowrap">Switch User:</label>
                    <select name="user_id" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-amber-300 rounded-xl text-xs font-semibold text-slate-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 cursor-pointer">
                        @foreach($telecallers as $t)
                            <option value="{{ $t->id }}" {{ $targetUser->id == $t->id ? 'selected' : '' }}>
                                {{ $t->name }} ({{ $t->assigned_students_count ?? $t->assignedStudents->count() }} leads)
                            </option>
                        @endforeach
                    </select>
                </form>

                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 bg-white hover:bg-amber-100 text-amber-900 border border-amber-300 rounded-xl text-xs font-semibold transition shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-users"></i>
                    <span>Staff List</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to Admin Dashboard</span>
                </a>
            </div>
        </div>
    @endif

    <!-- Welcome & Quick Stats Banner -->
    <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-600 via-orange-500 to-amber-500"></div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5 relative z-10 pt-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-red-600 via-orange-500 to-amber-500 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-orange-50 text-orange-700 border border-orange-200">
                        Uddan Telecaller Desk
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black font-heading text-slate-900 mt-1">
                        {{ isset($isAdmin) && $isAdmin ? 'Counselor Desk:' : 'Welcome,' }} <span class="text-orange-600">{{ $targetUser->name ?? auth()->user()->name }}</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daily calling queue, today's callbacks, and student counseling conversion status.</p>
                </div>
            </div>

            <a 
                href="{{ route('telecaller.students.index', isset($targetUser) && isset($isAdmin) && $isAdmin ? ['user_id' => $targetUser->id] : []) }}" 
                class="px-5 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2 self-start sm:self-auto cursor-pointer"
            >
                <i class="fa-solid fa-phone-volume"></i>
                <span>Open Calling Queue</span>
            </a>
        </div>
    </div>

    <!-- Personal KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Total Assigned -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">My Assigned Leads</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 mt-1.5">{{ $totalAssigned }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Total In Pipeline</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-address-book"></i>
                </div>
            </div>
        </div>

        <!-- Pending New Calls -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">New / Uncalled</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-orange-600 mt-1.5">{{ $pendingCalls }}</h3>
                    <p class="text-[11px] text-orange-700 font-semibold mt-1">Ready for First Call</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-phone-arrow-up-right"></i>
                </div>
            </div>
        </div>

        <!-- Follow-ups Today -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Follow-ups Today</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-amber-600 mt-1.5">{{ $followupsToday }}</h3>
                    <p class="text-[11px] text-amber-700 font-semibold mt-1">Due For Calling</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bell"></i>
                </div>
            </div>
        </div>

        <!-- Converted -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Confirmed Admissions</p>
                    <h3 class="text-2xl sm:text-3xl font-extrabold font-heading text-emerald-600 mt-1.5">{{ $convertedCount }}</h3>
                    <p class="text-[11px] text-emerald-700 font-semibold mt-1">Converted Leads</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Main 2-Column Section: Today's Follow-ups & Fresh Leads -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Today's Follow-ups Due -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold font-heading text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-amber-600"></i>
                        <span>Today's Follow-up Schedule</span>
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                        {{ $todayFollowups->count() }} Due
                    </span>
                </div>

                <div class="space-y-2.5">
                    @forelse($todayFollowups as $student)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 hover:border-slate-300 transition flex items-center justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="font-bold text-slate-900 text-xs">{{ $student->name }}</p>
                                    @if($student->father_name)
                                        <span class="text-[11px] text-slate-500">({{ $student->father_name }})</span>
                                    @endif
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $student->status_badge_class }}">
                                        {{ $student->status }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3 mt-1">
                                    <p class="font-mono text-emerald-600 text-xs font-bold">
                                        <i class="fa-solid fa-phone text-[10px]"></i> {{ $student->phone }}
                                    </p>
                                    @if($student->whatsapp_no)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->whatsapp_no) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 text-xs font-medium">
                                            <i class="fa-brands fa-whatsapp"></i> WA
                                        </a>
                                    @endif
                                </div>
                                @if($student->current_remarks)
                                    <p class="text-[11px] text-slate-600 truncate max-w-xs mt-1 italic">"{{ $student->current_remarks }}"</p>
                                @endif
                            </div>

                            <button 
                                type="button" 
                                @click="openRemarkModal({{ json_encode($student) }})" 
                                class="px-3.5 py-2 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-sm transition shrink-0 cursor-pointer"
                            >
                                <i class="fa-solid fa-phone"></i>
                                <span>Log Call</span>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            <i class="fa-solid fa-calendar-check text-2xl mb-2 opacity-50"></i>
                            <p>No follow-ups scheduled for today.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
                <a href="{{ route('telecaller.students.index', ['followup' => 'today']) }}" class="text-xs text-orange-600 hover:underline font-bold">
                    View All Due Follow-ups →
                </a>
            </div>
        </div>

        <!-- Fresh / New Assigned Leads -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold font-heading text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-sparkles text-orange-600"></i>
                        <span>New Uncontacted Leads</span>
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-50 text-orange-700 border border-orange-200">
                        {{ $newAssignedLeads->count() }} New
                    </span>
                </div>

                <div class="space-y-2.5">
                    @forelse($newAssignedLeads as $student)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 hover:border-slate-300 transition flex items-center justify-between gap-3">
                            <div>
                                <p class="font-bold text-slate-900 text-xs">{{ $student->name }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="font-mono text-emerald-600 text-xs font-bold">
                                        <i class="fa-solid fa-phone text-[10px]"></i> {{ $student->phone }}
                                    </span>
                                    <span class="text-[10px] text-slate-500 font-medium">({{ $student->qualification ?? '12th' }})</span>
                                </div>
                                <p class="text-[11px] text-slate-500 mt-0.5 truncate max-w-xs">{{ $student->address ?? 'Location N/A' }}</p>
                            </div>

                            <button 
                                type="button" 
                                @click="openRemarkModal({{ json_encode($student) }})" 
                                class="px-3.5 py-2 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-sm transition shrink-0 cursor-pointer"
                            >
                                <i class="fa-solid fa-phone"></i>
                                <span>First Call</span>
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            <i class="fa-solid fa-circle-check text-2xl mb-2 opacity-50"></i>
                            <p>No new pending leads in your queue. All caught up!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex justify-end">
                <a href="{{ route('telecaller.students.index', ['status' => 'New']) }}" class="text-xs text-orange-600 hover:underline font-bold">
                    View All New Leads →
                </a>
            </div>
        </div>

    </div>

    <!-- Telecaller Log Call & Remarks Modal -->
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
                        <h3 class="text-lg font-bold text-slate-900">Log Call: <span x-text="selectedStudent?.name" class="text-orange-600"></span></h3>
                        <p class="text-xs text-slate-500">Phone: <span x-text="selectedStudent?.phone" class="font-mono text-emerald-600 font-bold"></span></p>
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
                    <input type="datetime-local" id="telecaller_modal_followup" name="next_followup_at" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Counseling Discussion Remarks *
                    </label>
                    <textarea 
                        name="remarks" 
                        rows="3" 
                        required 
                        placeholder="Write student feedback, parent questions, preferred course/college, fee or scholarship queries..." 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="remarkModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-md transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-check"></i>
                        <span>Submit Call Remark</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
