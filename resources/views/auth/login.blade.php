@extends('layouts.auth')

@section('title', 'Staff Portal Sign In')

@section('content')
<div x-data="{ 
    email: '{{ old('email', '') }}', 
    password: '',
    fillCredentials(userEmail, userPass) {
        this.email = userEmail;
        this.password = userPass;
    }
}">
    <!-- Login Card -->
    <div class="bg-white border border-slate-200/90 rounded-3xl p-7 sm:p-8 shadow-xl shadow-slate-200/60 relative overflow-hidden">
        
        <!-- Brand colored gradient top accent -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 via-orange-500 to-amber-500"></div>

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold font-heading text-slate-900">Staff Sign In</h2>
                <p class="text-xs text-slate-500 mt-0.5">Enter your registered email and password</p>
            </div>
            <span class="p-2 rounded-xl bg-orange-50 text-orange-600 border border-orange-200 text-sm">
                <i class="fa-solid fa-lock"></i>
            </span>
        </div>

        @if(session('error'))
            <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation text-base text-rose-500"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Official Email
                </label>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-regular fa-envelope text-sm"></i>
                    </div>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        x-model="email"
                        required 
                        autocomplete="email"
                        placeholder="staff@uddan.com" 
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white focus:border-transparent transition duration-150"
                    >
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Password
                    </label>
                </div>
                <div class="relative rounded-xl shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                    </div>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        x-model="password"
                        required 
                        placeholder="••••••••" 
                        class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white focus:border-transparent transition duration-150"
                    >
                </div>
            </div>

            <div class="flex items-center justify-between py-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 bg-slate-50 text-red-600 focus:ring-red-500">
                    <span class="text-xs text-slate-600 font-medium">Keep me logged in</span>
                </label>
                <span class="text-xs text-orange-600 hover:text-orange-700 hover:underline cursor-pointer font-medium">Helpdesk</span>
            </div>

            <button 
                type="submit" 
                class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 cursor-pointer shadow-red-500/25"
            >
                <span>Access Counseling Workspace</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>

        <!-- Quick 1-Click Demo Accounts Switcher -->
        <div class="mt-7 pt-5 border-t border-slate-200">
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                <i class="fa-solid fa-bolt text-amber-500"></i> Quick Test Sign-in
            </p>
            <div class="grid grid-cols-2 gap-2">
                <button 
                    type="button" 
                    @click="fillCredentials('admin@uddan.com', 'password123')"
                    class="p-2 bg-slate-50 hover:bg-red-50/50 border border-slate-200 hover:border-red-300 rounded-xl text-left transition group"
                >
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-red-600">System Admin</p>
                            <p class="text-[10px] text-slate-500">Full Access</p>
                        </div>
                    </div>
                </button>

                <button 
                    type="button" 
                    @click="fillCredentials('telecaller1@uddan.com', 'password123')"
                    class="p-2 bg-slate-50 hover:bg-orange-50/50 border border-slate-200 hover:border-orange-300 rounded-xl text-left transition group"
                >
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-orange-600">Priya Sharma</p>
                            <p class="text-[10px] text-slate-500">Telecaller 1</p>
                        </div>
                    </div>
                </button>

                <button 
                    type="button" 
                    @click="fillCredentials('telecaller2@uddan.com', 'password123')"
                    class="p-2 bg-slate-50 hover:bg-orange-50/50 border border-slate-200 hover:border-orange-300 rounded-xl text-left transition group"
                >
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-orange-600">Rahul Verma</p>
                            <p class="text-[10px] text-slate-500">Telecaller 2</p>
                        </div>
                    </div>
                </button>

                <button 
                    type="button" 
                    @click="fillCredentials('telecaller3@uddan.com', 'password123')"
                    class="p-2 bg-slate-50 hover:bg-orange-50/50 border border-slate-200 hover:border-orange-300 rounded-xl text-left transition group"
                >
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800 group-hover:text-orange-600">Ananya Roy</p>
                            <p class="text-[10px] text-slate-500">Telecaller 3</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
