<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fibrecomm Network - Trainee Management Portal</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/index.css', 'resources/js/app.js'])

    @stack('styles')
    
    <style>
        /* 1. Nav Underline Animation */
        .nav-link .underline-bar {
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: center;
        }

        .nav-link.active .underline-bar,
        .nav-link:hover .underline-bar {
            transform: scaleX(1);
        }
        
        /* 2. Logo Hover Animation */
        .logo-container img {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform;
        }

        .logo-container:hover img {
            transform: scale(1.1);
        }

        /* 3. Smooth scroll padding */
        html { scroll-padding-top: 80px; }

        /* 4. Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #001f3f; border-radius: 10px; }
    </style>
</head>
<body class="py-10 bg-gray-200 font-sans antialiased">

    <div class="mx-auto max-w-[1100px] bg-white shadow-2xl rounded-sm">
        
        <header class="flex items-center gap-5 px-10 py-7 bg-white">
            <a href="{{ url('/') }}" class="logo-container h-16 w-auto shrink-0 flex items-center justify-center">
                <img src="{{ asset('images/logo1.png') }}" 
                     alt="Fibrecomm Logo" 
                     class="h-full w-auto object-contain">
            </a>
            <h1 class="text-[28px] font-bold text-brand-navy tracking-tight">
                Fibrecomm Network - Trainee Management Portal
            </h1>
        </header>

        <nav id="main-nav" class="bg-brand-navy text-white sticky top-0 z-50 shadow-md">
            <div class="flex items-center justify-between px-10">
                <div id="nav-links" class="flex items-center uppercase text-[13px] tracking-widest font-bold">
                    <a href="#home" class="nav-link relative py-5 px-8 hover:bg-white/5 transition-colors active">
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

                <div class="flex items-center">
                    <button onclick="toggleLoginModal()" class="bg-brand-red text-white px-6 py-2 rounded font-bold text-[12px] uppercase tracking-widest hover:bg-white hover:text-brand-navy transition-all duration-300 transform hover:scale-105 active:scale-95">
                        Login
                    </button>
                </div>
            </div>
        </nav>

        <main>
            @yield('main_content')
        </main>

        <footer class="bg-brand-navy text-white py-10 border-t border-white/10 text-center text-xs uppercase tracking-widest font-bold">
            <div class="flex justify-center gap-12 mb-4">
                <a href="#" class="hover:text-brand-red transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-brand-red transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-brand-red transition-colors">Contact HR</a>
            </div>
            <p class="opacity-50">&copy; {{ date('Y') }} Fibrecomm Network (M) Sdn Bhd.</p>
        </footer>
    </div>

    {{-- Login Modal logic remains the same --}}
    <div id="loginModal" class="fixed inset-0 z-[100] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div id="modalContent" class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all" onclick="event.stopPropagation()">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-brand-navy uppercase tracking-tight">TMS Portal Login</h2>
                    <button onclick="toggleLoginModal()" class="text-gray-400 hover:text-brand-red transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </button>
                </div>
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-brand-navy uppercase mb-2">Email Address</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-brand-navy uppercase mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all">
                    </div>
                    <button type="submit" class="w-full bg-brand-navy hover:bg-brand-red text-white font-bold py-4 rounded-xl transition-all uppercase tracking-widest text-sm shadow-md active:scale-95">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal Logic
        const loginModal = document.getElementById('loginModal');
        function toggleLoginModal() {
            loginModal.classList.toggle('hidden');
            document.body.style.overflow = loginModal.classList.contains('hidden') ? 'auto' : 'hidden';
        }

        // Active Nav Scroll logic
        const sections = document.querySelectorAll("section[id]");
        const navLinks = document.querySelectorAll(".nav-link");

        window.addEventListener("scroll", () => {
            let current = "";
            const scrollPos = window.scrollY;

            if (scrollPos < 100) {
                current = "home";
            } else {
                sections.forEach((section) => {
                    const sectionTop = section.offsetTop;
                    if (scrollPos >= sectionTop - 150) {
                        current = section.getAttribute("id");
                    }
                });
            }

            navLinks.forEach((link) => {
                link.classList.remove("active");
                if (link.getAttribute("href") === `#${current}`) {
                    link.classList.add("active");
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>