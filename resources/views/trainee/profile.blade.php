@extends('layouts.trainee')

@section('header_title', 'My Profile')

@section('content')
<div class="space-y-8" data-aos="fade-up" data-aos-duration="800">
    
    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- Header Profile Card --}}
    <div class="bg-gradient-to-r from-brand-navy to-brand-navy/90 p-8 text-white relative overflow-hidden rounded-2xl shadow-sm">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-bl-full"></div>
        <div class="relative z-10 flex items-center gap-6">
            <div class="h-20 w-20 bg-white/20 rounded-2xl flex items-center justify-center text-white text-3xl font-black shadow-xl backdrop-blur-sm">
                {{ strtoupper(substr($trainee?->name ?? Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-grow">
                <h2 class="text-2xl font-black uppercase tracking-tighter">{{ $trainee?->name ?? Auth::user()->name }}</h2>
                <div class="flex items-center gap-4 mt-2">
                    <span class="px-3 py-1 bg-white/20 text-white text-[10px] font-black uppercase rounded-full backdrop-blur-sm">
                        {{ ucfirst($trainee?->status ?? 'Active') }}
                    </span>
                    <span class="text-white/80 text-xs font-bold">
                        ID: #{{ $trainee?->id ?? 'N/A' }}
                    </span>
                    @if(isset($daysLeft) && $daysLeft > 0)
                        <span class="px-3 py-1 bg-brand-red/30 text-white text-[10px] font-black uppercase rounded-full">
                            {{ $daysLeft }} Days Remaining
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Account Details & Attendance Stats --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Account Details --}}
            <div class="bg-gray-50 p-6 border border-gray-100 rounded-xl">
                <h4 class="text-sm font-black text-brand-navy mb-4 uppercase tracking-widest border-b border-gray-200 pb-2">
                    Account Details
                </h4>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Email Address</label>
                        <p class="text-brand-navy font-bold text-sm">{{ $trainee?->email ?? Auth::user()->email }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Internship Period</label>
                        <p class="text-gray-700 text-sm font-medium">
                            @if($trainee?->start_date && $trainee?->end_date)
                                {{ \Carbon\Carbon::parse($trainee->start_date)->format('M d, Y') }} — 
                                {{ \Carbon\Carbon::parse($trainee->end_date)->format('M d, Y') }}
                            @else
                                ---
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Status</label>
                        <span class="inline-block px-3 py-1 bg-{{ ($trainee?->status ?? 'active') === 'active' ? 'green' : 'gray' }}-100 text-{{ ($trainee?->status ?? 'active') === 'active' ? 'green' : 'gray' }}-700 text-[10px] font-black uppercase rounded-full">
                            {{ ucfirst($trainee?->status ?? 'Active') }}
                        </span>
                    </div>
                    @if($trainee?->supervisor)
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Supervisor</label>
                        <p class="text-brand-navy font-bold text-sm">{{ $trainee->supervisor->name }}</p>
                    </div>
                    @endif
                    @if($trainee?->daily_rate)
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-tighter block mb-1">Daily Rate</label>
                        <p class="text-brand-navy font-bold text-sm">RM {{ number_format($trainee->daily_rate, 2) }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Attendance Statistics --}}
            @if($trainee)
            <div class="bg-gray-50 p-6 border border-gray-100 rounded-xl">
                <h4 class="text-sm font-black text-brand-navy mb-4 uppercase tracking-widest border-b border-gray-200 pb-2">
                    Attendance Summary
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase">Total Records</span>
                        <span class="text-brand-navy font-black text-sm">{{ $trainee->total_attendances ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            Approved
                        </span>
                        <span class="text-green-700 font-black text-sm">{{ $trainee->approved_attendances ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            Pending
                        </span>
                        <span class="text-amber-700 font-black text-sm">{{ $trainee->pending_attendances ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            Rejected
                        </span>
                        <span class="text-red-700 font-black text-sm">{{ $trainee->rejected_attendances ?? 0 }}</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- Change Password Section --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-sm font-black text-brand-navy uppercase tracking-widest">Change Password</h3>
                </div>
                <form action="{{ route('trainee.profile.password') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Current Password</label>
                        <input
                            type="password"
                            name="current_password"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                        >
                        @error('current_password')
                            <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">New Password</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                        >
                        @error('password')
                            <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Confirm New Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-brand-navy hover:bg-brand-red text-white font-black text-[11px] uppercase tracking-[0.2em] py-3 rounded-xl shadow-sm transition-all"
                    >
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Right Column: Personal Information & Background Info (Combined) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-xl font-black text-brand-navy uppercase tracking-tighter flex items-center gap-3">
                        <span class="p-2 bg-brand-red/10 rounded-lg">
                            <svg class="w-5 h-5 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                        Personal Information
                    </h3>
                </div>

                @if($trainee?->applicationDetails)
                    <form action="{{ route('trainee.profile.personalInfo') }}" method="POST" class="p-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            {{-- Full Name (Read-only) --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Full Legal Name</label>
                                <input
                                    type="text"
                                    value="{{ $trainee->applicationDetails->full_name }}"
                                    disabled
                                    class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl outline-none font-bold text-sm text-gray-600 cursor-not-allowed"
                                >
                                <p class="text-[9px] text-gray-400 italic mt-1">Full name cannot be changed</p>
                            </div>

                            {{-- Contact Phone --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Contact Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $trainee->applicationDetails->phone) }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('phone')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Home Address --}}
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Home Address</label>
                                <textarea
                                    name="address"
                                    rows="3"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all resize-none"
                                >{{ old('address', $trainee->applicationDetails->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Institution / University --}}
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Institution / University</label>
                                <input
                                    type="text"
                                    name="institution"
                                    value="{{ old('institution', $trainee->applicationDetails->institution) }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('institution')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Major of Study --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Major of Study</label>
                                <input
                                    type="text"
                                    name="major"
                                    value="{{ old('major', $trainee->applicationDetails->major) }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('major')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Study Level --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Study Level</label>
                                <select
                                    name="study_level"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                    <option value="diploma" {{ old('study_level', $trainee->applicationDetails->study_level) === 'diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="degree" {{ old('study_level', $trainee->applicationDetails->study_level) === 'degree' ? 'selected' : '' }}>Degree</option>
                                    <option value="master" {{ old('study_level', $trainee->applicationDetails->study_level) === 'master' ? 'selected' : '' }}>Master</option>
                                    <option value="phd" {{ old('study_level', $trainee->applicationDetails->study_level) === 'phd' ? 'selected' : '' }}>PhD</option>
                                    <option value="others" {{ old('study_level', $trainee->applicationDetails->study_level) === 'others' ? 'selected' : '' }}>Others</option>
                                </select>
                                @error('study_level')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Expected Graduation --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Expected Graduation</label>
                                <input
                                    type="date"
                                    name="grad_date"
                                    value="{{ old('grad_date', $trainee->applicationDetails->grad_date ? \Carbon\Carbon::parse($trainee->applicationDetails->grad_date)->format('Y-m-d') : '') }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('grad_date')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Internship Duration --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Internship Duration (Months)</label>
                                <input
                                    type="number"
                                    name="duration"
                                    value="{{ old('duration', $trainee->applicationDetails->duration) }}"
                                    required
                                    min="1"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('duration')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Area of Interest --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Area of Interest</label>
                                <input
                                    type="text"
                                    name="interest"
                                    value="{{ old('interest', $trainee->applicationDetails->interest) }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('interest')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Coursework Requirement --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Coursework Requirement</label>
                                <select
                                    name="coursework_req"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                    <option value="yes" {{ old('coursework_req', $trainee->applicationDetails->coursework_req) === 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ old('coursework_req', $trainee->applicationDetails->coursework_req) === 'no' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('coursework_req')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Bank Name --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Bank Name</label>
                                <input
                                    type="text"
                                    name="bank_name"
                                    value="{{ old('bank_name', $trainee->bank_name ?? '') }}"
                                    placeholder="e.g., CIMB MALAYSIA"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('bank_name')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Account Number --}}
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Account Number</label>
                                <input
                                    type="text"
                                    name="account_number"
                                    value="{{ old('account_number', $trainee->account_number ?? '') }}"
                                    placeholder="e.g., 123412341234"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                                >
                                @error('account_number')
                                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- CV Document (Read-only link) --}}
                            @if($trainee->applicationDetails->cv_path)
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">CV Document</label>
                                <a href="{{ asset('storage/' . $trainee->applicationDetails->cv_path) }}" target="_blank" 
                                   class="inline-flex items-center gap-2 text-brand-red hover:text-brand-navy text-sm font-bold transition px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    View CV
                                </a>
                            </div>
                            @endif

                            {{-- University Letter (Read-only link) --}}
                            @if($trainee->applicationDetails->uni_letter_path)
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">University Letter</label>
                                <a href="{{ asset('storage/' . $trainee->applicationDetails->uni_letter_path) }}" target="_blank" 
                                   class="inline-flex items-center gap-2 text-brand-red hover:text-brand-navy text-sm font-bold transition px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    View Letter
                                </a>
                            </div>
                            @endif
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <button
                                type="submit"
                                class="w-full bg-brand-navy hover:bg-brand-red text-white font-black text-[11px] uppercase tracking-[0.2em] py-3 rounded-xl shadow-sm transition-all"
                            >
                                Update Personal Information
                            </button>
                        </div>
                    </form>
                @else
                    <div class="p-8">
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="bg-gray-100 p-4 rounded-full mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 italic text-sm">
                                No application data found for email: <strong>{{ $trainee?->email ?? Auth::user()->email }}</strong>
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
