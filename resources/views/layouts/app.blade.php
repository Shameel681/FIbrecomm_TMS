<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fibrecomm Network - Trainee Management Portal</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/index.css', 'resources/js/app.js'])
</head>
<body class="py-10 bg-gray-200">

    <div class="mx-auto max-w-[1100px] bg-white shadow-2xl rounded-sm">
        
        <header class="flex items-center gap-5 px-10 py-7 bg-white">
            <a href="{{ url('/') }}" class="h-16 w-auto shrink-0 flex items-center justify-center hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/logo1.png') }}" alt="Fibrecomm Logo" class="h-full w-auto object-contain">
            </a>
            <h1 class="text-[28px] font-bold text-brand-navy tracking-tight">
                Fibrecomm Network - Trainee Management Portal
            </h1>
        </header>

        <nav id="main-nav" class="bg-brand-navy text-white sticky top-0 z-50 shadow-md">
            <div class="flex items-center px-10 uppercase text-[13px] tracking-widest font-bold">
                <a href="#home" class="nav-link relative py-5 px-8 hover:bg-white/5 transition-colors">
                    Home
                    <div class="underline-bar absolute bottom-0 left-0 h-1 w-full bg-brand-red"></div>
                </a>
                <a href="#about" class="nav-link relative py-5 px-8 hover:bg-white/5 transition-colors">
                    About Us
                    <div class="underline-bar absolute bottom-0 left-0 h-1 w-full bg-brand-red"></div>
                </a>
                <a href="#internship" class="nav-link relative py-5 px-8 hover:bg-white/5 transition-colors">
                    Internship Form
                    <div class="underline-bar absolute bottom-0 left-0 h-1 w-full bg-brand-red"></div>
                </a>
                <a href="#location" class="nav-link relative py-5 px-8 hover:bg-white/5 transition-colors">
                    Our Location
                    <div class="underline-bar absolute bottom-0 left-0 h-1 w-full bg-brand-red"></div>
                </a>
                <a href="#contact" class="nav-link relative py-5 px-8 hover:bg-white/5 transition-colors">
                    Contact Us
                    <div class="underline-bar absolute bottom-0 left-0 h-1 w-full bg-brand-red"></div>
                </a>
            </div>
        </nav>

        <main>
            @yield('main_content')
        </main>

        <footer class="bg-brand-navy text-white py-10 border-t border-white/10 text-center text-xs uppercase tracking-widest font-bold">
            <div class="flex justify-center gap-12">
                <a href="#" class="hover:text-brand-red transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-brand-red transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-brand-red transition-colors">Contact HR</a>
            </div>
        </footer>
    </div>

</body>
</html>