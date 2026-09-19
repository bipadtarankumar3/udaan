<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Uddan Educational Foundation</title>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            red: '#E51E25',
                            'red-hover': '#CC1219',
                            orange: '#F37021',
                            amber: '#F8971D',
                            dark: '#1E232A',
                            charcoal: '#13171F',
                            50: '#fff1f1',
                            100: '#ffe1e1',
                            200: '#ffc7c8',
                            300: '#ffa0a2',
                            400: '#ff6669',
                            500: '#E51E25',
                            600: '#cc1219',
                            700: '#aa0c12',
                            800: '#8c0d12',
                            900: '#751115',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #F1F5F9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }
        [x-cloak] { display: none !important; }
        .brand-gradient {
            background: linear-gradient(135deg, #E51E25 0%, #F37021 50%, #F8971D 100%);
        }
        .brand-gradient-hover:hover {
            background: linear-gradient(135deg, #CC1219 0%, #DC5F14 50%, #E28414 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-slate-50 font-sans antialiased flex overflow-hidden selection:bg-red-600 selection:text-white" x-data="{ sidebarOpen: false, logoutModalOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        x-cloak
        class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden transition-opacity"
    ></div>

    <!-- Clean White Sidebar -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col transition-transform duration-200 ease-in-out shadow-sm"
    >
        <!-- Logo Branding -->
        <div class="h-20 flex items-center justify-between px-4 border-b border-slate-100 bg-white">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('telecaller.dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.svg') }}" alt="Uddan Educational Foundation" class="h-10 w-auto object-contain">
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Logged-in Staff Card -->
        <div class="px-4 py-3 mx-3 mt-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-red-600 via-orange-500 to-amber-500 text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] font-bold text-orange-600 uppercase tracking-wide">
                        {{ auth()->user()->roles->pluck('name')->first() ?? 'Staff' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scrollbar">
            
            @if(auth()->user()->isAdmin())
                <!-- Admin Section -->
                <div class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    Main Administration
                </div>

                <!-- 1. Dashboard -->
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 text-white shadow-md shadow-red-500/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <i class="fa-solid fa-chart-pie w-4 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Role -->
                <a 
                    href="{{ route('admin.roles.index') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.roles.*') ? 'bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 text-white shadow-md shadow-red-500/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <i class="fa-solid fa-shield-halved w-4 text-center {{ request()->routeIs('admin.roles.*') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Role & Permissions</span>
                </a>

                <!-- 3. Staff -->
                <a 
                    href="{{ route('admin.users.index') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 text-white shadow-md shadow-red-500/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <i class="fa-solid fa-users-gear w-4 text-center {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>Staff Management</span>
                </a>

                <!-- 4. Student -->
                <a 
                    href="{{ route('admin.students.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.students.*') ? 'bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 text-white shadow-md shadow-red-500/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-graduation-cap w-4 text-center {{ request()->routeIs('admin.students.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        <span>Student Leads</span>
                    </div>
                    @php $unassigned = \App\Models\Student::whereNull('assigned_to')->count(); @endphp
                    @if($unassigned > 0)
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ request()->routeIs('admin.students.*') ? 'bg-white/20 text-white' : 'bg-orange-100 text-orange-700' }}">
                            {{ $unassigned }}
                        </span>
                    @endif
                </a>

            @else
                <!-- Telecaller Section -->
                <div class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    Counseling Workspace
                </div>

                <a 
                    href="{{ route('telecaller.dashboard') }}" 
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('telecaller.dashboard') ? 'bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 text-white shadow-md shadow-red-500/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <i class="fa-solid fa-chart-pie w-4 text-center {{ request()->routeIs('telecaller.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>My Dashboard</span>
                </a>

                <a 
                    href="{{ route('telecaller.students.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('telecaller.students.*') ? 'bg-gradient-to-r from-red-600 via-orange-600 to-amber-600 text-white shadow-md shadow-red-500/20' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-phone-volume w-4 text-center {{ request()->routeIs('telecaller.students.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        <span>My Calling List</span>
                    </div>
                    @php $myPending = \App\Models\Student::where('assigned_to', auth()->id())->where('status', 'New')->count(); @endphp
                    @if($myPending > 0)
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ request()->routeIs('telecaller.students.*') ? 'bg-white/20 text-white' : 'bg-orange-100 text-orange-700' }}">
                            {{ $myPending }} new
                        </span>
                    @endif
                </a>
            @endif

        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-slate-100 bg-white">
            <button 
                type="button" 
                @click="logoutModalOpen = true"
                class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 transition duration-150 cursor-pointer"
            >
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Sign Out</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">
        
        <!-- Clean White Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-10 shadow-sm">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h2 class="text-base sm:text-lg font-bold font-heading text-slate-900 truncate">
                        @yield('header', 'Overview')
                    </h2>
                </div>
            </div>

            <!-- Topbar right actions -->
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100 text-xs text-slate-700 font-medium">
                    <i class="fa-regular fa-calendar text-orange-500"></i>
                    <span>{{ now()->format('D, d M Y') }}</span>
                </div>

                <!-- Database status tag -->
                <div class="hidden md:flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>MAMP Active</span>
                </div>

                <!-- Logout Trigger -->
                <button 
                    type="button" 
                    @click="logoutModalOpen = true" 
                    title="Sign Out" 
                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                >
                    <i class="fa-solid fa-power-off text-sm"></i>
                </button>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-7 custom-scrollbar bg-slate-50">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-5 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <div>
                            <p class="font-bold text-emerald-900">Success</p>
                            <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <p class="font-bold text-rose-900">Notice</p>
                            <p class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div x-data="{ show: true }" x-show="show" class="mb-5 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start justify-between shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0 mt-0.5">
                            <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <p class="font-bold text-rose-900">Please review required fields:</p>
                            <ul class="list-disc list-inside text-xs text-rose-700 space-y-1 mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Small Logout Confirmation Modal -->
    <div 
        x-show="logoutModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4"
        aria-labelledby="logout-modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <!-- Dark Backdrop with smooth blur -->
        <div 
            x-show="logoutModalOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="logoutModalOpen = false" 
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
        ></div>

        <!-- Modal Box -->
        <div 
            x-show="logoutModalOpen"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
            @keydown.escape.window="logoutModalOpen = false"
            class="relative bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 z-10 overflow-hidden transform transition-all"
        >
            <!-- Top Gradient Accent -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 via-orange-500 to-amber-500"></div>

            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 mb-4 mt-1">
                <i class="fa-solid fa-right-from-bracket text-xl"></i>
            </div>

            <!-- Modal Text -->
            <h3 class="text-lg font-black font-heading text-slate-900 mb-1" id="logout-modal-title">
                Sign Out Workspace
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-6 px-2">
                Are you sure you want to end your session? Any unsaved lead edits may be lost.
            </p>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <button 
                    type="button" 
                    @click="logoutModalOpen = false" 
                    class="flex-1 py-2.5 px-4 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-50 transition cursor-pointer"
                >
                    Cancel
                </button>
                <form action="{{ route('logout') }}" method="POST" class="flex-1 m-0">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white text-xs font-bold shadow-md shadow-rose-500/20 transition cursor-pointer flex items-center justify-center gap-1.5"
                    >
                        <i class="fa-solid fa-power-off text-[11px]"></i>
                        <span>Yes, Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
