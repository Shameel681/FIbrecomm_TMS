@extends('layouts.trainee')

@section('content')
<div class="space-y-8" data-aos="fade-up">
    
    <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm flex items-center gap-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-red/5 rounded-bl-full"></div>
        <div class="h-24 w-24 bg-brand-navy rounded-2xl flex items-center justify-center text-white text-4xl font-black shadow-xl transform -rotate-3 group-hover:rotate-0 transition-transform">
            {{ substr($trainee->name, 0, 1) }}
        </div>
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-brand-navy">{{ $trainee->name }}</h2>
            <div class="flex items-center gap-3 mt-1">
                <span class="text-brand-red font-bold uppercase tracking-widest text-xs">Official Trainee</span>
                <span class="h-1 w-1 bg-gray-300 rounded-full"></span>
                <span class="text-gray-500 text-xs font-bold uppercase tracking-widest">ID: #{{ $trainee->id }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 border border-gray-200 rounded-2xl shadow-sm">
                <h3 class="text-sm font-black text-brand-navy mb-4 uppercase tracking-widest border-b pb-2">Account Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Login Email</label>
                        <p class="text-brand-navy font-bold">{{ $trainee->email }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Internship Duration</label>
                        <p class="text-gray-700 text-sm font-medium">{{ $trainee->start_date }} — {{ $trainee->end_date }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm min-h-full">
                <h3 class="text-xl font-bold text-brand-navy mb-8 flex items-center gap-3">
                    <span class="p-2 bg-brand-red/10 rounded-lg">
                        <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </span>
                    Trainee Background Info
                </h3>

                @if($trainee->applicationDetails)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Full Legal Name</label>
                            <p class="text-gray-800 font-semibold border-b border-gray-100 pb-2">{{ $trainee->applicationDetails->full_name }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Contact Phone</label>
                            <p class="text-gray-800 font-semibold border-b border-gray-100 pb-2">{{ $trainee->applicationDetails->phone }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Institution / University</label>
                            <p class="text-gray-800 font-semibold border-b border-gray-100 pb-2">{{ $trainee->applicationDetails->institution }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Major of Study</label>
                            <p class="text-gray-800 font-semibold border-b border-gray-100 pb-2">{{ $trainee->applicationDetails->major }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Study Level</label>
                            <p class="text-gray-800 font-semibold border-b border-gray-100 pb-2">{{ $trainee->applicationDetails->study_level }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Home Address</label>
                            <p class="text-gray-800 font-semibold border-b border-gray-100 pb-2">{{ $trainee->applicationDetails->address }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="bg-gray-100 p-4 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <p class="text-gray-500 italic">No application data found for email: <strong>{{ $trainee->email }}</strong></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection