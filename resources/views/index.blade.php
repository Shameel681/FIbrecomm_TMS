<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Fibrecomm TMS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        {{-- Styles / Scripts --}}
        @vite(['resources/css/index.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100">
        <div class="relative flex min-h-screen flex-col">
            {{-- Top navigation --}}
            <header class="border-b border-slate-800 bg-slate-950/80 backdrop-blur">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 lg:px-8">
                    <div class="flex items-center gap-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-400 text-slate-950 font-semibold shadow-sm">
                            FT
                        </span>
                        <div class="flex flex-col leading-tight">
                            <span class="text-sm font-semibold tracking-wide uppercase text-amber-300">
                                Fibrecomm
                            </span>
                            <span class="text-sm text-slate-300">
                                Trainee Management System
                            </span>
                        </div>
                    </div>

                    <nav class="hidden items-center gap-6 text-sm text-slate-300 lg:flex">
                        <a href="#features" class="hover:text-amber-300 transition-colors">Features</a>
                        <a href="#workflow" class="hover:text-amber-300 transition-colors">Workflow</a>
                        <a href="#contact" class="hover:text-amber-300 transition-colors">Contact</a>
                    </nav>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="hidden rounded-full border border-slate-700 px-4 py-1.5 text-sm font-medium text-slate-200 hover:border-amber-400 hover:text-amber-200 lg:inline-flex transition-colors"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="hidden rounded-full border border-slate-700 px-4 py-1.5 text-sm font-medium text-slate-200 hover:border-amber-400 hover:text-amber-200 lg:inline-flex transition-colors"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="hidden rounded-full bg-amber-400 px-4 py-1.5 text-sm font-semibold text-slate-950 shadow-sm hover:bg-amber-300 lg:inline-flex transition-colors"
                                    >
                                        Get started
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </header>

            {{-- Main --}}
            <main class="flex flex-1 items-center">
                <div class="mx-auto flex w-full max-w-6xl flex-col gap-12 px-4 py-10 lg:flex-row lg:items-center lg:py-16 lg:px-8">
                    {{-- Left column --}}
                    <section class="flex-1 space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-slate-900/60 px-3 py-1 text-xs font-medium text-slate-300 shadow-sm">
                            <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            Live operations overview
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-3xl font-semibold tracking-tight text-slate-50 sm:text-4xl lg:text-5xl">
                                Control every shipment in
                                <span class="bg-gradient-to-r from-amber-300 via-amber-400 to-orange-500 bg-clip-text text-transparent">
                                    one TMS dashboard
                                </span>
                            </h1>
                            <p class="max-w-xl text-sm leading-relaxed text-slate-300 sm:text-base">
                                Fibrecomm TMS helps you plan routes, track vehicles, and keep customers informed
                                in real‑time. A modern Laravel-powered platform, ready for your logistics workflow.
                            </p>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            <a
                                href="{{ Route::has('login') ? route('login') : '#' }}"
                                class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-2 text-sm font-semibold text-slate-950 shadow-[0_10px_35px_rgba(251,191,36,0.35)] hover:bg-amber-300 transition-colors"
                            >
                                Log in to start
                            </a>
                            <div class="flex items-center gap-3 text-xs text-slate-300 sm:text-sm">
                                <div class="flex -space-x-2">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-800 text-[11px] font-semibold text-slate-100 border border-slate-700">
                                        Ops
                                    </span>
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-800 text-[11px] font-semibold text-slate-100 border border-slate-700">
                                        Admin
                                    </span>
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-800 text-[11px] font-semibold text-slate-100 border border-slate-700">
                                        CX
                                    </span>
                                </div>
                                <span>Built for operations, admin, and support teams.</span>
                            </div>
                        </div>

                        {{-- Feature bullets --}}
                        <div id="features" class="grid gap-4 text-sm text-slate-200 sm:grid-cols-3">
                            <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 shadow-sm">
                                <div class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500/15 text-emerald-300">
                                    <span class="text-base">✓</span>
                                </div>
                                <h2 class="mb-1 text-sm font-semibold">Live tracking</h2>
                                <p class="text-xs text-slate-400">
                                    See where every vehicle is, with ETA updates for each shipment.
                                </p>
                            </div>

                            <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 shadow-sm">
                                <div class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-sky-500/15 text-sky-300">
                                    <span class="text-base">↺</span>
                                </div>
                                <h2 class="mb-1 text-sm font-semibold">Smart routing</h2>
                                <p class="text-xs text-slate-400">
                                    Optimize routes to reduce empty miles and improve on‑time delivery.
                                </p>
                            </div>

                            <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 shadow-sm">
                                <div class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/15 text-amber-300">
                                    <span class="text-base">≡</span>
                                </div>
                                <h2 class="mb-1 text-sm font-semibold">Status timeline</h2>
                                <p class="text-xs text-slate-400">
                                    Clear load statuses from booking to delivery, ready for your team.
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- Right column: small "dashboard" mockup --}}
                    <section
                        id="workflow"
                        class="flex-1"
                        aria-label="Fibrecomm TMS overview"
                    >
                        <div class="relative mx-auto max-w-md rounded-3xl border border-slate-800 bg-gradient-to-b from-slate-900/90 via-slate-900 to-slate-950 p-5 shadow-[0_25px_80px_rgba(15,23,42,0.9)]">
                            <div class="mb-4 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs font-medium text-slate-300">Today’s operations</p>
                                    <p class="text-[11px] text-slate-400">Live snapshot of active loads</p>
                                </div>
                                <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-[11px] font-medium text-emerald-300">
                                    98.5% on‑time
                                </span>
                            </div>

                            <div class="mb-4 grid grid-cols-3 gap-3 text-center text-xs">
                                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 px-3 py-3">
                                    <p class="text-[10px] uppercase tracking-wide text-slate-400">Active loads</p>
                                    <p class="mt-1 text-lg font-semibold text-slate-50">42</p>
                                </div>
                                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 px-3 py-3">
                                    <p class="text-[10px] uppercase tracking-wide text-slate-400">En route</p>
                                    <p class="mt-1 text-lg font-semibold text-sky-300">29</p>
                                </div>
                                <div class="rounded-2xl border border-slate-800 bg-slate-900/70 px-3 py-3">
                                    <p class="text-[10px] uppercase tracking-wide text-slate-400">At risk</p>
                                    <p class="mt-1 text-lg font-semibold text-amber-300">3</p>
                                </div>
                            </div>

                            <div class="mb-3 flex items-center justify-between text-[11px] font-medium text-slate-400">
                                <span>Shipments stream</span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-900/80 px-2 py-0.5 text-[10px]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    Live
                                </span>
                            </div>

                            <div class="space-y-2 text-xs">
                                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950/60 px-3 py-2.5">
                                    <div>
                                        <p class="font-medium text-slate-100">KUL → JHB · FCB-1042</p>
                                        <p class="text-[11px] text-slate-400">Linehaul · ETA 13:20 · On‑time</p>
                                    </div>
                                    <span class="rounded-full bg-emerald-500/15 px-2 py-1 text-[10px] font-semibold text-emerald-300">
                                        On route
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950/60 px-3 py-2.5">
                                    <div>
                                        <p class="font-medium text-slate-100">PGU → PEN · FCB-1037</p>
                                        <p class="text-[11px] text-slate-400">Pickup · ETA 10:45 · Traffic delay</p>
                                    </div>
                                    <span class="rounded-full bg-amber-500/15 px-2 py-1 text-[10px] font-semibold text-amber-300">
                                        At risk
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950/60 px-3 py-2.5">
                                    <div>
                                        <p class="font-medium text-slate-100">JHB → CPT · FCB-1021</p>
                                        <p class="text-[11px] text-slate-400">Delivered · POD received</p>
                                    </div>
                                    <span class="rounded-full bg-sky-500/15 px-2 py-1 text-[10px] font-semibold text-sky-300">
                                        Delivered
                                    </span>
                                </div>
                            </div>

                            <div id="contact" class="mt-4 flex items-center justify-between border-t border-slate-800 pt-3 text-[11px] text-slate-400">
                                <p>Ready to connect this to your actual data.</p>
                                <p class="text-right">
                                    Built with
                                    <span class="font-semibold text-slate-100">Laravel</span>
                                    &amp;
                                    <span class="font-semibold text-slate-100">Tailwind</span>.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

            <footer class="border-t border-slate-900/80 bg-slate-950/95">
                <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-4 text-[11px] text-slate-500 sm:flex-row lg:px-8">
                    <p>&copy; {{ date('Y') }} Fibrecomm TMS. All rights reserved.</p>
                    <p>Rights by Shameel<code class="rounded bg-slate-900 px-1.5 py-0.5 text-[10px] text-slate-300"></code></p>
                </div>
            </footer>
        </div>
    </body>
</html>


