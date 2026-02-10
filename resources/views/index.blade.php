@extends('layouts.app')

@push('styles')
    {{-- AOS CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Prevents horizontal scrollbar during slide animations */
        #about, #home-intro { overflow-x: hidden; }

        <style>
    /* ... existing styles ... */

    /* Core Offering Hover Animation */
    .offering-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Notification Animations */
        @keyframes slideDown {
            from { transform: translate(-50%, -100%); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
        
        .animate-slide-down {
            position: relative;
            animation: slideDown 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .fade-out {
            transition: opacity 0.6s ease, transform 0.6s ease;
            opacity: 0 !important;
            transform: translate(-50%, -20px) !important;
        }

    .offering-card:hover {
        background-color: #EF4023; /* brand-red */
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(239, 64, 35, 0.2);
        border-color: #EF4023;
    }

    /* Change text and icon colors to white on hover */
    .offering-card:hover h4, 
    .offering-card:hover p, 
    .offering-card:hover .icon-container {
        color: white !important;
    }

    .offering-card .icon-container {
        transition: transform 0.3s ease;
    }

    .offering-card:hover .icon-container {
        transform: scale(1.1);
    }
</style>

@endpush

@section('main_content')
    
    {{-- Section: HOME --}}
    <section id="home">
        <div class="w-full">
            <img 
                src="/images/photo1.png" 
                alt="Professional team" 
                class="w-full h-[450px] object-cover block">
        </div>
    </section>

    <section id="home" class="w-full bg-gray-50 py-12 px-10 border-b border-gray-200">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-brand-navy">Join Us as a Practical Trainee</h2>
            <p class="text-brand-red mt-2">Are you looking to gain hands-on experience in a dynamic environment?</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- 1. Home Card 1 --}}
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-5 text-brand-red" data-aos="zoom-in" data-aos-delay="400">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2.5 2.5 0 1 1 0 5a2.5 2.5 0 0 1 0-5zM8 10c0-2 8-2 8 0v3H8v-3zM5 6a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM19 6a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM3 14c0-1.5 4-1.5 4 0v2H3v-2zM17 14c0-1.5 4-1.5 4 0v2h-4v-2z"/><rect x="6" y="17" width="12" height="3" rx="1"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-navy mb-3">Why Intern with Us?</h3>
                <ul class="text-sm text-gray-600 space-y-3 text-left list-disc list-inside">
                    <li>Be part of meaningful projects</li>
                    <li>Work with professionals</li>
                    <li>Develop skills in a supportive team</li>
                </ul>
            </div>
            
            {{-- 1. Home Card 2 --}}
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
                <div class="mb-5 text-brand-red" data-aos="zoom-in" data-aos-delay="500">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M10 2a8 8 0 1 0 4.9 14.32l4.39 4.39a1 1 0 0 0 1.42-1.42l-4.39-4.39A8 8 0 0 0 10 2zm0 2a6 6 0 1 1 0 12a6 6 0 0 1 0-12z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-navy mb-3">Opportunities</h3>
                <p class="text-sm text-gray-500">Find a role that matches your academic background and career goals.</p>
                        </div>

            {{-- 1. Home Card 3 --}}
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center" data-aos="fade-up" data-aos-delay="300">
                <div class="mb-5 text-brand-red" data-aos="zoom-in" data-aos-delay="600">
                     <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                         <path d="M3 3h7v7H3V3 h0 M14 3h7v7h-7V3 h0 M14 14h7v7h-7v-7 h0 M3 14h7v7H3v-7 " /> 
                        </svg>
                    </div>

                <h3 class="text-xl font-bold text-brand-navy mb-3">Fields Available</h3>
                <p class="text-sm text-gray-500">IT, Engineering, HR, Finance, and many other corporate departments.</p>
            </div>
        </div>
    </section>

    {{-- Section: ABOUT US --}}
    <section id="about" class="w-full bg-gray-20 py-12 px-10 border-b border-gray-200"> 
    <div class="max-w-6xl mx-auto">
        
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-brand-navy uppercase tracking-wider">About Fibrecomm</h2>
            <div class="h-1 w-20 bg-brand-red mx-auto mt-4"></div>
            <p class="text-gray-600 mt-6 max-w-3xl mx-auto leading-relaxed">
                Fibrecomm Network (M) Sdn Bhd was formed to develop a premier fibre optic telecommunication network utilizing TNB’s electrical transmission lines and distribution infrastructure.
            </p>
        </div>

        {{-- History & Technical Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20">
            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-brand-navy flex items-center gap-3">
                    <svg class="h-8 w-8 text-brand-red" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Our Heritage
                </h3>
                <p class="text-gray-600 leading-relaxed italic border-l-4 border-brand-red pl-6">
                    Incorporated on 21st May 1992 as Celcom Advance Network Services, we evolved through a decade of growth to become Fibrecomm Network (M) Sdn Bhd in 1999, solidifying our identity as a leading network carrier.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Today, we are a key network carrier providing a full suite of telecommunication services. We address the critical needs of service providers: reliable performance, short time-to-market, and cost-effective solutions.
                </p>
            </div>
            
            {{-- 2. The Blue Box --}}
            <div class="bg-brand-navy text-white p-10 rounded-2xl shadow-2xl relative overflow-hidden" data-aos="fade-left">
                <div class="absolute -right-10 -top-10 h-40 w-40 bg-white/5 rounded-full"></div>
                
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <svg class="h-8 w-8 text-brand-red" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <line x1="12" y1="2" x2="12" y2="6" stroke-linecap="round" stroke-linejoin="round" />
                           <line x1="12" y1="18" x2="12" y2="22" stroke-linecap="round" stroke-linejoin="round" />
                           <line x1="4.93" y1="4.93" x2="7.76" y2="7.76" stroke-linecap="round" stroke-linejoin="round" />
                           <line x1="16.24" y1="16.24" x2="19.07" y2="19.07" stroke-linecap="round" stroke-linejoin="round" />
                           <line x1="2" y1="12" x2="6" y2="12" stroke-linecap="round" stroke-linejoin="round" />
                           <line x1="18" y1="12" x2="22" y2="12" stroke-linecap="round" stroke-linejoin="round" />
                           <line x1="4.93" y1="19.07" x2="7.76" y2="16.24" stroke-linecap="round" stroke-linejoin="round" />
                           <line x1="16.24" y1="7.76" x2="19.07" y2="4.93" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    Our Infrastructure
                </h3>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="text-brand-red mt-1 font-bold text-xl">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-300 flex-1">
                            **110,000 km+** Peninsula-wide and Sabah fibre optics backbone network.
                        </p>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-brand-red mt-1 font-bold text-xl">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2V5a2 2 0 00-2-2H9a2 2 0 00-2 2v12a4 4 0 01-4 4zm8-12a2 2 0 012-2h2a2 2 0 012 2v5a2 2 0 01-2 2h-2a2 2 0 01-2-2v-5z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-300 flex-1">
                            High-speed capacity of **10G/40G**, with **100G** expansion planned.
                        </p>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-brand-red mt-1 font-bold text-xl">
                            <svg class="h-8 w-8 text-brand-red" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <circle cx="12" cy="12" r="2" />
                                 <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M16.24 7.76a6 6 0 0 1 0 8.49
                                    m-8.48-.01a6 6 0 0 1 0-8.49
                                     m11.31-2.82a10 10 0 0 1 0 14.14
                                      m-14.14 0a10 10 0 0 1 0-14.14" />
                                  </svg>

                        </div>
                        <p class="text-sm text-gray-300 flex-1">
                            Provides seamless intercity and **cross-border connectivity** for global solutions.
                        </p>
                    </div>
                                </div>
                            </div>
                        </div>

        {{-- 3. Core Offerings --}}
    <h3 class="text-2xl font-bold text-brand-navy text-center mb-10 flex items-center justify-center gap-3">
    <svg class="h-8 w-8 text-brand-red" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
    </svg>
    Our Core Offerings
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{-- Card 1 --}}
    <div class="offering-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center cursor-default" data-aos="zoom-in" data-aos-delay="100">
        <div class="icon-container mb-3 text-brand-navy">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 7.205c4.418 0 8-1.165 8-2.602C20 3.165 16.418 2 12 2S4 3.165 4 4.603c0 1.437 3.582 2.602 8 2.602ZM12 22c4.963 0 8-1.686 8-2.603v-4.404c-.052.032-.112.06-.165.09a7.75 7.75 0 0 1-.745.387c-.193.088-.394.173-.6.253-.063.024-.124.05-.189.073a18.934 18.934 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.073a10.143 10.143 0 0 1-.852-.373 7.75 7.75 0 0 1-.493-.267c-.053-.03-.113-.058-.165-.09v4.404C4 20.315 7.037 22 12 22Zm7.09-13.928a9.91 9.91 0 0 1-.6.253c-.063.025-.124.05-.189.074a18.935 18.935 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.074a10.163 10.163 0 0 1-.852-.372 7.816 7.816 0 0 1-.493-.268c-.055-.03-.115-.058-.167-.09V12c0 .917 3.037 2.603 8 2.603s8-1.686 8-2.603V7.596c-.052.031-.112.059-.165.09a7.816 7.816 0 0 1-.745.386Z"/>
            </svg>
        </div>
        <h4 class="font-bold text-brand-navy text-lg mb-1">Bandwidth</h4>
        <p class="text-xs text-gray-500">High-capacity data transmission.</p>
    </div>

    {{-- Card 2 --}}
    <div class="offering-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center cursor-default" data-aos="zoom-in" data-aos-delay="200">
        <div class="icon-container mb-3 text-brand-navy">
            <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z" />
            </svg>
                                </div>
        <h4 class="font-bold text-brand-navy text-lg mb-1">Infrastructure</h4>
        <p class="text-xs text-gray-500">Robust network foundations.</p>
                            </div>

    {{-- Card 3 --}}
    <div class="offering-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center cursor-default" data-aos="zoom-in" data-aos-delay="300">
        <div class="icon-container mb-3 text-brand-navy">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3a17.9 17.9 0 0 0-10.95 3.7 1 1 0 0 0-.1 1.48l1.42 1.6a1 1 0 0 0 1.35.1A14 14 0 0 1 12 7a14 14 0 0 1 8.28 2.88 1 1 0 0 0 1.35-.1l1.42-1.6a1 1 0 0 0-.1-1.48A17.9 17.9 0 0 0 12 3Z"/>
                <path d="M12 9a11.9 11.9 0 0 0-7.37 2.46 1 1 0 0 0-.13 1.46l1.53 1.76a1 1 0 0 0 1.33.14A8 8 0 0 1 12 13a8 8 0 0 1 4.64 1.82 1 1 0 0 0 1.33-.14l1.53-1.76a1 1 0 0 0-.13-1.46A11.9 11.9 0 0 0 12 9Z"/>
                <path d="M12 15a6 6 0 0 0-3.47 1.11 1 1 0 0 0-.16 1.44l2.02 2.31a1 1 0 0 0 1.22.22l.39-.2.39.2a1 1 0 0 0 1.22-.22l2.02-2.31a1 1 0 0 0-.16-1.44A6 6 0 0 0 12 15Z"/>
            </svg>
                                </div>
        <h4 class="font-bold text-brand-navy text-lg mb-1">Internet</h4>
        <p class="text-xs text-gray-500">High-speed, reliable connectivity.</p>
                            </div>

    {{-- Card 4 --}}
    <div class="offering-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center cursor-default" data-aos="zoom-in" data-aos-delay="400">
        <div class="icon-container mb-3 text-brand-navy">
            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.503 2.134a1 1 0 0 0-1 0L4.501 6.17A1 1 0 0 0 4.5 7.902l7.002 4.047a1 1 0 0 0 1 0l6.998-4.04a1 1 0 0 0 0-1.732l-6.997-4.042Z" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.005 10.19a1 1 0 0 1 1 1v.233l5.998 3.464L18 11.423v-.232a1 1 0 1 1 2 0V12a1 1 0 0 1-.5.866l-6.997 4.042a1 1 0 0 1-1 0l-6.998-4.042a1 1 0 0 1-.5-.866v-.81a1 1 0 0 1 1-1Z" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5 15.15a1 1 0 0 1 1 1v.232l5.997 3.464 5.998-3.464v-.232a1 1 0 1 1 2 0v.81a1 1 0 0 1-.5.865l-6.998 4.042a1 1 0 0 1-1 0L4.5 17.824a1 1 0 0 1-.5-.866v-.81a1 1 0 0 1 1-1Z" />
            </svg>
        </div>
        <h4 class="font-bold text-brand-navy text-lg mb-1">Value Added</h4>
        <p class="text-xs text-gray-500">Enhancing services and solutions.</p>
                                </div>
                            </div>
                        </div>
                    </section>

    {{-- Section: INTERNSHIP FORM --}}
    <section id="internship" class="py-24 px-10 bg-gray-50 border-b border-gray-200">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brand-navy uppercase tracking-wider">Internship Application</h2>
            <div class="h-1 w-20 bg-brand-red mx-auto mt-4"></div>
            <p class="text-gray-500 mt-4 text-sm">Please scroll within the box to complete all fields.</p>
        </div>

        {{-- Fixed Overlay Notification Container --}}
        <div id="notification-container" class="fixed top-10 left-1/2 -translate-x-1/2 z-[9999] w-full max-w-md px-4 pointer-events-none">
            {{-- Success Alert --}}
            @if(session('success'))
                <div id="status-alert" class="pointer-events-auto mb-4 p-4 bg-white border-l-4 border-green-500 text-gray-800 rounded-r-xl shadow-2xl flex items-center justify-between animate-slide-down">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600 transition-colors">&times;</button>
                </div>
            @endif

            {{-- Error Alert --}}
            @if($errors->any())
                <div id="status-alert" class="pointer-events-auto mb-4 p-4 bg-white border-l-4 border-brand-red text-gray-800 rounded-r-xl shadow-2xl animate-slide-down">
                    <div class="flex items-start">
                        <div class="bg-red-100 p-2 rounded-full mr-3">
                            <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-sm text-brand-navy">Submission Error</p>
                            <ul class="text-xs mt-1 list-disc list-inside text-gray-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button onclick="this.parentElement.remove()" class="ml-auto text-gray-400 hover:text-gray-600">&times;</button>
                    </div>
                                </div>
            @endif
                            </div>

        <form action="{{ route('trainee.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
            @csrf
            
            <div class="max-h-[600px] overflow-y-auto p-8 md:p-12 custom-scrollbar">
                
                {{-- BLOCK 1: PERSONAL INFORMATION --}}
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-brand-red mb-6 flex items-center gap-2">
                        <span class="bg-brand-red text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">1. Full Name (as per NRIC/IC)</label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" required 
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all uppercase" placeholder="">
                        </div>
                        <div>
                             <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">2. Email Address</label>
                             <input type="email" name="email" value="{{ old('email') }}" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$" title="Please enter a valid email address ending in .com" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all"  placeholder="name@email.com">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">3. Phone No. (10-11 digits)</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required pattern="[0-9]{10,11}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all" placeholder="0123456789">
                                </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">4. Current Address</label>
                            <textarea name="address" rows="3" required 
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red focus:ring-2 focus:ring-brand-red/20 outline-none transition-all resize-none" placeholder="">{{ old('address') }}</textarea>
                                </div>
                                </div>
                            </div>

                <hr class="mb-10 border-gray-100">

                {{-- BLOCK 2: ACADEMIC BACKGROUND --}}
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-brand-red mb-6 flex items-center gap-2">
                        <span class="bg-brand-red text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                        Academic Background
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">5. Name of Institution</label>
                            <input type="text" name="institution" value="{{ old('institution') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">6. Fields of Study / Major</label>
                            <input type="text" name="major" value="{{ old('major') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">7. Current Level of Study</label>
                            <div class="flex flex-wrap gap-4 mt-3">
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                    <input type="radio" name="study_level" value="diploma" onclick="toggleStudyOther(false)" required {{ old('study_level') == 'diploma' ? 'checked' : '' }} class="accent-brand-red"> Diploma
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                    <input type="radio" name="study_level" value="degree" onclick="toggleStudyOther(false)" {{ old('study_level') == 'degree' ? 'checked' : '' }} class="accent-brand-red"> Degree
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                    <input type="radio" name="study_level" value="others" onclick="toggleStudyOther(true)" id="lvl_others" {{ old('study_level') == 'others' ? 'checked' : '' }} class="accent-brand-red"> Others:
                                </label>
                                <input type="text" name="study_level_other" id="study_level_other" disabled value="{{ old('study_level_other') }}"
                                    class="border-b border-gray-300 focus:border-brand-red outline-none text-sm pb-1 w-32 disabled:bg-gray-100 italic" placeholder="Specify level">
                            </div>
                        </div>
                                    <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">8. Expected Graduation</label>
                            <input type="date" name="grad_date" value="{{ old('grad_date') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all">
                        </div>
                    </div>
                                    </div>

                <hr class="mb-10 border-gray-100">

                {{-- BLOCK 3: INTERNSHIP DETAILS --}}
                <div class="mb-5">
                    <h3 class="text-lg font-bold text-brand-red mb-6 flex items-center gap-2">
                        <span class="bg-brand-red text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
                        Internship Preferences & Documents
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">9. Duration (Months)</label>
                            <input type="number" name="duration" value="{{ old('duration') }}" min="1" max="12" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all" placeholder="e.g. 4">
                                </div>

                        {{-- UPDATED DATE SECTION --}}
                                    <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">10. Preferred Start Date</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all">
                                    </div>
                        <div>
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">11. Expected End Date</label>
                            <input type="date" name="expected_end_date" value="{{ old('expected_end_date') }}" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all">
                                </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">12. Area of Interest</label>
                            <select name="interest" id="interest_select" onchange="toggleInterestOther()" required 
                                class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-brand-red outline-none transition-all bg-white">
                                <option value="">-- Select Area --</option>
                                @php
                                    $interests = ['Engineering', 'IT', 'Product', 'Business Development', 'Marketing Communication', 'Sales', 'Procurement', 'Finance', 'Account', 'Strategic Management', 'Human Resource', 'Administration', 'Legal & Regulatory', 'Integrity & Governance', 'Risk Management', 'Others'];
                                @endphp
                                @foreach($interests as $opt)
                                    <option value="{{ $opt }}" {{ old('interest') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="interest_other" id="interest_other" disabled value="{{ old('interest_other') }}"
                                class="w-full mt-3 px-4 py-2 rounded-lg border border-gray-100 italic text-sm outline-none focus:border-brand-red disabled:bg-gray-100" placeholder="If 'Others', please specify here">
                        </div>
                        <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <label class="block text-sm font-bold text-brand-navy mb-4">13. Required for coursework?</label>
                            <div class="flex gap-8">
                                <label class="flex items-center gap-2 font-medium text-gray-700 cursor-pointer">
                                    <input type="radio" name="coursework_req" value="yes" required {{ old('coursework_req') == 'yes' ? 'checked' : '' }} class="accent-brand-red"> Yes
                                </label>
                                <label class="flex items-center gap-2 font-medium text-gray-700 cursor-pointer">
                                    <input type="radio" name="coursework_req" value="no" {{ old('coursework_req') == 'no' ? 'checked' : '' }} class="accent-brand-red"> No
                                </label>
                                    </div>
                                </div>

                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">14. Upload CV/Resume (PDF)</label>
                                <input type="file" name="cv_file" accept=".pdf" required 
                                    class="w-full px-4 py-2 rounded-lg border border-gray-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-brand-navy file:text-white hover:file:bg-brand-red file:cursor-pointer transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-brand-navy mb-2 uppercase">15. University Letter (PDF)</label>
                                <input type="file" name="uni_letter" accept=".pdf" required 
                                    class="w-full px-4 py-2 rounded-lg border border-gray-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-brand-navy file:text-white hover:file:bg-brand-red file:cursor-pointer transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-gray-50 border-t border-gray-100">
                <button type="submit" class="w-full bg-brand-navy hover:bg-brand-red text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-xl uppercase tracking-widest">
                    Submit Application
                </button>
            </div>
        </form>
                        </div>
                    </section>


    {{-- Section: OUR LOCATION --}}
    <section id="location" class="min-h-screen py-12 px-10 bg-gray-20 border-b border-gray-200 flex flex-col justify-center">
        <div class="max-w-5xl mx-auto w-full">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-brand-navy uppercase">Our Location</h2>
                <div class="h-1 w-20 bg-brand-red mx-auto mt-4"></div>
            </div>
            <div class="relative bg-white p-3 rounded-2xl shadow-xl border border-gray-200">
                <div class="overflow-hidden rounded-xl h-[450px] w-full bg-gray-100">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.918824511076!2d101.66336057559886!3d3.1161764968593735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4986a66edc7b%3A0xc580e7da1e59d428!2sFibrecomm%20Network%20(M)%20Sdn%20Bhd!5e0!3m2!1sen!2smy!4v1767685691131!5m2!1sen!2smy%22" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="absolute bottom-10 left-10 hidden md:block bg-white p-6 rounded-lg shadow-2xl border-l-4 border-brand-red max-w-sm">
                    <h4 class="font-bold text-brand-navy text-lg mb-1">Fibrecomm Network</h4>
                    <p class="text-gray-600 text-xs leading-relaxed mb-4">Level 37, Menara TM, Jalan Pantai Baharu,<br>50672 Kuala Lumpur, Malaysia.</p>
                    <a href="https://maps.app.goo.gl/VBXtejMhho93bZa58" class="text-brand-red text-xs font-bold hover:underline">GET DIRECTIONS →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Section: CONTACT US --}}
    <section id="contact" class="min-h-screen py-12 px-10 bg-white flex flex-col justify-center">
        <div class="max-w-6xl mx-auto w-full">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-brand-navy">Contact Us</h2>
                <div class="h-1 w-20 bg-brand-red mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-gray-50 p-10 rounded-2xl border border-gray-100">
                    <h4 class="font-bold text-gray-800 text-xl mb-1">Fibrecomm Network (M) Sdn. Bhd.</h4>
                    <p class="text-sm text-gray-500 mb-6 font-medium">(199201009356)</p>
                    <div class="text-gray-600 text-md leading-relaxed mb-8">Level 35 (North Wing), Menara TM,<br>Off Jalan Pantai Baharu,<br>59200 Kuala Lumpur</div>
                    <div class="space-y-4 text-md">
                        <p class="text-gray-700 font-bold">E-mail : <a href="mailto:sales.enquiries@fibrecomm.net.my" class="text-blue-600 font-normal hover:underline">sales.enquiries@fibrecomm.net.my</a></p>
                        <p class="text-gray-700"><span class="font-bold">Phone :</span> +(603) 2240 1530</p>
                    </div>
                </div>
                <div class="bg-gray-50 p-10 rounded-2xl border border-gray-100">
                    <h4 class="font-bold text-gray-800 text-xl mb-1">Network Operation Centre</h4>
                    <p class="text-sm text-gray-500 mb-6 font-medium">(24 hours)</p>
                    <div class="text-gray-600 text-md leading-relaxed mb-8">Level 35 (North Wing), Menara TM,<br>Off Jalan Pantai Baharu,<br>59200 Kuala Lumpur</div>
                    <div class="space-y-4 text-md">
                        <p class="text-gray-700 font-bold">E-mail : <a href="mailto:nocfcn@fibrecomm.net.my" class="text-blue-600 font-normal hover:underline">nocfcn@fibrecomm.net.my</a></p>
                        <p class="text-gray-700"><span class="font-bold">Phone :</span> +(603) 2240 1530</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    {{-- AOS JS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out',
        });

        function toggleStudyOther(show) {
            const otherInput = document.getElementById('study_level_other');
            if (otherInput) {
                otherInput.disabled = !show;
                otherInput.required = show;
                if (!show) {
                    otherInput.value = '';
                }
            }
        }


        function toggleInterestOther() {
            const select = document.getElementById('interest_select');
            const otherInput = document.getElementById('interest_other');
            
            if (select && otherInput) {
                const isOthers = select.value === 'Others';
                otherInput.disabled = !isOthers;
                otherInput.required = isOthers;
                if (!isOthers) {
                    otherInput.value = '';
                }
            }
        }


        function initAutoHide() {
            const alerts = document.querySelectorAll('#status-alert');
            alerts.forEach(alert => {
                // Auto-hide after 7 seconds
                setTimeout(() => {
                    alert.classList.add('fade-out');
                    setTimeout(() => {
                        alert.remove();
                    }, 600);
                }, 7000); 
            });
        }


        window.addEventListener('DOMContentLoaded', () => {
            initAutoHide();
            const interestSelect = document.getElementById('interest_select');
            if (interestSelect) toggleInterestOther();

            const othersRadio = document.getElementById('lvl_others');
            if (othersRadio) toggleStudyOther(othersRadio.checked);
        });
    </script>

    
@endpush