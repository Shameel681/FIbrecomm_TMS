@extends('layouts.hr')

@section('header_title', 'Trainee Management')

@section('hr_content')
<div class="space-y-8">

    {{-- VALIDATION ERROR ALERT --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-brand-red p-4 mb-6 shadow-sm animate-pulse">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-brand-red" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-xs font-black text-brand-red uppercase tracking-widest">Account Creation Failed</h3>
                    <ul class="mt-1 list-disc list-inside text-[10px] text-red-600 font-bold uppercase">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 shadow-sm">
            <p class="text-[10px] font-black text-green-700 uppercase tracking-widest">{{ session('success') }}</p>
        </div>
    @endif

    {{-- NOTIFICATION: INTERNSHIP PERIOD ENDED --}}
    @if(isset($recentlyEnded) && $recentlyEnded->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 shadow-sm">
            <h3 class="text-[10px] font-black text-yellow-800 uppercase tracking-widest mb-2">
                Internship duration ended for {{ $recentlyEnded->count() }} trainee(s)
            </h3>
            <ul class="text-[10px] text-yellow-900 font-bold uppercase tracking-widest space-y-1">
                @foreach($recentlyEnded as $ended)
                    <li>
                        {{ $ended->name }} 
                        <span class="text-yellow-700 font-normal normal-case">
                            (ended on {{ \Carbon\Carbon::parse($ended->end_date)->format('M d, Y') }})
                        </span>
                    </li>
                @endforeach
            </ul>
            <p class="mt-2 text-[9px] text-yellow-700 font-semibold uppercase tracking-widest">
                Their trainee status has been marked as completed and their accounts have been deactivated.
            </p>
        </div>
    @endif

    {{-- Active Status Header --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-down">
        <div class="col-span-2 bg-white p-8 border border-gray-100 rounded-2xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tighter">Active Interns</h2>
                <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-[10px]">Current Live Placements</p>
            </div>
            <div class="text-center bg-brand-navy/5 px-8 py-4 rounded-2xl border border-brand-navy/10">
                <span class="block text-4xl font-black text-brand-navy leading-none">{{ $activeCount }}</span>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Active Now</span>
            </div>
        </div>
        
        <div class="bg-brand-red p-8 rounded-2xl shadow-lg flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </div>
            <h3 class="text-white font-black text-xs uppercase tracking-[0.2em] relative z-10">Total Registered</h3>
            <p class="text-white text-4xl font-black mt-2 relative z-10">{{ $totalRegistered }}</p>
        </div>
    </div>

    {{-- SECTION 1: ONBOARDING QUEUE --}}
    @if(isset($onboardingQueue) && $onboardingQueue->count() > 0)
    <div class="bg-white rounded-2xl border-2 border-brand-red/20 shadow-sm flex flex-col overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-gray-50 bg-brand-red/[0.02] flex justify-between items-center">
            <div>
                <h3 class="text-[11px] font-black text-brand-red uppercase tracking-[0.2em]">Ready for Onboarding</h3>
                <p class="text-[9px] text-gray-400 font-bold uppercase mt-1">Applicants notified via email - Create accounts below</p>
            </div>
            <span class="px-3 py-1 bg-brand-red text-white text-[10px] font-black rounded-full">{{ $onboardingQueue->count() }} PENDING</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <tbody class="divide-y divide-gray-50">
                    @foreach($onboardingQueue as $queued)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-5">
                            <p class="text-sm font-black text-brand-navy uppercase">{{ $queued->full_name }}</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $queued->institution }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-brand-navy uppercase">Period: {{ \Carbon\Carbon::parse($queued->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($queued->expected_end_date)->format('M d, Y') }}</span>
                                <span class="text-[8px] text-green-600 font-bold uppercase tracking-widest flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                    Offer Email Sent
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            {{-- Note: We format the dates here for the JS function to avoid ISO format errors --}}
                            <button onclick="openOnboardModal({
                                id: '{{ $queued->id }}',
                                full_name: '{{ addslashes($queued->full_name) }}',
                                email: '{{ $queued->email }}',
                                start_date: '{{ \Carbon\Carbon::parse($queued->start_date)->format('Y-m-d') }}',
                                expected_end_date: '{{ \Carbon\Carbon::parse($queued->expected_end_date)->format('Y-m-d') }}'
                            })" 
                            class="px-6 py-3 bg-brand-navy text-white text-[10px] font-black uppercase tracking-widest rounded-sm hover:bg-brand-red transition-all shadow-md active:scale-95">
                                Setup Intern Account
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- SECTION 2: ACTIVE PERSONNEL DIRECTORY --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">Personnel Directory</h3>
            <div class="flex gap-4 items-center">
                <input type="text" id="traineeSearch" placeholder="Search trainee name..." class="px-4 py-2 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-brand-red focus:outline-none w-64">
            </div>
        </div>

        <div class="overflow-y-auto max-h-[600px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white z-10 shadow-sm">
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-4">Trainee</th>
                        <th class="px-8 py-4 text-center">Contact Information</th>
                        <th class="px-8 py-4 text-center">Internship Period</th>
                        <th class="px-8 py-4 text-center">Status</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="traineeTableBody">
                    @forelse($activeTrainees as $trainee)
                    <tr class="hover:bg-brand-red/[0.02] transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-brand-navy text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                    {{ strtoupper(substr($trainee->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-brand-navy uppercase trainee-name">{{ $trainee->name }}</p>
                                    <p class="text-[9px] font-bold text-gray-400">REG-ID: {{ str_pad($trainee->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <p class="text-[10px] font-black text-brand-navy uppercase tracking-tighter">{{ $trainee->email }}</p>
                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-0.5 rounded border border-gray-100">Verified Account</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="inline-flex flex-col">
                                <span class="text-[10px] font-black text-brand-navy uppercase">
                                    {{ \Carbon\Carbon::parse($trainee->start_date)->format('M d, Y') }}
                                </span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">to {{ \Carbon\Carbon::parse($trainee->end_date)->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $isActive = now()->between($trainee->start_date, $trainee->end_date);
                                $accountActive = $trainee->user && $trainee->user->is_active;
                            @endphp
                            <div class="flex flex-col items-center gap-3">
                                @if($isActive && $accountActive)
                                    <span class="bg-green-100 text-green-700 text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-green-200 shadow-sm">Active Now</span>
                                @elseif(!$accountActive)
                                    <span class="bg-red-100 text-red-700 text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-red-200 shadow-sm">Account Deactivated</span>
                                @else
                                    <span class="bg-gray-100 text-gray-400 text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Completed</span>
                                @endif
                                
                                {{-- Use relative URL to avoid CSRF/session issues if APP_URL scheme/host differs from current host --}}
                                <form action="{{ route('hr.trainees.toggle_status', $trainee->id, false) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <select 
                                        name="status" 
                                        class="text-[9px] font-black uppercase tracking-widest px-3 py-1.5 border border-gray-200 rounded-lg focus:ring-1 focus:ring-brand-navy focus:border-brand-navy outline-none bg-white"
                                    >
                                        <option value="1" {{ $accountActive ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$accountActive ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button 
                                        type="submit"
                                        class="px-3 py-1.5 bg-brand-navy text-white text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-brand-red transition-all shadow-sm"
                                    >
                                        Update Status
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                {{-- Eye button: move deactivated trainee to Inactive/Deactivated container --}}
                                @if($trainee->user && !$trainee->user->is_active)
                                    <form action="{{ route('hr.trainees.archive', $trainee->id, false) }}" method="POST" onsubmit="return confirm('Move this trainee to the Inactive/Deactivated list?');">
                                        @csrf
                                        <button type="submit" class="text-brand-navy hover:text-brand-red transition-colors p-2 bg-gray-50 rounded-lg border border-gray-100 hover:border-brand-red/20" title="Move to Inactive/Deactivated list">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <button class="text-brand-navy opacity-40 cursor-not-allowed p-2 bg-gray-50 rounded-lg border border-gray-100" title="Available only for deactivated accounts" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center">
                            <div class="flex flex-col items-center text-gray-300">
                                <svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <p class="text-[10px] font-black uppercase tracking-[0.5em]">No registered trainees found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SECTION 3: INACTIVE / DEACTIVATED TRAINEE CONTAINER --}}
    <div class="bg-gray-50 rounded-2xl border border-gray-200 shadow-inner flex flex-col overflow-hidden mt-8" data-aos="fade-up" data-aos-delay="250">
        <div class="p-6 border-b border-gray-200 bg-gray-100 flex justify-between items-center">
            <div>
                <h3 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">Inactive / Deactivated Trainees</h3>
                <p class="text-[9px] text-gray-500 font-bold uppercase mt-1">Accounts that have been deactivated for 3+ days or manually archived</p>
            </div>
            <span class="px-3 py-1 bg-gray-800 text-white text-[9px] font-black rounded-full uppercase tracking-widest">
                {{ $archivedTrainees->count() }} Inactive
            </span>
        </div>

        <div class="overflow-y-auto max-h-[400px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-gray-50 z-10 shadow-sm">
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-200">
                        <th class="px-8 py-4">Trainee</th>
                        <th class="px-8 py-4 text-center">Contact Information</th>
                        <th class="px-8 py-4 text-center">Internship Period</th>
                        <th class="px-8 py-4 text-center">Deactivated Since</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($archivedTrainees as $trainee)
                        <tr class="hover:bg-gray-100/70 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 bg-gray-400 text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                        {{ strtoupper(substr($trainee->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-brand-navy uppercase">{{ $trainee->name }}</p>
                                        <p class="text-[9px] font-bold text-gray-400">REG-ID: {{ str_pad($trainee->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <p class="text-[10px] font-black text-brand-navy uppercase tracking-tighter">{{ $trainee->email }}</p>
                                @if($trainee->user)
                                    <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-0.5 rounded border border-gray-100">
                                        User: {{ $trainee->user->email }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="inline-flex flex-col">
                                    <span class="text-[10px] font-black text-brand-navy uppercase">
                                        {{ \Carbon\Carbon::parse($trainee->start_date)->format('M d, Y') }}
                                    </span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase">
                                        to {{ \Carbon\Carbon::parse($trainee->end_date)->format('M d, Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="text-[10px] font-black text-gray-700 uppercase">
                                    {{ $trainee->deactivated_at ? \Carbon\Carbon::parse($trainee->deactivated_at)->format('M d, Y') : 'Unknown' }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                @php
                                    $canReactivate = $trainee->user && !$trainee->user->is_active;
                                @endphp
                                @if($canReactivate)
                                    <form action="{{ route('hr.trainees.toggle_status', $trainee->id, false) }}" method="POST" onsubmit="return confirm('Reactivate this trainee account and move it back to the active list?');" class="inline-flex">
                                        @csrf
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-[9px] font-black uppercase tracking-widest rounded-lg hover:bg-green-700 transition shadow-sm">
                                            Reactivate
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[9px] text-gray-400 font-semibold uppercase tracking-widest">Already Active</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center">
                                <div class="flex flex-col items-center text-gray-300">
                                    <svg class="w-10 h-10 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <p class="text-[10px] font-black uppercase tracking-[0.5em]">No inactive trainees yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MANUAL ONBOARDING MODAL --}}
<div id="onboardModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-brand-navy/80 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-black text-brand-navy uppercase tracking-widest">Setup Intern Account</h3>
                    <p class="text-[8px] font-bold text-gray-400 uppercase mt-0.5">Finalize Login Credentials</p>
                </div>
                <button onclick="closeOnboardModal()" class="text-gray-400 hover:text-brand-red transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
            </div>
            
            <form id="onboardForm" action="{{ route('hr.trainees.store_account') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <input type="hidden" name="applicant_id" id="modal_applicant_id">
                <input type="hidden" name="name" id="modal_name_hidden">
                <input type="hidden" name="email" id="modal_email_hidden">
                <input type="hidden" name="start_date" id="modal_start_hidden">
                <input type="hidden" name="end_date" id="modal_end_hidden">

                <div class="space-y-4">
                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block ml-1">Full Name</label>
                        <div id="display_name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-xs font-bold text-brand-navy"></div>
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block ml-1">Login Email</label>
                        <div id="display_email" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-xs font-bold text-brand-navy"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block ml-1">Start Date</label>
                            <div id="display_start" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[10px] font-bold text-brand-navy"></div>
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block ml-1">End Date</label>
                            <div id="display_end" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-[10px] font-bold text-brand-navy"></div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-blue-50 rounded-lg border border-dashed border-blue-200">
                    <p class="text-[8px] font-bold text-blue-600 uppercase leading-relaxed text-center">
                        System will generate a unique temporary password and email it to the trainee automatically.
                    </p>
                </div>

                <button type="submit" id="onboardSubmitBtn" class="w-full py-4 bg-brand-navy text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg hover:bg-brand-red transition-all shadow-lg active:scale-[0.98]">
                    Confirm & Send Credentials
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Search Functionality
    document.getElementById('traineeSearch').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelector("#traineeTableBody").rows;
        for (let i = 0; i < rows.length; i++) {
            let nameCol = rows[i].querySelector(".trainee-name");
            if (nameCol) {
                let textValue = nameCol.textContent || nameCol.innerText;
                rows[i].style.display = textValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    });

    // Modal Operations
    function openOnboardModal(data) {
        // Hydrate Hidden Inputs
        document.getElementById('modal_applicant_id').value = data.id;
        document.getElementById('modal_name_hidden').value = data.full_name;
        document.getElementById('modal_email_hidden').value = data.email;
        document.getElementById('modal_start_hidden').value = data.start_date;
        document.getElementById('modal_end_hidden').value = data.expected_end_date;

        // Hydrate Visual UI
        document.getElementById('display_name').innerText = data.full_name;
        document.getElementById('display_email').innerText = data.email;
        document.getElementById('display_start').innerText = data.start_date;
        document.getElementById('display_end').innerText = data.expected_end_date;
        
        // Show Modal
        const modal = document.getElementById('onboardModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeOnboardModal() {
        document.getElementById('onboardModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Prevents double submission which causes "Email already taken" errors
    document.getElementById('onboardForm').onsubmit = function() {
        const btn = document.getElementById('onboardSubmitBtn');
        btn.disabled = true;
        btn.innerText = 'PROCESSING...';
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    };

    // Close on backdrop click
    window.onclick = function(event) {
        const modal = document.getElementById('onboardModal');
        if (event && event.target && modal.querySelector('.absolute') && event.target == modal.querySelector('.absolute')) {
            closeOnboardModal();
        }
    }
</script>
@endpush
@endsection