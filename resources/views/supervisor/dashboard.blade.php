@extends('layouts.supervisor')

@section('header_title', 'Dashboard')

@section('supervisor_content')
<div class="space-y-10">

    {{-- Hero welcome card with accent --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm"
         data-aos="fade-down" data-aos-duration="600">
        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gradient-to-b from-brand-red to-brand-navy rounded-l-2xl"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-brand-navy/5 to-transparent rounded-bl-[100px]"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-8 py-8 md:py-10">
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.25em] mb-1">Welcome back</p>
                <h2 class="text-2xl md:text-3xl font-black text-brand-navy uppercase tracking-tighter">Command Overview</h2>
                <p class="text-brand-red font-bold mt-2 uppercase tracking-widest text-[10px]">
                    {{ Auth::user()->name }} · {{ Auth::user()->department ?? 'Operations' }}
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

    {{-- Stat / action cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
        $cards = [
            [
                'title'   => 'Manage Trainees',
                'count'   => $totalTrainees ?? 0,
                'desc'    => 'View and manage your assigned interns and their progress.',
                'icon'    => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                'route'   => route('supervisor.trainees'),
                'delay'   => '100',
                'accent'  => 'brand-red',
            ],
            [
                'title'   => 'Attendance Approvals',
                'count'   => $pendingAttendance ?? 0,
                'desc'    => 'Review and approve daily clock-in records for your team.',
                'icon'    => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                'route'   => route('supervisor.attendance.approvals'),
                'delay'   => '200',
                'accent'  => 'brand-navy',
            ],
            [
                'title'   => 'My Profile',
                'count'   => 'Edit',
                'desc'    => 'Update your credentials and account security settings.',
                'icon'    => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                'route'   => route('supervisor.profile.edit'),
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

    {{-- Quick navigation --}}
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
                <a href="{{ route('supervisor.dashboard') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">1</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Dashboard</span>
                </a>
                <a href="{{ route('supervisor.attendance.approvals') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">2</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Attendance Approvals</span>
                </a>
                <a href="{{ route('supervisor.trainees') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">3</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Manage Trainees</span>
                </a>
                <a href="{{ route('supervisor.profile.edit') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-gray-50 border-2 border-transparent hover:border-brand-red/30 hover:bg-brand-red/5 hover:shadow-md transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">4</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Manage Profile</span>
                </a>
            </div>
            <div class="mt-3">
                <a href="{{ route('supervisor.tasks') }}"
                   class="flex items-center gap-4 px-5 py-4 rounded-xl bg-brand-navy/5 border-2 border-brand-navy/10 hover:border-brand-red/30 hover:bg-brand-red/5 transition-all duration-300 group">
                    <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-navy text-white text-sm font-black flex items-center justify-center group-hover:bg-brand-red transition-colors">5</span>
                    <span class="font-bold text-[10px] uppercase tracking-widest text-brand-navy group-hover:text-brand-red transition-colors">Assign Task</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
