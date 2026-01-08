<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trainee Portal - Fibrecomm Network</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    {{-- AOS CSS for Entrance Animations --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/index.css', 'resources/js/app.js'])

    <style>
        .nav-link-anim { position: relative; }
        .nav-link-anim::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 0;
            left: 50%;
            background-color: #EF4023;
            transition: all 0.3s ease-in-out;
            transform: translateX(-50%);
        }
        /* Keep underline visible if link is hovered OR if it's the active page */
        .nav-link-anim:hover::after, 
        .nav-link-active::after { 
            width: 100%; 
        }

        /* --- LOGO HOVER ANIMATION --- */
        .logo-anim img {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform;
        }

        .logo-anim:hover img {
            transform: scale(1.1);
        }

        .logo-anim:active img {
            transform: scale(0.95);
        }
        /* ---------------------------- */

        /* Smooth entrance for the main container */
        [data-aos] { pointer-events: none; }
        .aos-animate { pointer-events: auto; }
    </style>
</head>
<body class="bg-gray-200 py-10 font-sans antialiased">

    <div class="mx-auto max-w-[1100px] bg-white shadow-2xl rounded-sm min-h-[90vh] flex flex-col" data-aos="fade-in" data-aos-duration="800">
        
        <header class="flex items-center gap-5 px-10 py-7 bg-white">
            <a href="{{ route('trainee.dashboard') }}" class="logo-anim h-16 w-auto shrink-0 flex items-center justify-center">
                <img src="{{ asset('images/logo1.png') }}" alt="Fibrecomm Logo" class="h-full w-auto object-contain">
            </a>
            <h1 class="text-[28px] font-bold text-brand-navy tracking-tight">Trainee Management Portal</h1>
        </header>

        <nav class="bg-brand-navy text-white sticky top-0 z-50 shadow-md">
            <div class="flex items-center justify-between px-10">
                <div class="flex items-center uppercase text-[13px] tracking-widest font-bold h-full">
                    {{-- Home Link --}}
                    <a href="{{ route('trainee.dashboard') }}" 
                       class="nav-link-anim {{ Request::is('trainee/dashboard') ? 'nav-link-active' : '' }} py-6 px-8 hover:bg-white/5 transition-colors">
                        Home
                    </a>

                    {{-- Attendance Link --}}
                    <a href="#" 
                       class="nav-link-anim {{ Request::is('trainee/attendance*') ? 'nav-link-active' : '' }} py-6 px-8 hover:bg-white/5 transition-colors">
                        Attendance
                    </a>

                    {{-- Profile Link --}}
                    <a href="{{ route('trainee.profile') }}" 
                       class="nav-link-anim {{ Request::is('trainee/profile') ? 'nav-link-active' : '' }} py-6 px-8 hover:bg-white/5 transition-colors">
                        Profile
                    </a>
                </div>

                <div class="flex items-center gap-6">
                    <span class="text-[11px] uppercase tracking-widest text-gray-300 hidden md:block">
                        Welcome, {{ Auth::guard('trainee')->user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-brand-red text-white px-6 py-2 rounded font-bold text-[12px] uppercase tracking-widest hover:bg-white hover:text-brand-navy transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="flex-grow p-10 bg-gray-50">
            @yield('content')
        </main>

        <footer class="bg-brand-navy text-white py-8 text-center text-xs uppercase tracking-widest font-bold border-t border-white/10">
            <p>&copy; {{ date('Y') }} Fibrecomm Network (M) Sdn Bhd.</p>
        </footer>
    </div>

    {{-- AOS JS Initialization --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-out-back',
            once: true 
        });
    </script>
</body>
</html>