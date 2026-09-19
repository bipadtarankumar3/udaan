@extends('layouts.app')

@section('title', 'Staff & User Directory')
@section('header', 'Staff & User Directory')

@section('content')
<div class="space-y-6" x-data="{
    createModalOpen: false,
    editModalOpen: false,
    currentUser: { id: null, name: '', email: '', phone: '', role: '', status: 'active' },
    openEditModal(user) {
        this.currentUser = {
            id: user.id,
            name: user.name,
            email: user.email,
            phone: user.phone || '',
            role: user.roles && user.roles.length ? user.roles[0].name : '',
            status: user.status
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Header & Filters -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold font-heading text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-users-gear text-orange-600"></i>
                    <span>Counselors & Team Directory</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Manage Telecallers, Admission Counselors, and Administrative Staff</p>
            </div>
            <button 
                @click="createModalOpen = true" 
                class="px-4 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition cursor-pointer self-start sm:self-auto"
            >
                <i class="fa-solid fa-user-plus"></i>
                <span>Add Staff Member</span>
            </button>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-3 border-t border-slate-100">
            <div class="sm:col-span-5 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by name, email, phone..." 
                    class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                >
            </div>

            <div class="sm:col-span-3">
                <select 
                    name="role" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                    onchange="this.form.submit()"
                >
                    <option value="">All Roles</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ request('role') == $r->name ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <select 
                    name="status" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                    onchange="this.form.submit()"
                >
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold border border-slate-200 transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs border border-slate-200 transition" title="Clear Filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 pl-5">Staff Member</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4">Contact Phone</th>
                        <th class="py-3.5 px-4 text-center">Assigned Leads</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4">Joined Date</th>
                        <th class="py-3.5 pr-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        @php
                            $roleName = $user->roles->pluck('name')->first() ?? 'Staff';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 pl-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full {{ $roleName === 'Super Admin' ? 'bg-red-50 text-red-600 border border-red-200' : ($roleName === 'Telecaller' ? 'bg-orange-50 text-orange-600 border border-orange-200' : 'bg-amber-50 text-amber-600 border border-amber-200') }} flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">{{ $user->name }}</p>
                                        <p class="text-slate-500 text-[11px]">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $roleName === 'Super Admin' ? 'bg-red-50 text-red-700 border border-red-200' : ($roleName === 'Telecaller' ? 'bg-orange-50 text-orange-700 border border-orange-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                    <i class="fa-solid {{ $roleName === 'Telecaller' ? 'fa-headset' : 'fa-shield' }} mr-1"></i>
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-mono">
                                {{ $user->phone ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($roleName === 'Telecaller')
                                    <span class="px-2.5 py-0.5 rounded-full bg-orange-50 text-orange-700 font-semibold border border-orange-200">
                                        {{ $user->assignedStudents->count() }} leads
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($user->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-[10px] font-bold uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 pr-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($roleName === 'Telecaller')
                                        <a 
                                            href="{{ route('telecaller.dashboard', ['user_id' => $user->id]) }}" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-orange-50 hover:bg-orange-100 text-orange-700 border border-orange-200 text-xs font-semibold transition" 
                                            title="Visit {{ $user->name }}'s Dashboard"
                                        >
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    @endif

                                    <button 
                                        type="button" 
                                        @click="openEditModal({{ json_encode($user) }})" 
                                        class="p-1.5 text-slate-400 hover:text-orange-600 hover:bg-slate-100 rounded-lg transition" 
                                        title="Edit User"
                                    >
                                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                                    </button>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete user {{ $user->name }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition" title="Delete User">
                                                <i class="fa-regular fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-500">
                                <i class="fa-solid fa-users text-3xl mb-2 text-slate-300"></i>
                                <p class="text-sm">No staff accounts found matching filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Create User Modal -->
    <div 
        x-show="createModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative" @click.outside="createModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Add Staff Member</h3>
                        <p class="text-xs text-slate-500">Create login account for Counselor or Admin</p>
                    </div>
                </div>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Full Name *
                    </label>
                    <input type="text" name="name" required placeholder="e.g. Priya Sharma" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Email Address *
                        </label>
                        <input type="email" name="email" required placeholder="name@uddan.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Phone Number
                        </label>
                        <input type="text" name="phone" placeholder="+91 9876543210" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Role Assignment *
                        </label>
                        <select name="role" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}" {{ $r->name === 'Telecaller' ? 'selected' : '' }}>
                                    {{ $r->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Account Status *
                        </label>
                        <select name="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Password *
                    </label>
                    <input type="password" name="password" required minlength="6" placeholder="••••••••" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-sm transition cursor-pointer">
                        Save Member
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative" @click.outside="editModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Edit User: <span x-text="currentUser.name" class="text-orange-600"></span></h3>
                        <p class="text-xs text-slate-500">Update account credentials and role assignments</p>
                    </div>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'/admin/users/' + currentUser.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Full Name *
                    </label>
                    <input type="text" name="name" x-model="currentUser.name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Email Address *
                        </label>
                        <input type="email" name="email" x-model="currentUser.email" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Phone Number
                        </label>
                        <input type="text" name="phone" x-model="currentUser.phone" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Role Assignment *
                        </label>
                        <select name="role" x-model="currentUser.role" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                            Account Status *
                        </label>
                        <select name="status" x-model="currentUser.status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        New Password <span class="text-slate-500 font-normal lowercase">(leave blank to keep existing)</span>
                    </label>
                    <input type="password" name="password" minlength="6" placeholder="••••••••" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-sm transition cursor-pointer">
                        Update Member
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
