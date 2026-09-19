@extends('layouts.app')

@section('title', 'Roles & Permissions')
@section('header', 'Role-Based Access Control')

@section('content')
<div class="space-y-6" x-data="{ 
    createModalOpen: false, 
    editModalOpen: false,
    currentRole: { id: null, name: '', permissions: [] },
    openEditModal(role) {
        this.currentRole = {
            id: role.id,
            name: role.name,
            permissions: role.permissions.map(p => p.name)
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm">
        <div>
            <h3 class="text-lg font-bold font-heading text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-orange-600"></i>
                <span>Roles & Permissions Security Matrix</span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Manage administrative privileges, counselor permissions, and access controls</p>
        </div>
        <button 
            @click="createModalOpen = true" 
            class="px-4 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition cursor-pointer self-start sm:self-auto"
        >
            <i class="fa-solid fa-plus"></i>
            <span>Create New Role</span>
        </button>
    </div>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($roles as $role)
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $role->name === 'Super Admin' ? 'bg-red-50 text-red-600 border border-red-200' : ($role->name === 'Telecaller' ? 'bg-orange-50 text-orange-600 border border-orange-200' : 'bg-amber-50 text-amber-600 border border-amber-200') }} flex items-center justify-center text-lg">
                                <i class="fa-solid {{ $role->name === 'Telecaller' ? 'fa-headset' : 'fa-shield-halved' }}"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-900">{{ $role->name }}</h4>
                                <p class="text-xs text-slate-500">{{ $role->users_count }} member(s) assigned</p>
                            </div>
                        </div>

                        @if(!in_array($role->name, ['Super Admin']))
                            <div class="flex items-center gap-1.5">
                                <button 
                                    type="button" 
                                    @click="openEditModal({{ json_encode($role) }})" 
                                    class="p-1.5 text-slate-400 hover:text-orange-600 hover:bg-slate-100 rounded-lg transition"
                                    title="Edit Role"
                                >
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                
                                @if(!in_array($role->name, ['Admin', 'Telecaller']))
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Delete role {{ $role->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition" title="Delete Role">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Assigned Permissions -->
                    <div class="mt-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-2">Capabilities ({{ $role->permissions->count() }})</p>
                        <div class="flex flex-wrap gap-1.5 max-h-40 overflow-y-auto custom-scrollbar p-1">
                            @forelse($role->permissions as $perm)
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $perm->name }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic">No permissions assigned</span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Footer Card -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-users text-slate-400"></i>
                        <span>{{ $role->users_count }} active user(s)</span>
                    </span>
                    <button 
                        type="button" 
                        @click="openEditModal({{ json_encode($role) }})" 
                        class="text-orange-600 hover:text-orange-700 font-bold"
                    >
                        Edit Access →
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Create Role Modal -->
    <div 
        x-show="createModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-xl w-full p-6 shadow-2xl relative" @click.outside="createModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-shield-plus"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Create New Role</h3>
                        <p class="text-xs text-slate-500">Define role profile and assign permissions</p>
                    </div>
                </div>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Role Name *
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        required 
                        placeholder="e.g. Telecaller Team Lead, Academic Counselor" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Assign Permissions
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-60 overflow-y-auto custom-scrollbar p-1 bg-slate-50 rounded-xl border border-slate-200 p-3">
                        @foreach($permissions as $perm)
                            <label class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-100 cursor-pointer text-xs text-slate-700 select-none">
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $perm->name }}" 
                                    class="mt-0.5 w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                                >
                                <div>
                                    <p class="font-bold text-slate-900">{{ $perm->name }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button 
                        type="button" 
                        @click="createModalOpen = false" 
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-sm transition cursor-pointer"
                    >
                        Save Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
    >
        <div class="bg-white border border-slate-200 rounded-3xl max-w-xl w-full p-6 shadow-2xl relative" @click.outside="editModalOpen = false">
            <div class="flex items-center justify-between mb-5 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 border border-orange-200 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Edit Role: <span x-text="currentRole.name" class="text-orange-600"></span></h3>
                        <p class="text-xs text-slate-500">Update role privileges and permissions</p>
                    </div>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'/admin/roles/' + currentRole.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Role Name *
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        x-model="currentRole.name" 
                        required 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Permissions
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 max-h-60 overflow-y-auto custom-scrollbar p-1 bg-slate-50 rounded-xl border border-slate-200 p-3">
                        @foreach($permissions as $perm)
                            <label class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-100 cursor-pointer text-xs text-slate-700 select-none">
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $perm->name }}" 
                                    :checked="currentRole.permissions.includes('{{ $perm->name }}')" 
                                    class="mt-0.5 w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                                >
                                <div>
                                    <p class="font-bold text-slate-900">{{ $perm->name }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button 
                        type="button" 
                        @click="editModalOpen = false" 
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-xl text-xs font-bold shadow-sm transition cursor-pointer"
                    >
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
