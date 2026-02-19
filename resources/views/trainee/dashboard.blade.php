@extends('layouts.trainee')

@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-10">

    {{-- Hero welcome card with accent --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm"
         data-aos="fade-down" data-aos-duration="600">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-brand-red to-brand-navy rounded-l-2xl"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-brand-navy/5 to-transparent rounded-bl-[100px]"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-8 py-8 md:py-10">
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.25em] mb-1">Welcome back</p>
                <h2 class="text-2xl md:text-3xl font-black text-brand-navy uppercase tracking-tighter">Overview</h2>
                <p class="text-brand-red font-bold mt-2 uppercase tracking-widest text-[10px]">
                    {{ $trainee->name }} · ID #{{ $trainee->id }}
                </p>
            </div>
            <div class="flex items-center gap-4 md:gap-6">
                <div class="text-right md:text-center px-5 py-3 rounded-xl bg-gray-50/80 border border-gray-100">
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest font-bold">Days left</p>
                    <p class="text-brand-navy font-black text-lg md:text-xl mt-0.5">{{ $daysLeft }}</p>
                </div>
                <div class="hidden md:block h-12 w-px bg-gray-200"></div>
            </div>
        </div>
    </div>

    {{-- Action cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
        $cards = [
            [
                'title'   => 'Daily Attendance',
                'count'   => 'Go',
                'desc'    => 'Record your clock-in and view daily attendance.',
                'icon'    => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                'route'   => route('trainee.attendance.index'),
                'delay'   => '100',
                'accent'  => 'brand-red',
            ],
            [
                'title'   => 'Monthly Report',
                'count'   => 'View',
                'desc'    => 'Submit and view your monthly attendance summary.',
                'icon'    => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                'route'   => route('trainee.monthly.index'),
                'delay'   => '200',
                'accent'  => 'brand-navy',
            ],
            [
                'title'   => 'My Profile',
                'count'   => 'Edit',
                'desc'    => 'View and update your personal details.',
                'icon'    => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                'route'   => route('trainee.profile'),
                'delay'   => '300',
                'accent'  => 'brand-red',
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
            <div class="h-1 w-full {{ $card['accent'] === 'brand-red' ? 'bg-brand-red' : 'bg-brand-navy' }} opacity-90 group-hover:opacity-100 transition-opacity"></div>
            <div class="p-6 md:p-8">
                <div class="flex items-start gap-5">
                    <div class="shrink-0 w-14 h-14 rounded-2xl {{ $card['accent'] === 'brand-red' ? 'bg-brand-red/10 text-brand-red group-hover:bg-brand-red group-hover:text-white' : 'bg-brand-navy/10 text-brand-navy group-hover:bg-brand-navy group-hover:text-white' }} flex items-center justify-center transition-all duration-300 shadow-inner">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-lg font-black text-brand-navy uppercase tracking-tight group-hover:text-brand-red transition-colors duration-300">
                                {{ $card['title'] }}
                            </h3>
                            <span class="shrink-0 min-w-[2.25rem] h-9 px-2 rounded-xl bg-brand-navy text-white text-xs font-black flex items-center justify-center shadow-md border border-brand-navy/20 uppercase">
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

    {{-- Contract duration + Assigned supervisor (two cards in a row) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
             data-aos="fade-up" data-aos-delay="350" data-aos-offset="0">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-navy rounded-l-2xl"></div>
            <div class="p-6 md:p-8">
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Contract duration</h3>
                <div class="flex justify-between items-end gap-4">
                    <div>
                        <p class="text-[9px] text-gray-500 uppercase tracking-widest font-bold">Start</p>
                        <p class="text-brand-navy font-black text-lg">{{ \Carbon\Carbon::parse($trainee->start_date)->format('d M Y') }}</p>
                    </div>
                    <div class="text-brand-red font-black text-2xl">→</div>
                    <div class="text-right">
                        <p class="text-[9px] text-gray-500 uppercase tracking-widest font-bold">End</p>
                        <p class="text-brand-navy font-black text-lg">{{ \Carbon\Carbon::parse($trainee->end_date)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
             data-aos="fade-up" data-aos-delay="400" data-aos-offset="0">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-brand-red rounded-l-2xl"></div>
            <div class="p-6 md:p-8">
                <h3 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Assigned supervisor</h3>
                @if($trainee->supervisor)
                    <p class="text-brand-navy font-black text-lg">{{ $trainee->supervisor->name }}</p>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-1">Your point of contact</p>
                @else
                    <p class="text-gray-400 font-bold text-sm uppercase tracking-widest">Awaiting assignment</p>
                    <p class="text-[9px] text-gray-500 mt-1">HR will assign a supervisor soon</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Quick navigation --}}
    <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
         data-aos="fade-up" data-aos-delay="450" data-aos-offset="0">
        <div class="absolute top-0 right-0 w-48 h-48 bg-brand-navy/5 rounded-bl-[80px]"></div>
        <div class="relative p-6 md:p-8">
            <div class="mb-6">
                <h3 class="text-sm font-black text-brand-navy uppercase tracking-[0.15em]">Quick navigation</h3>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">Jump to any section</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('trainee.dashboard') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">1</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Overview</span>
                </a>
                <a href="{{ route('trainee.attendance.index') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">2</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Daily Attendance</span>
                </a>
                <a href="{{ route('trainee.monthly.index') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">3</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Monthly Report</span>
                </a>
                <a href="{{ route('trainee.profile') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">4</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">My Profile</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
