<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlobalTech Solutions - Trainee Management Portal</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    {{-- This is the only place you need to link your CSS now --}}
    @vite(['resources/css/index.css', 'resources/js/app.js'])
</head>
<body class="py-10 bg-gray-200">

    <div class="mx-auto max-w-[1100px] bg-white shadow-2xl overflow-hidden rounded-sm">
        
        {{-- Header Section --}}
        <header class="flex items-center gap-5 px-10 py-7">
            <div class="relative flex h-16 w-16 shrink-0 items-center justify-center bg-brand-navy text-white text-4xl font-bold rounded-sm">
                <span class="relative z-10">G</span>
                <div class="absolute bottom-0 right-0 h-[45%] w-[45%] bg-brand-red"></div>
            </div>
            <h1 class="text-[28px] font-bold text-brand-navy tracking-tight">
                Fibrecomm Network - Trainee Management Portal
            </h1>
        </header>

        {{-- Navigation Bar --}}
        <nav class="bg-brand-navy text-white">
            <div class="flex items-center px-10 uppercase text-[13px] tracking-widest font-bold">
                <a href="/" class="relative py-5 px-8 bg-brand-navy hover:text-gray-300">
                    Home
                    <div class="absolute bottom-0 left-0 h-1.5 w-full bg-brand-red"></div>
                </a>
                <a href="#" class="py-5 px-8 hover:bg-white/5 transition-colors">Interns</a>
                <a href="#" class="py-5 px-8 hover:bg-white/5 transition-colors">Supervisors</a>
                <a href="#" class="py-5 px-8 hover:bg-white/5 transition-colors">Management</a>
                <a href="#" class="py-5 px-8 hover:bg-white/5 transition-colors">Contact</a>
            </div>
        </nav>

        {{-- This is the "hole" where your index.blade.php content will appear --}}
        @yield('main_content')

        {{-- Footer --}}
        <footer class="bg-brand-navy text-white py-10 border-t border-white/10">
            <div class="flex justify-center gap-12 text-[13px] font-bold uppercase tracking-widest">
                <a href="#" class="hover:text-brand-red transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-brand-red transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-brand-red transition-colors">Contact HR</a>
            </div>
        </footer>
    </div>

</body>
</html>