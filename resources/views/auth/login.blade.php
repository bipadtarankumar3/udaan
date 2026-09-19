@extends('layouts.auth')

@section('title', 'Staff Portal Sign In')

@section('content')
<div class="min-h-screen flex flex-col lg:flex-row bg-slate-100" x-data="{ 
    email: '{{ old('email', '') }}', 
    password: '',
    showPass: false,
    selectedAccount: '',
    fillCredentials(userEmail, userPass, accountName) {
        this.email = userEmail;
        this.password = userPass;
        this.selectedAccount = accountName;
    }
}">

    <!-- Left Side: Student Admission Campus Hero Visual -->
    <div class="hidden lg:flex lg:w-7/12 relative overflow-hidden bg-slate-950 text-white flex-col justify-between p-10 xl:p-14 selection:bg-red-500 selection:text-white">
        <!-- Background Image with Overlay -->
        <img 
            src="{{ asset('images/admission-bg.jpg') }}" 
            alt="Students Admission Counseling" 
            class="absolute inset-0 w-full h-full object-cover object-center scale-105 transform hover:scale-100 transition-transform duration-1000 ease-out"
        >
        <!-- Sophisticated Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/50 to-slate-900/30 backdrop-blur-[0.5px]"></div>

        <!-- Top Branding Header -->
        <div class="relative z-10 flex items-center justify-between">
            <div class="inline-flex items-center gap-3 p-3 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/30">
                <img src="{{ asset('logo.png') }}" alt="Uddan Educational Foundation" class="h-10 w-auto object-contain">
            </div>
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900/70 backdrop-blur-md border border-white/20 text-white text-xs font-semibold shadow-lg">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                <span>Bihar Students Counselling Center • 2025</span>
            </div>
        </div>

        <!-- Center / Bottom Hero Message -->
        <div class="relative z-10 max-w-2xl space-y-5 my-auto pt-16">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 text-white text-xs font-black uppercase tracking-wider shadow-lg">
                <i class="fa-solid fa-graduation-cap text-amber-200"></i>
                <span>Higher Education Admissions & Counseling</span>
            </div>

            <h1 class="text-3xl xl:text-4xl 2xl:text-5xl font-black font-heading leading-tight text-white drop-shadow-lg">
                Empowering Students to Achieve Their Academic Dreams.
            </h1>

            <p class="text-sm xl:text-base text-slate-200 leading-relaxed max-w-xl font-normal drop-shadow">
                Connecting aspiring students across Bihar with accredited colleges, DRCC Student Credit Card guidance, and personalized counselor outreach.
            </p>

            <!-- 3 Highlights Cards -->
            <div class="grid grid-cols-3 gap-3.5 pt-3">
                <div class="p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 text-left shadow-lg">
                    <p class="text-2xl font-black text-amber-300 font-heading">15,000+</p>
                    <p class="text-xs text-slate-200 mt-0.5 font-medium">Students Guided</p>
                </div>
                <div class="p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 text-left shadow-lg">
                    <p class="text-2xl font-black text-orange-300 font-heading">100%</p>
                    <p class="text-xs text-slate-200 mt-0.5 font-medium">Free Counseling</p>
                </div>
                <div class="p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 text-left shadow-lg">
                    <p class="text-2xl font-black text-emerald-300 font-heading">DRCC</p>
                    <p class="text-xs text-slate-200 mt-0.5 font-medium">Loan Assistance</p>
                </div>
            </div>
        </div>

        <!-- Bottom Quote / Verification -->
        <div class="relative z-10 pt-6 border-t border-white/15 flex items-center justify-between text-xs text-slate-300">
            <div class="flex items-center gap-2 font-medium">
                <i class="fa-solid fa-shield-halved text-amber-400"></i>
                <span>Official Staff & Telecaller Lead Management CRM</span>
            </div>
            <span>&copy; {{ date('Y') }} Uddan Educational Foundation</span>
        </div>
    </div>

    <!-- Right Side: Ultra-Attractive White Card Login Panel -->
    <div class="w-full lg:w-5/12 bg-gradient-to-b from-slate-50 via-white to-orange-50/30 flex flex-col justify-between p-6 sm:p-10 lg:p-8 xl:p-12 shadow-2xl relative z-10 overflow-y-auto">
        
        <!-- Top Nav (Back to website) -->
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('frontend.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-900 transition">
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
                <span>Back to Website</span>
            </a>
            <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">
                Staff Only
            </span>
        </div>

        <!-- Mobile Header (Visible only on small devices) -->
        <div class="lg:hidden text-center mb-6 pt-2">
            <div class="inline-flex items-center justify-center p-3 bg-white rounded-2xl shadow-sm border border-slate-200 mb-2">
                <img src="{{ asset('logo.png') }}" alt="Uddan" class="h-10 w-auto">
            </div>
            <p class="text-xs font-bold text-slate-700">Bihar Students Counselling Center Awareness Program</p>
        </div>

        <!-- Main Form Container -->
        <div class="max-w-md w-full mx-auto my-auto">
            
            <!-- Elevated Card Wrapper -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-7 sm:p-9 shadow-2xl shadow-slate-200/80 relative overflow-hidden">
                
                <!-- Warm Gradient Top Border Accent -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 via-orange-500 to-amber-500"></div>

                <!-- Card Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                Staff Portal
                            </span>
                        </div>
                        <span class="p-2 rounded-xl bg-orange-50 text-orange-600 border border-orange-200 text-xs">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black font-heading text-slate-900 mt-2">
                        Welcome Back
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Sign in to access student counseling leads & caller workspace
                    </p>
                </div>

                <!-- Flash Alerts -->
                @if(session('error'))
                    <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl flex items-center gap-2.5 animate-shake">
                        <i class="fa-solid fa-circle-exclamation text-base text-rose-500 shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-2xl flex items-center gap-2.5">
                        <i class="fa-solid fa-circle-check text-base text-emerald-500 shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Sign In Form -->
                <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Official Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-2xl shadow-sm group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </div>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                x-model="email"
                                required 
                                autocomplete="email"
                                placeholder="name@uddan.com" 
                                class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white focus:border-transparent transition duration-150"
                            >
                        </div>
                    </div>

                    <!-- Password Field with Show/Hide Toggle -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Password <span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="relative rounded-2xl shadow-sm group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition">
                                <i class="fa-solid fa-shield-halved text-sm"></i>
                            </div>
                            <input 
                                :type="showPass ? 'text' : 'password'" 
                                name="password" 
                                id="password" 
                                x-model="password"
                                required 
                                placeholder="••••••••" 
                                class="block w-full pl-10 pr-11 py-3 bg-slate-50 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 text-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white focus:border-transparent transition duration-150"
                            >
                            <button 
                                type="button" 
                                @click="showPass = !showPass" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer transition"
                                title="Toggle password visibility"
                            >
                                <i class="fa-regular" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Security -->
                    <div class="flex items-center justify-between pt-1 pb-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-red-600 focus:ring-red-500 border-slate-300 bg-slate-50 cursor-pointer">
                            <span class="text-xs text-slate-600 font-medium">Keep me signed in</span>
                        </label>
                        <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-lock text-[10px] text-emerald-500"></i>
                            256-bit Encrypted
                        </span>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full py-3.5 px-4 bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 hover:from-red-700 hover:via-orange-700 hover:to-amber-700 text-white rounded-2xl text-xs font-bold uppercase tracking-wider shadow-lg shadow-red-600/30 hover:shadow-xl hover:shadow-red-600/40 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-150 cursor-pointer flex items-center justify-center gap-2 group"
                    >
                        <span>Access Counseling Workspace</span>
                        <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition"></i>
                    </button>
                </form>

                {{-- Quick Demo Accounts Section (Temporarily hidden) --}}
                {{--
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-bolt text-amber-500"></i>
                            <span>Quick Demo Accounts</span>
                        </p>
                        <span class="text-[10px] text-orange-600 font-bold">1-Click Fill</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5">
                        <!-- Super Admin -->
                        <button 
                            type="button" 
                            @click="fillCredentials('admin@uddan.com', 'password123', 'admin')"
                            :class="selectedAccount === 'admin' ? 'border-red-500 bg-red-50/80 ring-2 ring-red-500/20' : 'border-slate-200 bg-slate-50/80 hover:bg-red-50/50 hover:border-red-300'"
                            class="p-2.5 rounded-2xl border text-left transition duration-150 group cursor-pointer relative"
                        >
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fa-solid fa-user-shield text-xs"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="font-bold text-slate-900 group-hover:text-red-700 text-xs truncate">System Admin</p>
                                    <p class="text-[10px] text-slate-400 truncate">Super Admin</p>
                                </div>
                            </div>
                        </button>

                        <!-- Telecaller 1: Priya -->
                        <button 
                            type="button" 
                            @click="fillCredentials('telecaller1@uddan.com', 'password123', 'priya')"
                            :class="selectedAccount === 'priya' ? 'border-orange-500 bg-orange-50/80 ring-2 ring-orange-500/20' : 'border-slate-200 bg-slate-50/80 hover:bg-orange-50/50 hover:border-orange-300'"
                            class="p-2.5 rounded-2xl border text-left transition duration-150 group cursor-pointer relative"
                        >
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fa-solid fa-headset text-xs"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="font-bold text-slate-900 group-hover:text-orange-700 text-xs truncate">Priya Sharma</p>
                                    <p class="text-[10px] text-slate-400 truncate">Lead Counselor</p>
                                </div>
                            </div>
                        </button>

                        <!-- Telecaller 2: Rahul -->
                        <button 
                            type="button" 
                            @click="fillCredentials('telecaller2@uddan.com', 'password123', 'rahul')"
                            :class="selectedAccount === 'rahul' ? 'border-amber-500 bg-amber-50/80 ring-2 ring-amber-500/20' : 'border-slate-200 bg-slate-50/80 hover:bg-amber-50/50 hover:border-amber-300'"
                            class="p-2.5 rounded-2xl border text-left transition duration-150 group cursor-pointer relative"
                        >
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="font-bold text-slate-900 group-hover:text-amber-700 text-xs truncate">Rahul Verma</p>
                                    <p class="text-[10px] text-slate-400 truncate">Telecaller 2</p>
                                </div>
                            </div>
                        </button>

                        <!-- Telecaller 3: Ananya -->
                        <button 
                            type="button" 
                            @click="fillCredentials('telecaller3@uddan.com', 'password123', 'ananya')"
                            :class="selectedAccount === 'ananya' ? 'border-orange-500 bg-orange-50/80 ring-2 ring-orange-500/20' : 'border-slate-200 bg-slate-50/80 hover:bg-orange-50/50 hover:border-orange-300'"
                            class="p-2.5 rounded-2xl border text-left transition duration-150 group cursor-pointer relative"
                        >
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    <i class="fa-solid fa-comments text-xs"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="font-bold text-slate-900 group-hover:text-orange-700 text-xs truncate">Ananya Roy</p>
                                    <p class="text-[10px] text-slate-400 truncate">Telecaller 3</p>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
                --}}

            </div>

            <!-- Trust Footer Inside Container -->
            <div class="mt-6 text-center space-y-2">
                <div class="flex items-center justify-center gap-4 text-[11px] text-slate-400">
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-award text-amber-500"></i>
                        ISO Certified
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-building-columns text-orange-500"></i>
                        DRCC Approved
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1">
                        <i class="fa-solid fa-shield text-emerald-500"></i>
                        Encrypted
                    </span>
                </div>
                <p class="text-[11px] text-slate-400">
                    &copy; {{ date('Y') }} Uddan Educational Foundation. All rights reserved.
                </p>
            </div>

        </div>

    </div>

</div>
@endsection
