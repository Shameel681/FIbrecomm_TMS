@extends('layouts.app')

@section('main_content')
    
    {{-- Section: HOME --}}
    <section id="home">
        <div class="w-full">
            <img 
                src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&h=450&fit=crop" 
                alt="Professional team" 
                class="w-full h-[450px] object-cover block"
            >
        </div>
    </section>

    <section id="home" class="w-full bg-gray-50 py-12 px-10 border-b border-gray-200">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brand-navy">Join Us as a Practical Trainee</h2>
            <p class="text-brand-red mt-2">Are you looking to gain hands-on experience in a dynamic environment?</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center">
                <div class="mb-5 text-brand-red">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2.5 2.5 0 1 1 0 5a2.5 2.5 0 0 1 0-5zM8 10c0-2 8-2 8 0v3H8v-3zM5 6a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM19 6a2 2 0 1 1 0 4a2 2 0 0 1 0-4zM3 14c0-1.5 4-1.5 4 0v2H3v-2zM17 14c0-1.5 4-1.5 4 0v2h-4v-2z"/><rect x="6" y="17" width="12" height="3" rx="1"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-navy mb-3">Why Intern with Us?</h3>
                <ul class="text-sm text-gray-600 space-y-3 text-left list-disc list-inside">
                    <li>Be part of meaningful projects</li>
                    <li>Work with professionals</li>
                    <li>Develop skills in a supportive team</li>
                </ul>
            </div>
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center">
                <div class="mb-5 text-brand-red">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M10 2a8 8 0 1 0 4.9 14.32l4.39 4.39a1 1 0 0 0 1.42-1.42l-4.39-4.39A8 8 0 0 0 10 2zm0 2a6 6 0 1 1 0 12a6 6 0 0 1 0-12z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-navy mb-3">Opportunities</h3>
                <p class="text-sm text-gray-500">Find a role that matches your academic background and career goals.</p>
            </div>
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center">
                <div class="mb-5 text-brand-red">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 4h6v2h-6v-2zm0-4h6v2h-6v-2z"/></svg>
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
            
            <div class="bg-brand-navy text-white p-10 rounded-2xl shadow-2xl relative overflow-hidden">
                {{-- Decorative background element --}}
                <div class="absolute -right-10 -top-10 h-40 w-40 bg-white/5 rounded-full"></div>
                
                <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <svg class="h-8 w-8 text-brand-red" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9.75 14L2.25 14L2.25 17M14.25 17L14.25 14L21.75 14L21.75 17M9.75 9L9.75 6L2.25 6L2.25 9M14.25 9L14.25 6L21.75 6L21.75 9M12 21L12 18M12 3L12 6" />
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
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.056M14 10l-2 1m0 0l-2 1m2-1V3.055M10 21v-4.5M14 4.5V9m-4-7a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 001-1V2a1 1 0 00-1-1H10z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-300 flex-1">
                            Provides seamless intercity and **cross-border connectivity** for global solutions.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Core Offerings (Cards) --}}
        <h3 class="text-2xl font-bold text-brand-navy text-center mb-10 flex items-center justify-center gap-3">
            <svg class="h-8 w-8 text-brand-red" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
            </svg>
            Our Core Offerings
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center">
                <div class="mb-3 text-brand-navy">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <h4 class="font-bold text-brand-navy text-lg mb-1">Bandwidth</h4>
                <p class="text-xs text-gray-500">High-capacity data transmission.</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center">
                <div class="mb-3 text-brand-navy">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v2a2 2 0 01-2 2h-5m-9 0a2 2 0 01-2-2v-2a2 2 0 012-2h5m-9 0V7a3 3 0 013-3h3a3 3 0 013 3v4" />
                    </svg>
                </div>
                <h4 class="font-bold text-brand-navy text-lg mb-1">Infrastructure</h4>
                <p class="text-xs text-gray-500">Robust network foundations.</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center">
                <div class="mb-3 text-brand-navy">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.035 2.035M18 5l-2.035 2.035m0 0a2.5 2.5 0 00-3.536 3.536m3.536-3.536a2.5 2.5 0 013.536 3.536m0 0V21m-9-9h.01M14 15.5l1.5 1.5M10.5 9l-1.5 1.5M12 12l-3-3" />
                    </svg>
                </div>
                <h4 class="font-bold text-brand-navy text-lg mb-1">Internet</h4>
                <p class="text-xs text-gray-500">High-speed, reliable connectivity.</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-center flex flex-col items-center">
                <div class="mb-3 text-brand-navy">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2-3 .895-3 2 1.343 2 3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V3m0 9v3m0 0V21m-3-3h6M2.923 5.996h14.154a4 4 0 013.824 4.02l-1.157 7.086A4 4 0 0117.843 21H6.157a4 4 0 01-3.824-4.02l-1.157-7.086a4 4 0 013.824-4.02z" />
                    </svg>
                </div>
                <h4 class="font-bold text-brand-navy text-lg mb-1">Value Added</h4>
                <p class="text-xs text-gray-500">Enhancing services and solutions.</p>
            </div>
        </div>
        </div>
    </section>
    </section>

    {{-- Section: INTERNSHIP FORM --}}
    <section id="internship" class="min-h-screen py-24 px-10 bg-gray-50 border-b border-gray-200 flex flex-col justify-center">
        <h2 class="text-3xl font-bold text-brand-navy text-center uppercase">Internship Application</h2>
        <div class="mt-12 max-w-2xl mx-auto border-2 border-dashed border-gray-200 rounded-xl p-20 text-center text-gray-400 font-medium w-full">
            Form content will be placed here
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
                        <p class="text-gray-700 font-bold">E-mail : <a href="mailto:sales.enquiries@fibrecomm.net.my" class="text-blue-600 font-normal hover:underline">sales.enquiries@fibrecomm.net.my</a></p>
                        <p class="text-gray-700"><span class="font-bold">Phone :</span> +(603) 2240 1530</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection