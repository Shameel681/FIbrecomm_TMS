@extends('layouts.trainee')

@section('header_title', 'Dashboard')

@section('content')
<div class="container mx-auto px-6 py-8" data-aos="fade-up">
    <div class="space-y-8">
        
        {{-- Header Profile Card --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-8 border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-navy/5 rounded-bl-full"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-bold text-brand-navy uppercase tracking-tighter">Command Overview</h2>
                <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-[10px]">
                    Practical Trainee | {{ $trainee->name }} | ID: #{{ $trainee->id }}
                </p>
            </div>
            
            <div class="mt-4 md:mt-0 text-right relative z-10">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold">Remaining Days</p>
                <p class="text-brand-navy font-black text-3xl">
                    {{ $daysLeft }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Column --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Quick Actions --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('trainee.attendance.index') }}" 
                       class="group bg-white p-6 border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center space-x-4">
                            <div class="p-4 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-brand-navy uppercase text-sm">Attendance</h3>
                                <p class="text-xs text-gray-500">Record daily clock-in</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('trainee.profile') }}" 
                       class="group bg-white p-6 border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center space-x-4">
                            <div class="p-4 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-brand-navy uppercase text-sm">My Profile</h3>
                                <p class="text-xs text-gray-500">View personal details</p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Internship Dates Card --}}
                <div class="bg-brand-navy rounded-2xl p-8 text-white">
                    <h4 class="text-blue-400 font-black uppercase tracking-widest text-xs mb-4">Contract Duration</h4>
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-xs opacity-60">START</p>
                            <p class="font-bold">{{ \Carbon\Carbon::parse($trainee->start_date)->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs opacity-60">END</p>
                            <p class="font-bold">{{ \Carbon\Carbon::parse($trainee->end_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="bg-white p-6 border border-gray-200 rounded-2xl shadow-sm">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Assigned Supervisor</h3>
                    @if($trainee->supervisor)
                        <p class="text-sm font-bold text-brand-navy">{{ $trainee->supervisor->name }}</p>
                    @else
                        <p class="text-xs text-gray-400 italic uppercase">Awaiting Assignment</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection