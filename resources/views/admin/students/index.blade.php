@extends('layouts.app')

@section('title', 'Students Counseling Leads')
@section('header', 'Bihar Students Counseling Management')

@section('content')
<div class="space-y-6" x-data="{
    createModalOpen: false,
    bulkUploadModalOpen: false,
    bulkAssignModalOpen: false,
    editModalOpen: false,
    remarksModalOpen: false,
    selectedStudents: [],
    selectAll: false,
    currentStudent: { 
        id: null, 
        name: '', 
        father_name: '', 
        dob: '', 
        phone: '', 
        whatsapp_no: '', 
        qualification: '', 
        gender: '', 
        address: '', 
        city: '', 
        course_interested: '', 
        source: 'Counseling Form', 
        status: 'New', 
        priority: 'Medium', 
        assigned_to: '' 
    },
    activeRemarksStudent: null,
    activeRemarksList: [],

    toggleSelectAll() {
        if (this.selectAll) {
            this.selectedStudents = Array.from(document.querySelectorAll('.student-checkbox')).map(el => parseInt(el.value));
        } else {
            this.selectedStudents = [];
        }
    },
    updateSelectAll() {
        const totalCheckboxes = document.querySelectorAll('.student-checkbox').length;
        this.selectAll = totalCheckboxes > 0 && this.selectedStudents.length === totalCheckboxes;
    },
    openEditModal(student) {
        this.currentStudent = {
            id: student.id,
            name: student.name,
            father_name: student.father_name || '',
            dob: student.dob ? student.dob.substring(0, 10) : '',
            phone: student.phone,
            whatsapp_no: student.whatsapp_no || '',
            qualification: student.qualification || '',
            gender: student.gender || '',
            address: student.address || '',
            city: student.city || '',
            course_interested: student.course_interested || '',
            source: student.source || 'Counseling Form',
            status: student.status,
            priority: student.priority,
            assigned_to: student.assigned_to || ''
        };
        this.editModalOpen = true;
    },
    openRemarksModal(student) {
        this.activeRemarksStudent = student;
        this.activeRemarksList = student.remarks || [];
        this.remarksModalOpen = true;
    }
}">

    <!-- Top Action Header & Quick Metrics -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm space-y-4">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-orange-50 text-orange-700 border border-orange-200 text-[10px] font-bold uppercase tracking-wider">
                        Awareness Program 2025
                    </span>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 flex items-center gap-2 mt-1">
                    <i class="fa-solid fa-graduation-cap text-orange-600"></i>
                    <span>Students Counseling & Lead Distribution</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Manage student applications, bulk upload CSV, and assign leads to telecallers</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center flex-wrap gap-2.5">
                <a 
                    href="{{ route('admin.students.sample-csv') }}" 
                    class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition"
                    title="Download template for bulk upload"
                >
                    <i class="fa-solid fa-file-csv text-orange-600"></i>
                    <span>Sample CSV</span>
                </a>

                <button 
                    type="button" 
                    @click="bulkUploadModalOpen = true" 
                    class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer"
                >
                    <i class="fa-solid fa-cloud-arrow-up text-amber-600"></i>
                    <span>Bulk Upload (CSV)</span>
                </button>

                <button 
                    type="button" 
                    @click="createModalOpen = true" 
                    class="px-4 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm shadow-red-500/20 transition cursor-pointer"
                >
                    <i class="fa-solid fa-plus"></i>
                    <span>Apply / Add Student</span>
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 pt-3 border-t border-slate-100">
            <!-- Search -->
            <div class="lg:col-span-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search name, father name, mobile, address..." 
                    class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white" onchange="this.form.submit()">
                    <option value="">All Call Statuses</option>
                    @foreach(['New', 'Contacted', 'Interested', 'Follow-up', 'Not Interested', 'Converted', 'Closed'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Qualification Filter -->
            <div>
                <select name="qualification" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white" onchange="this.form.submit()">
                    <option value="">All Qualifications</option>
                    <option value="10th Pass" {{ request('qualification') == '10th Pass' ? 'selected' : '' }}>10th Pass</option>
                    <option value="12th Appearing" {{ request('qualification') == '12th Appearing' ? 'selected' : '' }}>12th Appearing</option>
                    <option value="12th Pass" {{ request('qualification') == '12th Pass' ? 'selected' : '' }}>12th Pass</option>
                    <option value="Graduation" {{ request('qualification') == 'Graduation' ? 'selected' : '' }}>Graduation</option>
                    <option value="Diploma" {{ request('qualification') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                </select>
            </div>

            <!-- Telecaller Filter -->
            <div>
                <select name="assigned_to" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white" onchange="this.form.submit()">
                    <option value="">All Telecallers</option>
                    <option value="unassigned" {{ request('assigned_to') == 'unassigned' ? 'selected' : '' }}>⚡ Unassigned Leads</option>
                    @foreach($telecallers as $t)
                        <option value="{{ $t->id }}" {{ request('assigned_to') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter actions -->
            <div class="flex items-center gap-2">
                <button type="submit" class="w-full px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold border border-slate-200 transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'qualification', 'assigned_to', 'priority']))
                    <a href="{{ route('admin.students.index') }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 rounded-xl text-xs border border-slate-200 transition" title="Reset Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Multi-Select Bulk Assignment Action Bar -->
    <div 
        x-show="selectedStudents.length > 0" 
        x-cloak 
        class="bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 rounded-2xl p-4 shadow-lg text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3 animate-fadeIn"
    >
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-white/20 text-white flex items-center justify-center font-bold text-sm">
                <span x-text="selectedStudents.length"></span>
            </div>
            <div>
                <p class="text-xs font-bold text-white"><span x-text="selectedStudents.length"></span> Student Application(s) Selected</p>
                <p class="text-[11px] text-orange-100">Assign selected applicants to a telecaller in one click</p>
            </div>
        </div>

        <form action="{{ route('admin.students.bulk-assign') }}" method="POST" class="flex items-center gap-2.5">
            @csrf
            <template x-for="id in selectedStudents" :key="id">
                <input type="hidden" name="student_ids[]" :value="id">
            </template>

            <select name="telecaller_id" required class="px-3 py-2 bg-white text-slate-900 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-white">
                <option value="">Select Telecaller...</option>
                @foreach($telecallers as $t)
                    <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->phone ?? 'Telecaller' }})</option>
                @endforeach
            </select>

            <button 
                type="submit" 
                class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-md transition cursor-pointer flex items-center gap-1.5"
            >
                <i class="fa-solid fa-user-check"></i>
                <span>Assign Selected</span>
            </button>
        </form>
    </div>

    <!-- Students DataTable -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 pl-4 w-10 text-center">
                            <input 
                                type="checkbox" 
                                x-model="selectAll" 
                                @change="toggleSelectAll()" 
                                class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                            >
                        </th>
                        <th class="py-3.5 px-3">Student & Father Name</th>
                        <th class="py-3.5 px-3">Mobile & WhatsApp</th>
                        <th class="py-3.5 px-3">DOB & Gender</th>
                        <th class="py-3.5 px-3">Qualification</th>
                        <th class="py-3.5 px-3">Address</th>
                        <th class="py-3.5 px-3 text-center">Status</th>
                        <th class="py-3.5 px-3">Assigned Telecaller</th>
                        <th class="py-3.5 px-3">Latest Remarks</th>
                        <th class="py-3.5 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 pl-4 text-center">
                                <input 
                                    type="checkbox" 
                                    value="{{ $student->id }}" 
                                    x-model="selectedStudents" 
                                    @change="updateSelectAll()" 
                                    class="student-checkbox w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                                >
                            </td>
                            <td class="py-3.5 px-3">
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $student->name }}</p>
                                    @if($student->father_name)
                                        <p class="text-[11px] text-slate-500">Father: <span class="text-slate-700 font-medium">{{ $student->father_name }}</span></p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-3">
                                <div class="flex items-center gap-2">
                                    <a href="tel:{{ $student->phone }}" class="font-mono text-emerald-600 hover:text-emerald-700 font-bold text-xs flex items-center gap-1">
                                        <i class="fa-solid fa-phone text-[10px]"></i>
                                        <span>{{ $student->phone }}</span>
                                    </a>
                                    @if($student->whatsapp_no)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->whatsapp_no) }}" target="_blank" class="text-emerald-500 hover:text-emerald-600" title="WhatsApp">
                                            <i class="fa-brands fa-whatsapp text-sm"></i>
                                        </a>
                                    @endif
                                </div>
                                @if($student->whatsapp_no && $student->whatsapp_no !== $student->phone)
                                    <p class="font-mono text-slate-400 text-[10px] mt-0.5">WA: {{ $student->whatsapp_no }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-3">
                                <p class="text-slate-700">{{ $student->dob ? $student->dob->format('d M Y') : '—' }}</p>
                                <p class="text-[11px] text-slate-500">{{ $student->gender ?? '—' }}</p>
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 border border-slate-200 font-medium text-[11px]">
                                    {{ $student->qualification ?? 'General' }}
                                </span>
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
                                @if($student->assignedTelecaller)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-700 border border-orange-200 flex items-center justify-center text-[10px] font-bold">
                                            {{ substr($student->assignedTelecaller->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-xs">{{ $student->assignedTelecaller->name }}</p>
                                            <p class="text-[10px] text-slate-400">{{ $student->assigned_at?->diffForHumans() ?? 'Assigned' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-orange-50 border border-orange-200 text-orange-700 text-[10px] font-semibold">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Unassigned
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-3 max-w-xs">
                                @if($student->current_remarks)
                                    <p class="text-[11px] text-slate-700 truncate" title="{{ $student->current_remarks }}">
                                        "{{ $student->current_remarks }}"
                                    </p>
                                    <button 
                                        type="button" 
                                        @click="openRemarksModal({{ json_encode($student) }})" 
                                        class="text-[10px] text-orange-600 hover:underline font-bold mt-0.5 flex items-center gap-1"
                                    >
                                        <i class="fa-solid fa-timeline"></i>
                                        <span>View {{ $student->remarks->count() }} Remark(s)</span>
                                    </button>
                                @else
                                    <button 
                                        type="button" 
                                        @click="openRemarksModal({{ json_encode($student) }})" 
                                        class="text-[11px] text-slate-400 hover:text-slate-600 italic flex items-center gap-1"
                                    >
                                        <i class="fa-regular fa-comment-dots"></i>
                                        <span>Add remarks</span>
                                    </button>
                                @endif
                            </td>
                            <td class="py-3.5 pr-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button 
                                        type="button" 
                                        @click="openRemarksModal({{ json_encode($student) }})" 
                                        class="p-1.5 text-slate-400 hover:text-orange-600 hover:bg-slate-100 rounded-lg transition" 
                                        title="View Remarks & History"
                                    >
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </button>

                                    <button 
                                        type="button" 
                                        @click="openEditModal({{ json_encode($student) }})" 
                                        class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-slate-100 rounded-lg transition" 
                                        title="Edit Student"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete student {{ $student->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition" title="Delete Student">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-graduation-cap text-3xl mb-2 opacity-40"></i>
                                <p class="text-sm font-semibold text-slate-600">No student counseling records found.</p>
                                <p class="text-xs text-slate-400 mt-1">Use 'Apply / Add Student' or 'Bulk Upload (CSV)' to add records.</p>
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

    <!-- Modal 1: Apply / Add Student (Matching Bihar Students Form Fields) -->
    <div 
        x-show="createModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative" @click.outside="createModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Apply for Counselling / Add Student</h3>
                        <p class="text-xs text-slate-500">Bihar Students Counselling Centre Form</p>
                    </div>
                </div>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Row 1: Name & Father Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Name: <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" required placeholder="Enter student's full name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Father Name: <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="father_name" required placeholder="Enter father's name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <!-- Row 2: Date of Birth & Mobile No -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Date of Birth: <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="dob" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Mobile No: <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="phone" required placeholder="10-digit mobile number" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <!-- Row 3: Whatsapp No & Qualification -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Whatsapp No: <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" name="whatsapp_no" required placeholder="WhatsApp contact number" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Qualification: <span class="text-rose-500">*</span>
                        </label>
                        <select name="qualification" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="">Select Qualification</option>
                            <option value="10th Pass">10th Pass</option>
                            <option value="12th Appearing">12th Appearing</option>
                            <option value="12th Pass">12th Pass (Science)</option>
                            <option value="12th Pass (Arts/Commerce)">12th Pass (Arts/Commerce)</option>
                            <option value="Graduation (Pursuing)">Graduation (Pursuing)</option>
                            <option value="Graduation Completed">Graduation Completed</option>
                            <option value="Diploma / Polytechnic">Diploma / Polytechnic</option>
                            <option value="Post Graduation">Post Graduation</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Row 4: Gender & Address -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Gender: <span class="text-rose-500">*</span>
                        </label>
                        <select name="gender" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Address: <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="address" required placeholder="Village/Town, Post Office, District" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <!-- Extra CRM & Assignment Row -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Course / Stream Interested
                        </label>
                        <input type="text" name="course_interested" placeholder="e.g. B.Tech, Nursing, BCA" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Lead Source
                        </label>
                        <input type="text" name="source" value="Counseling Form" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Assign To Telecaller
                        </label>
                        <select name="assigned_to" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="">Leave Unassigned</option>
                            @foreach($telecallers as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="status" value="New">
                <input type="hidden" name="priority" value="Medium">

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-md shadow-red-500/20 transition cursor-pointer">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Bulk Upload CSV -->
    <div 
        x-show="bulkUploadModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative" @click.outside="bulkUploadModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Bulk Upload Students via CSV</h3>
                        <p class="text-xs text-slate-500">Import student counseling applications</p>
                    </div>
                </div>
                <button @click="bulkUploadModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.students.bulk-upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="p-4 bg-orange-50 border border-orange-200 rounded-2xl flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-900">Need the correct column format?</p>
                        <p class="text-[11px] text-orange-800">Contains: name, father_name, date_of_birth, mobile_no, whatsapp_no, qualification, gender, address.</p>
                    </div>
                    <a href="{{ route('admin.students.sample-csv') }}" class="px-3 py-1.5 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 transition shrink-0 ml-2">
                        <i class="fa-solid fa-download"></i>
                        <span>Template</span>
                    </a>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Select CSV File *
                    </label>
                    <input 
                        type="file" 
                        name="csv_file" 
                        required 
                        accept=".csv,.txt" 
                        class="w-full px-4 py-3 bg-slate-50 border border-dashed border-slate-300 rounded-2xl text-slate-700 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-600 file:text-white hover:file:bg-red-700 cursor-pointer"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Default Telecaller Assignment (Optional)
                    </label>
                    <select name="default_telecaller_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                        <option value="">Leave Unassigned (Distribute Later)</option>
                        @foreach($telecallers as $t)
                            <option value="{{ $t->id }}">Auto-assign all to {{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="bulkUploadModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-sm shadow-red-500/20 transition cursor-pointer flex items-center gap-1.5">
                        <i class="fa-solid fa-file-import"></i>
                        <span>Start CSV Import</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Edit Student -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative" @click.outside="editModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Edit Student: <span x-text="currentStudent.name" class="text-orange-600"></span></h3>
                        <p class="text-xs text-slate-500">Update counseling details and assignment</p>
                    </div>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'/admin/students/' + currentStudent.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Row 1 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Name *</label>
                        <input type="text" name="name" x-model="currentStudent.name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Father Name</label>
                        <input type="text" name="father_name" x-model="currentStudent.father_name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Date of Birth</label>
                        <input type="date" name="dob" x-model="currentStudent.dob" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mobile No *</label>
                        <input type="tel" name="phone" x-model="currentStudent.phone" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Whatsapp No</label>
                        <input type="tel" name="whatsapp_no" x-model="currentStudent.whatsapp_no" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Qualification</label>
                        <select name="qualification" x-model="currentStudent.qualification" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="">Select Qualification</option>
                            <option value="10th Pass">10th Pass</option>
                            <option value="12th Appearing">12th Appearing</option>
                            <option value="12th Pass">12th Pass</option>
                            <option value="Graduation (Pursuing)">Graduation (Pursuing)</option>
                            <option value="Graduation Completed">Graduation Completed</option>
                            <option value="Diploma / Polytechnic">Diploma / Polytechnic</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gender</label>
                        <select name="gender" x-model="currentStudent.gender" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address</label>
                        <input type="text" name="address" x-model="currentStudent.address" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <!-- Row 5: Status & Telecaller -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status *</label>
                        <select name="status" x-model="currentStudent.status" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            @foreach(['New', 'Contacted', 'Interested', 'Follow-up', 'Not Interested', 'Converted', 'Closed'] as $st)
                                <option value="{{ $st }}">{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Priority</label>
                        <select name="priority" x-model="currentStudent.priority" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Assigned Telecaller</label>
                        <select name="assigned_to" x-model="currentStudent.assigned_to" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="">Leave Unassigned</option>
                            @foreach($telecallers as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="source" x-model="currentStudent.source">

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-sm shadow-red-500/20 transition cursor-pointer">
                        Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 4: Remarks History & Add Remark -->
    <div 
        x-show="remarksModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-2xl w-full p-6 shadow-2xl relative" @click.outside="remarksModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Remarks Timeline: <span x-text="activeRemarksStudent?.name" class="text-orange-600"></span></h3>
                        <p class="text-xs text-slate-500">Chronological call log and counseling notes</p>
                    </div>
                </div>
                <button @click="remarksModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Add Remark Form -->
            <form :action="'/admin/students/' + activeRemarksStudent?.id + '/remark'" method="POST" class="mb-6 p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Call / Action Outcome *</label>
                        <select name="call_outcome" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="Connected">Connected</option>
                            <option value="Interested">Interested</option>
                            <option value="Callback Requested">Callback Requested</option>
                            <option value="Busy">Busy</option>
                            <option value="Not Reachable">Not Reachable</option>
                            <option value="Switched Off">Switched Off</option>
                            <option value="Not Interested">Not Interested</option>
                            <option value="Converted">Converted</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Update Status *</label>
                        <select name="status" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                            @foreach(['New', 'Contacted', 'Interested', 'Follow-up', 'Not Interested', 'Converted', 'Closed'] as $st)
                                <option value="{{ $st }}">{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Next Follow-up</label>
                        <input type="datetime-local" name="next_followup_at" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Add Note / Remark *</label>
                    <textarea name="remarks" rows="2" required placeholder="Write details about the counseling conversation..." class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                        Post Remark
                    </button>
                </div>
            </form>

            <!-- Remarks History List -->
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Previous Remarks History</h4>
                
                <div class="max-h-64 overflow-y-auto custom-scrollbar space-y-2.5 pr-1">
                    <template x-if="activeRemarksList.length === 0">
                        <div class="text-center py-6 text-slate-400 text-xs">
                            No previous remarks logged for this student.
                        </div>
                    </template>

                    <template x-for="rem in activeRemarksList" :key="rem.id">
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
                                    <span>Follow-up scheduled: <strong x-text="new Date(rem.next_followup_at).toLocaleString()"></strong></span>
                                </p>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex justify-end pt-4 mt-4 border-t border-slate-100">
                <button type="button" @click="remarksModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                    Close
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
