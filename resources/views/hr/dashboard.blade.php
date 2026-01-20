@extends('layouts.hr')

@section('header_title', 'Admin Dashboard')

@section('hr_content')
<div class="space-y-10">
    
    {{-- Header Profile Card - Triggers Immediately --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-8 border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden" 
         data-aos="fade-down" data-aos-duration="800">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-navy/5 rounded-bl-full"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-brand-navy uppercase tracking-tighter">System Overview</h2>
            <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-xs">
                HR Administrator | {{ Auth::user()->hrProfile?->employee_id }}
            </p>
        </div>
        
        <div class="mt-4 md:mt-0 text-right relative z-10">
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Today's Date</p>
            <p class="text-brand-navy font-black text-xl">
                {{ now()->format('D, d M Y') }}
            </p>
        </div>
    </div>

    {{-- Stats & Navigation Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        @php
        $dashboardCards = [
        [
            'title' => 'Trainees',
            'count' => $totalTrainees, // This variable must be passed from the Controller
            'desc'  => 'Manage all active practical students and their internship progress.',
            'icon'  => 'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z',
            'route' => route('hr.trainees'), // Use PHP function, no quotes or curly braces
            'delay' => '100', // Use standard PHP comments // if needed
        ],
        [
            'title' => 'Supervisors',
            'count' => $totalSupervisors,
            'desc' => 'View and assign department leads to guide active internship programs.',
            'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
            'route' => '#', 
            'delay' => '200'
        ],
        [
            'title' => 'HR Team',
            'count' => $totalHR,
            'desc' => 'System administrators with full control over the management portal.',
            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            'route' => '#', 
            'delay' => '300'
        ],
                ];
        @endphp

        @foreach($dashboardCards as $card)
        <a href="{{ $card['route'] }}" 
           data-aos="zoom-in-up" 
           data-aos-delay="{{ $card['delay'] }}"
           data-aos-offset="0" {{-- Important: triggers even if not fully in view --}}
           class="group relative bg-white p-8 border border-gray-100 rounded-2xl shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:border-brand-red/20 text-center">
            
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="mb-6 p-5 rounded-full bg-gray-50 text-brand-red group-hover:bg-brand-red group-hover:text-white transition-all duration-700 transform group-hover:rotate-[360deg] shadow-inner relative">
                    <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="{{ $card['icon'] }}"/>
                    </svg>
                    <div class="absolute -top-1 -right-1 bg-brand-navy text-white text-[10px] font-black w-7 h-7 rounded-full flex items-center justify-center border-2 border-white group-hover:bg-white group-hover:text-brand-red transition-colors">
                        {{ $card['count'] }}
                    </div>
                </div>
                
                <h3 class="text-2xl font-black text-brand-navy mb-3 uppercase tracking-tighter group-hover:text-brand-red transition-colors duration-300">
                    {{ $card['title'] }}
                </h3>
                
                <p class="text-sm text-gray-500 leading-relaxed px-2 font-medium">
                    {{ $card['desc'] }}
                </p>

                <div class="mt-8 w-12 h-1.5 bg-gray-100 group-hover:w-full group-hover:bg-brand-red transition-all duration-500 rounded-full"></div>
            </div>
        </a>
        @endforeach

    </div>

    {{-- Lower Section: Quick Links --}}
    <div class="bg-brand-navy rounded-2xl p-10 text-white relative overflow-hidden shadow-xl" 
         data-aos="fade-up" data-aos-delay="400" data-aos-offset="0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-20 -mt-20"></div>
        <div class="relative z-10">
            <h4 class="text-xl font-black uppercase tracking-widest text-brand-red mb-6">Management Shortcuts</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('hr.applicants') }}" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Applicants
                </a>
                <a href="#" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Reports
                </a>
                <a href="#" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Attendance
                </a>
                <a href="#" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Logs
                </a>
            </div>
        </div>
    </div>
</div>
@endsection