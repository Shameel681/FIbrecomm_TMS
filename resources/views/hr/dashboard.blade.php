@extends('layouts.hr')

@section('header_title', 'HR Dashboard')

@section('hr_content')
<div class="space-y-10">

    {{-- Hero welcome card with accent --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm"
         data-aos="fade-down" data-aos-duration="600">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-brand-red to-brand-navy rounded-l-2xl"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-brand-navy/5 to-transparent rounded-bl-[100px]"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-8 py-8 md:py-10">
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.25em] mb-1">Welcome back</p>
                <h2 class="text-2xl md:text-3xl font-black text-brand-navy uppercase tracking-tighter">System Overview</h2>
                <p class="text-brand-red font-bold mt-2 uppercase tracking-widest text-[10px]">
                    {{ Auth::user()->name }} · {{ Auth::user()->hrProfile?->employee_id ?? 'N/A' }}
                </p>
            </div>
            <div class="flex items-center gap-4 md:gap-6">
                <div class="text-right md:text-center px-5 py-3 rounded-xl bg-gray-50/80 border border-gray-100">
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest font-bold">Today</p>
                    <p class="text-brand-navy font-black text-lg md:text-xl mt-0.5">{{ now()->format('D, d M Y') }}</p>
                </div>
                <div class="hidden md:block h-12 w-px bg-gray-200"></div>
            </div>
        </div>
    </div>

    {{-- Stat cards with distinct accents and hover lift --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
        $cards = [
            [
                'title'   => 'Trainees',
                'count'   => $totalTrainees,
                'desc'    => 'Manage active interns and internship progress.',
                'icon'    => 'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z',
                'route'   => route('hr.trainees'),
                'delay'   => '100',
                'accent'  => 'brand-red',
            ],
            [
                'title'   => 'Supervisors',
                'count'   => $totalSupervisors,
                'desc'    => 'Assign department leads to internship programs.',
                'icon'    => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'route'   => route('hr.attendance.assign'),
                'delay'   => '200',
                'accent'  => 'brand-navy',
            ],
        ];
        @endphp

        @foreach($cards as $card)
        <a href="{{ $card['route'] }}"
           data-aos="fade-up"
           data-aos-delay="{{ $card['delay'] }}"
           data-aos-offset="0"
           class="group relative block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden
                  hover:shadow-xl hover:-translate-y-1 hover:border-gray-200 transition-all duration-300 ease-out">
            {{-- Top accent bar --}}
            <div class="h-1 w-full {{ $card['accent'] === 'brand-red' ? 'bg-brand-red' : 'bg-brand-navy' }} opacity-90 group-hover:opacity-100 transition-opacity"></div>
            <div class="p-6 md:p-8">
                <div class="flex items-start gap-5">
                    <div class="shrink-0 w-14 h-14 rounded-2xl {{ $card['accent'] === 'brand-red' ? 'bg-brand-red/10 text-brand-red group-hover:bg-brand-red group-hover:text-white' : 'bg-brand-navy/10 text-brand-navy group-hover:bg-brand-navy group-hover:text-white' }} flex items-center justify-center transition-all duration-300 shadow-inner">
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $card['icon'] }}"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-lg font-black text-brand-navy uppercase tracking-tight group-hover:text-brand-red transition-colors duration-300">
                                {{ $card['title'] }}
                            </h3>
                            <span class="shrink-0 min-w-[2.25rem] h-9 px-2 rounded-xl bg-brand-navy text-white text-xs font-black flex items-center justify-center shadow-md border border-brand-navy/20">
                                {{ $card['count'] }}
                            </span>
                        </div>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-2 leading-relaxed">
                            {{ $card['desc'] }}
                        </p>
                        <span class="inline-flex items-center gap-1.5 mt-4 text-[9px] font-black text-brand-red uppercase tracking-widest group-hover:gap-2 transition-all duration-300">
                            Open
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Quick navigation: pill-style links with clearer hierarchy --}}
    <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
         data-aos="fade-up" data-aos-delay="400" data-aos-offset="0">
        <div class="absolute top-0 right-0 w-48 h-48 bg-brand-navy/5 rounded-bl-[80px]"></div>
        <div class="relative p-6 md:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-sm font-black text-brand-navy uppercase tracking-[0.15em]">Quick navigation</h3>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">Jump to any section</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('hr.dashboard') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">1</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">HR Dashboard</span>
                </a>
                <a href="{{ route('hr.applicants') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">2</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Applicants</span>
                </a>
                <a href="{{ route('hr.trainees') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">3</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Manage Trainee</span>
                </a>
                <a href="{{ route('hr.attendance.assign') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">4</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Manage Supervisors</span>
                </a>
            </div>
            <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
                <a href="{{ route('hr.submissions.traineeMonthly') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-brand-navy/5 border-2 border-brand-navy/10 hover:border-brand-red/30 hover:bg-brand-red/5 transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">5</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Monthly Attendance</span>
                </a>
                <a href="{{ route('hr.profile.edit') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-brand-navy/5 border-2 border-brand-navy/10 hover:border-brand-red/30 hover:bg-brand-red/5 transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">6</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Manage Profile</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
