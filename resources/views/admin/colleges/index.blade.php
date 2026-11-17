@extends('layouts.app')

@section('title', 'College Master')
@section('header', 'College Master Management')

@section('content')
<div class="space-y-6" x-data="{
    createModalOpen: false,
    editModalOpen: false,
    deleteModalOpen: false,

    newCollege: {
        name: '',
        code: '',
        city: '',
        state: 'Bihar',
        address: '',
        affiliation: '',
        contact_person: '',
        phone: '',
        email: '',
        website: '',
        is_active: 1,
        notes: ''
    },

    currentCollege: {
        id: null,
        name: '',
        code: '',
        city: '',
        state: 'Bihar',
        address: '',
        affiliation: '',
        contact_person: '',
        phone: '',
        email: '',
        website: '',
        is_active: 1,
        notes: ''
    },

    collegeToDelete: { id: null, name: '' },

    openEditModal(col) {
        this.currentCollege = {
            id: col.id,
            name: col.name || '',
            code: col.code || '',
            city: col.city || '',
            state: col.state || 'Bihar',
            address: col.address || '',
            affiliation: col.affiliation || '',
            contact_person: col.contact_person || '',
            phone: col.phone || '',
            email: col.email || '',
            website: col.website || '',
            is_active: col.is_active ? 1 : 0,
            notes: col.notes || ''
        };
        this.editModalOpen = true;
    },

    confirmDelete(id, name) {
        this.collegeToDelete = { id: id, name: name };
        this.deleteModalOpen = true;
    }
}">

    <!-- Top Summary Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-red-500 to-orange-500 text-white shadow-sm shadow-red-500/20">
                    <i class="fa-solid fa-building-columns text-sm"></i>
                </span>
                <div>
                    <h1 class="text-xl font-bold font-heading text-slate-900">College Master</h1>
                    <p class="text-xs text-slate-500">Manage institutes, universities &amp; admission counseling partner colleges</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button 
                @click="createModalOpen = true"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:opacity-95 text-white shadow-md shadow-red-500/20 transition"
            >
                <i class="fa-solid fa-plus"></i>
                <span>Add New College</span>
            </button>
        </div>
    </div>

    <!-- Quick Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Colleges</p>
                <p class="text-2xl font-black text-slate-900 mt-0.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-base">
                <i class="fa-solid fa-school"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">Active Colleges</p>
                <p class="text-2xl font-black text-emerald-600 mt-0.5">{{ $stats['active'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Inactive Colleges</p>
                <p class="text-2xl font-black text-slate-600 mt-0.5">{{ $stats['inactive'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-pause"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.colleges.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by college name, code, city, affiliation, contact..." 
                    class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                >
            </div>

            <div class="w-full md:w-44">
                <select 
                    name="status" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                    onchange="this.form.submit()"
                >
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>
            </div>

            <button type="submit" class="w-full md:w-auto px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition">
                Filter
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.colleges.index') }}" class="w-full md:w-auto px-3 py-2 text-center text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Colleges Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/70 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4">College / Institute</th>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-4">Affiliation / Board</th>
                        <th class="py-3 px-4">Contact Person</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Bills</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($colleges as $college)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900">{{ $college->name }}</div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    @if($college->code)
                                        <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 font-mono text-[10px] text-slate-600 font-semibold">{{ $college->code }}</span>
                                    @endif
                                    @if($college->website)
                                        <a href="{{ Str::startsWith($college->website, ['http://', 'https://']) ? $college->website : 'https://' . $college->website }}" target="_blank" class="text-[10px] text-blue-600 hover:underline inline-flex items-center gap-1">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i> Website
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-slate-800">{{ $college->city ?: '—' }}{{ $college->state ? ', ' . $college->state : '' }}</div>
                                @if($college->address)
                                    <div class="text-[11px] text-slate-500 line-clamp-1" title="{{ $college->address }}">{{ $college->address }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($college->affiliation)
                                    <span class="inline-block px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-semibold">
                                        {{ $college->affiliation }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($college->contact_person || $college->phone)
                                    <div class="font-semibold text-slate-800">{{ $college->contact_person ?: 'Contact Desk' }}</div>
                                    <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                        @if($college->phone)
                                            <a href="tel:{{ $college->phone }}" class="hover:text-red-600"><i class="fa-solid fa-phone text-[9px]"></i> {{ $college->phone }}</a>
                                        @endif
                                        @if($college->email)
                                            <a href="mailto:{{ $college->email }}" class="hover:text-red-600" title="{{ $college->email }}"><i class="fa-solid fa-envelope text-[9px]"></i></a>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($college->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-block px-2 py-0.5 rounded-lg bg-slate-100 font-bold text-slate-700 text-[11px]">
                                    {{ $college->student_bills_count }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <button 
                                        type="button"
                                        @click="openEditModal({{ Js::from($college) }})"
                                        class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-900 transition"
                                        title="Edit College"
                                    >
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                    <button 
                                        type="button"
                                        @click="confirmDelete({{ $college->id }}, '{{ addslashes($college->name) }}')"
                                        class="p-1.5 rounded-lg hover:bg-red-50 text-slate-400 hover:text-red-600 transition"
                                        title="Delete College"
                                    >
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-lg">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-700">No colleges found</p>
                                <p class="text-xs text-slate-400 mt-1">Get started by creating your first college in College Master.</p>
                                <button 
                                    @click="createModalOpen = true"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 mt-3 rounded-lg text-xs font-semibold bg-red-600 text-white hover:bg-red-700 transition"
                                >
                                    <i class="fa-solid fa-plus text-[10px]"></i> Add College
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($colleges->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $colleges->links() }}
            </div>
        @endif
    </div>

    <!-- ============================================================== -->
    <!-- MODAL 1: ADD NEW COLLEGE -->
    <!-- ============================================================== -->
    <div 
        x-show="createModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
    >
        <div 
            @click.outside="createModalOpen = false"
            class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-xl overflow-hidden my-8"
        >
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Add New College / Institute</h3>
                        <p class="text-[11px] text-slate-500">Record college details to select during student admission billing</p>
                    </div>
                </div>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.colleges.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                @csrf

                <!-- College Name & Code -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">College / Institute Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="newCollege.name" required placeholder="e.g. Netaji Subhas Institute of Technology" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Code / Short Form</label>
                        <input type="text" name="code" x-model="newCollege.code" placeholder="e.g. NSIT" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- City, State, Affiliation -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">City / District</label>
                        <input type="text" name="city" x-model="newCollege.city" placeholder="e.g. Patna, Bihta" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">State</label>
                        <input type="text" name="state" x-model="newCollege.state" value="Bihar" placeholder="Bihar" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Affiliation / Board</label>
                        <input type="text" name="affiliation" x-model="newCollege.affiliation" placeholder="e.g. AICTE / AKU / UGC" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Full Campus Address</label>
                    <textarea name="address" x-model="newCollege.address" rows="2" placeholder="Campus location, nearby landmark, PIN..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"></textarea>
                </div>

                <!-- Contact Person, Phone, Email -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Contact Person</label>
                        <input type="text" name="contact_person" x-model="newCollege.contact_person" placeholder="Admission Officer" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Phone / Mobile</label>
                        <input type="text" name="phone" x-model="newCollege.phone" placeholder="Official contact no." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Email / Website</label>
                        <input type="text" name="email" x-model="newCollege.email" placeholder="admissions@college.edu" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- Status Checkbox -->
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="new_is_active" value="1" checked class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                    <label for="new_is_active" class="font-bold text-slate-700 cursor-pointer">Active (Available for billing &amp; admission selection)</label>
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 border border-slate-200 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:opacity-95 text-white rounded-xl font-bold shadow-md shadow-red-500/20 transition">
                        Save College
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MODAL 2: EDIT COLLEGE -->
    <!-- ============================================================== -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
    >
        <div 
            @click.outside="editModalOpen = false"
            class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-xl overflow-hidden my-8"
        >
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Edit College / Institute</h3>
                        <p class="text-[11px] text-slate-500">Update college information and status</p>
                    </div>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/colleges') }}/' + currentCollege.id" method="POST" class="p-6 space-y-4 text-xs">
                @csrf
                @method('PUT')

                <!-- College Name & Code -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">College / Institute Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="currentCollege.name" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Code / Short Form</label>
                        <input type="text" name="code" x-model="currentCollege.code" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- City, State, Affiliation -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">City / District</label>
                        <input type="text" name="city" x-model="currentCollege.city" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">State</label>
                        <input type="text" name="state" x-model="currentCollege.state" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Affiliation / Board</label>
                        <input type="text" name="affiliation" x-model="currentCollege.affiliation" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Full Campus Address</label>
                    <textarea name="address" x-model="currentCollege.address" rows="2" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"></textarea>
                </div>

                <!-- Contact Person, Phone, Email -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Contact Person</label>
                        <input type="text" name="contact_person" x-model="currentCollege.contact_person" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Phone / Mobile</label>
                        <input type="text" name="phone" x-model="currentCollege.phone" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Email</label>
                        <input type="text" name="email" x-model="currentCollege.email" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500">
                    </div>
                </div>

                <!-- Status Checkbox -->
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" :checked="currentCollege.is_active" class="rounded border-slate-300 text-red-600 focus:ring-red-500">
                    <label for="edit_is_active" class="font-bold text-slate-700 cursor-pointer">Active (Available for billing &amp; admission selection)</label>
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 border border-slate-200 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:opacity-95 text-white rounded-xl font-bold shadow-md shadow-red-500/20 transition">
                        Update College
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- MODAL 3: DELETE CONFIRMATION -->
    <!-- ============================================================== -->
    <div 
        x-show="deleteModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-slate-900/50 backdrop-blur-sm"
    >
        <div 
            @click.outside="deleteModalOpen = false"
            class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-sm overflow-hidden p-6 text-center"
        >
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-3 text-lg">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-sm font-bold text-slate-900">Delete College?</h3>
            <p class="text-xs text-slate-500 mt-1">
                Are you sure you want to delete <strong class="text-slate-800" x-text="collegeToDelete.name"></strong>? This college will be marked inactive/removed from future selection.
            </p>

            <form :action="'{{ url('admin/colleges') }}/' + collegeToDelete.id" method="POST" class="mt-5 flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    Confirm Delete
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
