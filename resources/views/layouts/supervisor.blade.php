<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Portal - Fibrecomm Network</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/index.css', 'resources/js/app.js'])

    <style>
        :root {
            --sv-primary: #3b82f6; 
            --sv-navy: #001f3f;
        }

        .sidebar-link {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-link.active-link {
            background: rgba(59, 130, 246, 0.15);
            color: var(--sv-primary) !important;
        }

        .sidebar-link .indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 70%;
            background-color: var(--sv-primary);
            transition: transform 0.3s ease;
            border-radius: 0 4px 4px 0;
        }

        .sidebar-link:hover .indicator,
        .sidebar-link.active-link .indicator {
            transform: translateY(-50%) scaleY(1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <div id="toast-container" class="fixed top-5 right-5 z-[200] flex flex-col gap-3"></div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-brand-navy text-white flex flex-col fixed h-full z-50 shadow-2xl">
            <div class="p-8 border-b border-white/5">
                <div class="flex flex-col">
                    <span class="text-blue-400 font-black text-xl tracking-tighter uppercase">Supervisor HQ</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Operations Lead</span>
                </div>
            </div>

            <nav class="flex-grow p-4 space-y-2 mt-4">
    {{-- Operations Center --}}
    <a href="{{ route('supervisor.dashboard') }}" 
       class="sidebar-link {{ Request::is('supervisor/dashboard') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
        <div class="indicator"></div>
        <span class="relative z-10">Operations Center</span>
    </a>

    {{-- Attendance Approvals (Pathing Fix) --}}
    <a href="{{ route('supervisor.attendance.approvals') }}" 
       class="sidebar-link {{ Request::is('supervisor/attendance*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
        <div class="indicator"></div>
        <span class="relative z-10">Attendance Approvals</span>
    </a>

    {{-- Manage Trainees --}}
    <a href="{{ route('supervisor.trainees') }}" 
       class="sidebar-link {{ Request::is('supervisor/trainees*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
        <div class="indicator"></div>
        <span class="relative z-10">Manage Trainees</span>
    </a>
</nav>

            <div class="p-6 border-t border-white/5">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-sm font-black text-[10px] uppercase tracking-widest overflow-hidden shadow-lg hover:bg-white hover:text-brand-navy transition-all duration-300">
                        End Session
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-grow ml-64 flex flex-col">
            <header class="flex items-center justify-between px-10 py-6 bg-white border-b border-gray-100">
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-black text-brand-navy tracking-tighter uppercase">
                            Supervisor <span class="text-blue-500">Portal</span>
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest">Operational Lead</p>
                        <p class="text-sm font-bold text-brand-navy">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="h-10 w-10 bg-brand-navy rounded-sm flex items-center justify-center text-white font-black text-lg shadow-lg border-b-2 border-blue-500">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <nav class="bg-brand-navy text-white sticky top-0 z-40 shadow-xl">
                <div class="flex items-center px-10">
                    <div class="nav-link relative py-5 px-6 bg-white/5 border-r border-white/5 uppercase text-[11px] tracking-[0.2em] font-black">
                        <span class="text-blue-400">Section:</span> @yield('header_title', 'Performance Overview')
                    </div>
                </div>
            </nav>

            <main class="p-10 flex-grow">
                @yield('supervisor_content')
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>