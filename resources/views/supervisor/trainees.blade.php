@extends('layouts.supervisor')

@section('header_title', 'Manage Trainees')

@section('supervisor_content')
<div class="space-y-8" data-aos="fade-up" data-aos-duration="800">

    {{-- Header --}}
    <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-red/5 rounded-bl-full"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-brand-navy uppercase tracking-tighter">Assigned Trainees</h2>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mt-1">
                    Complete trainee information and statistics
                </p>
            </div>
            <div class="text-center bg-brand-navy/5 px-6 py-4 rounded-2xl border border-brand-navy/10">
                <span class="block text-3xl font-black text-brand-navy leading-none">{{ $trainees->count() }}</span>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Assigned</span>
            </div>
        </div>
    </div>

    @if($trainees->count() > 0)
        @foreach($trainees as $trainee)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            
            {{-- Trainee Header Card --}}
            <div class="bg-gradient-to-r from-brand-navy to-brand-navy/90 p-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-bl-full"></div>
                <div class="relative z-10 flex items-center gap-6">
                    <div class="h-20 w-20 bg-white/20 rounded-2xl flex items-center justify-center text-white text-3xl font-black shadow-xl backdrop-blur-sm">
                        {{ strtoupper(substr($trainee->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-2xl font-black uppercase tracking-tighter">{{ $trainee->name }}</h3>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="px-3 py-1 bg-white/20 text-white text-[10px] font-black uppercase rounded-full backdrop-blur-sm">
                                {{ ucfirst($trainee->status) }}
                            </span>
                            <span class="text-white/80 text-xs font-bold">
                                ID: #{{ $trainee->id }}
                            </span>
                            @if($trainee->days_remaining !== null)
                                <span class="px-3 py-1 bg-brand-red/30 text-white text-[10px] font-black uppercase rounded-full">
                                    {{ $trainee->days_remaining }} Days Remaining
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
                
                {{-- Left Column: Basic Information --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gray-50 p-6 border border-gray-100 rounded-xl">
                        <h4 class="text-sm font-black text-brand-navy mb-4 uppercase tracking-widest border-b border-gray-200 pb-2">
                            Account Details
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Email Address</label>
                                <p class="text-brand-navy font-bold text-sm">{{ $trainee->email }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Internship Period</label>
                                <p class="text-gray-700 text-sm font-medium">
                                    {{ \Carbon\Carbon::parse($trainee->start_date)->format('M d, Y') }} — 
                                    {{ \Carbon\Carbon::parse($trainee->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Status</label>
                                <span class="inline-block px-3 py-1 bg-{{ $trainee->status === 'active' ? 'green' : 'gray' }}-100 text-{{ $trainee->status === 'active' ? 'green' : 'gray' }}-700 text-[10px] font-black uppercase rounded-full">
                                    {{ ucfirst($trainee->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Attendance Statistics --}}
                    <div class="bg-gray-50 p-6 border border-gray-100 rounded-xl">
                        <h4 class="text-sm font-black text-brand-navy mb-4 uppercase tracking-widest border-b border-gray-200 pb-2">
                            Attendance Summary
                        </h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase">Total Records</span>
                                <span class="text-brand-navy font-black text-sm">{{ $trainee->total_attendances }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    Approved
                                </span>
                                <span class="text-green-700 font-black text-sm">{{ $trainee->approved_attendances }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                                <span class="text-amber-700 font-black text-sm">{{ $trainee->pending_attendances }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Rejected
                                </span>
                                <span class="text-red-700 font-black text-sm">{{ $trainee->rejected_attendances }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Application Details --}}
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 p-8 border border-gray-100 rounded-xl min-h-full">
                        <h4 class="text-xl font-black text-brand-navy mb-6 flex items-center gap-3 uppercase tracking-tighter">
                            <span class="p-2 bg-brand-red/10 rounded-lg">
                                <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            Trainee Background Information
                        </h4>

                        @if($trainee->applicationDetails)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Full Legal Name</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ $trainee->applicationDetails->full_name }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Contact Phone</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ $trainee->applicationDetails->phone }}
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Home Address</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ $trainee->applicationDetails->address }}
                                    </p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Institution / University</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ $trainee->applicationDetails->institution }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Major of Study</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ $trainee->applicationDetails->major }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Study Level</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ ucfirst($trainee->applicationDetails->study_level) }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Expected Graduation</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ \Carbon\Carbon::parse($trainee->applicationDetails->grad_date)->format('F Y') }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Internship Duration</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ $trainee->applicationDetails->duration }} {{ $trainee->applicationDetails->duration === 1 ? 'Month' : 'Months' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Area of Interest</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ $trainee->applicationDetails->interest }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Coursework Requirement</label>
                                    <p class="text-gray-800 font-semibold text-sm border-b border-gray-200 pb-2">
                                        {{ ucfirst($trainee->applicationDetails->coursework_req) }}
                                    </p>
                                </div>
                                @if($trainee->applicationDetails->cv_path)
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">CV Document</label>
                                    <a href="{{ asset('storage/' . $trainee->applicationDetails->cv_path) }}" target="_blank" 
                                       class="inline-flex items-center gap-2 text-brand-red hover:text-brand-navy text-sm font-bold transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View CV
                                    </a>
                                </div>
                                @endif
                                @if($trainee->applicationDetails->uni_letter_path)
                                <div>
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">University Letter</label>
                                    <a href="{{ asset('storage/' . $trainee->applicationDetails->uni_letter_path) }}" target="_blank" 
                                       class="inline-flex items-center gap-2 text-brand-red hover:text-brand-navy text-sm font-bold transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        View Letter
                                    </a>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="bg-gray-100 p-4 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500 italic text-sm">
                                    No application data found for email: <strong>{{ $trainee->email }}</strong>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 text-center">
            <div class="bg-gray-100 p-6 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-black text-brand-navy uppercase tracking-tighter mb-2">No Trainees Assigned</h3>
            <p class="text-gray-500 text-sm">You currently have no trainees assigned to you. Contact HR for trainee assignments.</p>
        </div>
    @endif
</div>
@endsection
