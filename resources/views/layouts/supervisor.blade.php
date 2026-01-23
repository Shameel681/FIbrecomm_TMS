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
        /* Supervisor Theme: Indigo/Blue Accents instead of Red */
        :root {
            --sv-primary: #3b82f6; /* Modern Blue */
            --sv-navy: #001f3f;
        }

        .nav-link .underline-bar {
            transform: scaleX(0);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }
        .nav-link.active .underline-bar,
        .nav-link:hover .underline-bar {
            transform: scaleX(1);
        }
        
        .logo-container img {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .logo-container:hover img {
            transform: scale(1.1);
        }

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
            background: rgba(59, 130, 246, 0.1); /* Subtle Blue */
            transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        .sidebar-link:hover::before { left: 0; }

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

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--sv-navy); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--sv-primary); }
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
                {{-- Dashboard --}}
                <a href="{{ route('supervisor.dashboard') }}" 
                   class="sidebar-link {{ Request::is('supervisor/dashboard') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                    <span class="relative z-10">Operations Center</span>
                </a>

                {{-- My Trainees --}}
                <a href="{{ route('supervisor.trainees') }}" 
                   class="sidebar-link {{ Request::is('supervisor/trainees*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                    <span class="relative z-10">Manage Trainees</span>
                </a>

                {{-- Task Assignments --}}
                <a href="{{ route('supervisor.tasks') }}" 
                   class="sidebar-link {{ Request::is('supervisor/tasks*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                    <span class="relative z-10">Task Tracking</span>
                </a>

                {{-- Logbook Reviews --}}
                <a href="{{ route('supervisor.logbooks') }}" 
                   class="sidebar-link {{ Request::is('supervisor/logbooks*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                    <span class="relative z-10">Logbook Reviews</span>
                </a>

                {{-- Profile --}}
                <a href="{{ route('supervisor.profile.edit') }}" 
                   class="sidebar-link {{ Request::is('supervisor/profile*') ? 'active-link' : '' }} group flex items-center px-4 py-3.5 rounded transition-all text-[11px] font-black uppercase tracking-widest relative">
                    <div class="indicator"></div>
                     <span class="relative z-10">Account Settings</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/5">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="group relative w-full bg-blue-600 text-white py-4 rounded-sm font-black text-[10px] uppercase tracking-[0.2em] overflow-hidden shadow-lg">
                        <span class="relative z-10 transition-colors duration-300 group-hover:text-brand-navy">End Session</span>
                        <div class="absolute inset-0 bg-white translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-grow ml-64 flex flex-col">
            
            {{-- Header --}}
            <header class="flex items-center justify-between px-10 py-6 bg-white border-b border-gray-100">
                <div class="flex items-center gap-6">
                    <a href="#" class="logo-container h-12 w-auto shrink-0 flex items-center justify-center">
                        <img src="{{ asset('images/logo1.png') }}" alt="Fibrecomm Logo" class="h-full w-auto object-contain">
                    </a>
                    <div class="h-8 w-[1px] bg-gray-200"></div>
                    <div>
                        <h1 class="text-xl font-black text-brand-navy tracking-tighter uppercase">
                            Supervisor <span class="text-blue-500">Portal</span>
                        </h1>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em]">Fibrecomm Network (M) Sdn Bhd</p>
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

            {{-- Sub-Header / Breadcrumb Area --}}
            <nav class="bg-brand-navy text-white sticky top-0 z-40 shadow-xl">
                <div class="flex items-center px-10">
                    <div class="flex items-center uppercase text-[11px] tracking-[0.2em] font-black">
                        <div class="nav-link relative py-5 px-6 bg-white/5 border-r border-white/5">
                            <span class="text-blue-400">Section:</span> @yield('header_title', 'Performance Overview')
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Content Area --}}
            <main class="p-10 flex-grow">
                @yield('supervisor_content')
            </main>

            {{-- Footer --}}
            <footer class="bg-white border-t py-8 px-10 text-center">
                <p class="text-[10px] text-gray-400 uppercase tracking-[0.4em] font-black">
                    &copy; {{ date('Y') }} Fibrecomm Network (M) Sdn Bhd | Supervisor Management Unit
                </p>
            </footer>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, easing: 'ease-out-back' });

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-brand-navy' : 'bg-red-600';
            const icon = type === 'success' 
                ? '<svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>'
                : '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>';

            toast.className = `${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 transform transition-all duration-500 translate-x-full opacity-0 border border-white/10`;
            toast.innerHTML = `
                <div class="bg-white/10 p-2 rounded-lg">${icon}</div>
                <div class="flex flex-col">
                    <p class="text-[10px] font-black uppercase tracking-widest">${type === 'success' ? 'Update Success' : 'Attention Required'}</p>
                    <p class="text-xs font-bold opacity-90">${message}</p>
                </div>
            `;

            container.appendChild(toast);
            setTimeout(() => { toast.classList.remove('translate-x-full', 'opacity-0'); }, 100);
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
        @if(session('error')) showToast("{{ session('error') }}", 'error'); @endif
    </script>
    @stack('scripts')
</body>
</html>