@extends('layouts.trainee')

@section('content')
<div class="space-y-10">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-8 border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden" 
         data-aos="fade-down" data-aos-delay="100">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-navy/5 rounded-bl-full"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-brand-navy">Dashboard Overview</h2>
            <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-xs">
                Practical Trainee | ID: #{{ Auth::guard('trainee')->user()->id }}
            </p>
        </div>
        <div class="mt-4 md:mt-0 text-right relative z-10">
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Internship Period</p>
            <p class="text-brand-navy font-black text-lg">
                {{ Auth::guard('trainee')->user()->start_date }} — {{ Auth::guard('trainee')->user()->end_date }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        @php
            $dashboardCards = [
                [
                    'title' => 'Main Home',
                    'desc' => 'Return to your primary overview and status updates.',
                    'icon' => 'M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z',
                    'route' => route('trainee.dashboard'),
                    'delay' => '200'
                ],
                [
                    'title' => 'Attendance',
                    'desc' => 'Log your daily clock-in/out times and monitor your monthly percentage.',
                    'icon' => 'M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z',
                    'route' => '#', // You can update this once the attendance route is ready
                    'delay' => '400'
                ],
                [
                    'title' => 'My Profile',
                    'desc' => 'Access your personal records, contact info, and documents.',
                    'icon' => 'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z',
                    'route' => route('trainee.profile'), // Updated to the real route
                    'delay' => '600'
                ],
            ];
        @endphp

        @foreach($dashboardCards as $card)
        <a href="{{ $card['route'] }}" 
           data-aos="zoom-in-up" 
           data-aos-delay="{{ $card['delay'] }}"
           class="group relative bg-white p-8 border border-gray-100 rounded-2xl shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:border-brand-red/20 text-center">
            
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-gray-50/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="mb-6 p-5 rounded-full bg-gray-50 text-brand-red group-hover:bg-brand-red group-hover:text-white transition-all duration-700 transform group-hover:rotate-[360deg] shadow-inner">
                    <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-brand-navy mb-3 uppercase tracking-tight group-hover:text-brand-red transition-colors duration-300">
                    {{ $card['title'] }}
                </h3>
                
                <p class="text-sm text-gray-500 leading-relaxed px-2">
                    {{ $card['desc'] }}
                </p>

                <div class="mt-8 w-12 h-1 bg-gray-100 group-hover:w-full group-hover:bg-brand-red transition-all duration-500 rounded-full"></div>
            </div>
        </a>
        @endforeach

    </div>
</div>
@endsection