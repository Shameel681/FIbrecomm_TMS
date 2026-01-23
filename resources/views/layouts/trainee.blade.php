<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trainee Portal - Fibrecomm Network</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/index.css', 'resources/js/app.js'])

    <style>
        /* Shared Aesthetic with Admin/HR Console */
        .sidebar-link {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(239, 64, 35, 0.1); /* Subtle Brand Red */
            transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        .sidebar-link:hover::before { left: 0; }

        .sidebar-link.active-link {
            background: rgba(239, 64, 35, 0.15);
            color: #EF4023 !important; /* Brand Red */
        }

        .sidebar-link .indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 70%;
            background-color: #EF4023; /* Brand Red */
            transition: transform 0.3s ease;
            border-radius: 0 4px 4px 0;
        }

        .sidebar-link:hover .indicator,
        .sidebar-link.active-link .indicator {
            transform: translateY(-50%) scaleY(1);
        }

        .logo-container img {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform;
        }
        .logo-container:hover img { transform: scale(1.1); }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #001f3f; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #EF4023; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-brand-navy text-white flex flex-col fixed h-full z-50 shadow-2xl">
            <div class="p-8 border-b border-white/5 text-center">
                <a href="{{ route('trainee.dashboard') }}" class="logo-container inline-block mb-4">
                    {{-- FIXED: Removed brightness-200 to restore original colors --}}
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-12 w-auto mx-auto">
                </a>
                <div class="flex flex-col">
                    <span class="text-brand-red font-black text-xl tracking-tighter uppercase">Trainee Hub</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Learning & Growth</span>
                </div>
            </div>

            <nav class="flex-grow p-4 space-y-2 mt-4">
                {{-- Home --}}
                <a href="{{ route('trainee.dashboard') }}" 
                   class="sidebar-link {{ Request::is('trainee/dashboard') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                    <span class="relative z-10">Overview</span>
                </a>

                {{-- Attendance --}}
                <a href="{{ route('trainee.attendance.index') }}" 
                   class="sidebar-link {{ Request::is('trainee/attendance*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                    <span class="relative z-10">My Attendance</span>
                </a>

                {{-- Profile --}}
                <a href="{{ route('trainee.profile') }}" 
                   class="sidebar-link {{ Request::is('trainee/profile*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                    <span class="relative z-10">My Profile</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/5">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="group relative w-full bg-brand-red text-white py-4 rounded-sm font-black text-[10px] uppercase tracking-[0.2em] overflow-hidden shadow-lg">
                        <span class="relative z-10 transition-colors duration-300 group-hover:text-brand-navy">Log Out</span>
                        <div class="absolute inset-0 bg-white translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-grow ml-64 flex flex-col">
            
            <header class="flex items-center justify-between px-10 py-6 bg-white border-b border-gray-100 sticky top-0 z-40">
                <div>
                    <h1 class="text-xl font-black text-brand-navy tracking-tighter uppercase">
                        Trainee <span class="text-brand-red">Portal</span>
                    </h1>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em]">Fibrecomm Network (M) Sdn Bhd</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-[10px] font-black text-brand-red uppercase tracking-widest">Active Intern</p>
                        {{-- FIXED: Using standard Auth::user() --}}
                        <p class="text-sm font-bold text-brand-navy">{{ Auth::user()->name ?? 'Trainee' }}</p>
                    </div>
                    <div class="h-10 w-10 bg-brand-navy rounded-sm flex items-center justify-center text-white font-black text-lg shadow-lg border-b-2 border-brand-red">
                        {{ substr(Auth::user()->name ?? 'T', 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="p-10 flex-grow">
                @yield('content')
            </main>

            <footer class="bg-white border-t py-8 px-10 text-center">
                <p class="text-[10px] text-gray-400 uppercase tracking-[0.4em] font-black">
                    &copy; {{ date('Y') }} Fibrecomm Network (M) Sdn Bhd | Trainee System
                </p>
            </footer>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, easing: 'ease-out-back' });
    </script>
</body>
</html>