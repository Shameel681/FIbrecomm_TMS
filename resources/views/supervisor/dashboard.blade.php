@extends('layouts.supervisor')

@section('header_title', 'Dashboard')

@section('supervisor_content')
<div class="space-y-10">
    
    {{-- Header Profile Card --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-8 border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden" 
         data-aos="fade-down" data-aos-duration="800">
        {{-- Changed bg-blue-500/5 to brand-red equivalent --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-red/5 rounded-bl-full"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-brand-navy uppercase tracking-tighter">Command Overview</h2>
            <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-xs">
                Supervisor | {{ Auth::user()->name }} | {{ Auth::user()->department ?? 'Operations' }}
            </p>
        </div>
        
        <div class="mt-4 md:mt-0 text-right relative z-10">
            <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Shift Date</p>
            <p class="text-brand-navy font-black text-xl">
                {{ now()->format('D, d M Y') }}
            </p>
        </div>
    </div>

    {{-- Operational Navigation Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        @php
        $dashboardCards = [
            [
                'title' => 'View Trainees',
                'count' => $totalTrainees ?? 0, 
                'desc'  => 'Monitor progress and manage performance reviews for your assigned interns.',
                'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                'route' => route('supervisor.trainees'),
                'delay' => '100',
                'color' => 'brand-red'
            ],
            [
                'title' => 'Approve Attendance',
                'count' => $pendingAttendance ?? 0,
                'desc' => 'Review and verify daily logs and clock-in/out records for your team.',
                'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                'route' => route('supervisor.logbooks'), 
                'delay' => '200',
                'color' => 'brand-red'
            ],
            [
                'title' => 'My Profile',
                'count' => 'Edit',
                'desc' => 'Update your professional credentials and account security settings.',
                'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                'route' => route('supervisor.profile.edit'), 
                'delay' => '300',
                'color' => 'brand-red'
            ],
        ];
        @endphp

        @foreach($dashboardCards as $card)
        <a href="{{ $card['route'] }}" 
           data-aos="zoom-in-up" 
           data-aos-delay="{{ $card['delay'] }}"
           data-aos-offset="0"
           {{-- Hover border changed to brand-red --}}
           class="group relative bg-white p-8 border border-gray-100 rounded-2xl shadow-sm transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:border-brand-red/20 text-center">
            
            {{-- Gradient overlay changed to red-50/30 --}}
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-red-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>

            <div class="relative z-10 flex flex-col items-center">
                {{-- Icon background and hover changed to red --}}
                <div class="mb-6 p-5 rounded-full bg-gray-50 text-brand-red group-hover:bg-brand-red group-hover:text-white transition-all duration-700 transform group-hover:rotate-[360deg] shadow-inner relative">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}"/>
                    </svg>
                    {{-- Indicator badge hover logic --}}
                    <div class="absolute -top-1 -right-1 bg-brand-navy text-white text-[10px] font-black min-w-[28px] h-7 px-1 rounded-full flex items-center justify-center border-2 border-white group-hover:bg-white group-hover:text-brand-red transition-colors uppercase">
                        {{ $card['count'] }}
                    </div>
                </div>
                
                {{-- Title hover text changed to red --}}
                <h3 class="text-2xl font-black text-brand-navy mb-3 uppercase tracking-tighter group-hover:text-brand-red transition-colors duration-300">
                    {{ $card['title'] }}
                </h3>
                
                <p class="text-sm text-gray-500 leading-relaxed px-2 font-medium">
                    {{ $card['desc'] }}
                </p>

                {{-- Bottom bar changed to red --}}
                <div class="mt-8 w-12 h-1.5 bg-gray-100 group-hover:w-full group-hover:bg-brand-red transition-all duration-500 rounded-full"></div>
            </div>
        </a>
        @endforeach

    </div>

    {{-- Lower Section: Support & Quick Actions --}}
    <div class="bg-brand-navy rounded-2xl p-10 text-white relative overflow-hidden shadow-xl" 
         data-aos="fade-up" data-aos-delay="400" data-aos-offset="0">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-20 -mt-20"></div>
        <div class="relative z-10">
            {{-- Shortcut title changed to brand-red --}}
            <h4 class="text-xl font-black uppercase tracking-widest text-brand-red mb-6">Operational Shortcuts</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Shortcut buttons hover bg changed to red --}}
                <a href="{{ route('supervisor.tasks') }}" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Assign Task
                </a>
                <a href="#" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Weekly Report
                </a>
                <a href="{{ route('supervisor.logbooks') }}" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Attendance
                </a>
                <a href="#" class="px-6 py-4 bg-white/10 hover:bg-brand-red rounded-xl transition-all font-bold text-center text-xs uppercase tracking-widest border border-white/10 hover:border-transparent">
                    Support Desk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection