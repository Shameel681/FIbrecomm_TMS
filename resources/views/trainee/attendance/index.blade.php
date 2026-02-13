@extends('layouts.trainee')

@section('header_title', 'Daily Attendance')

@section('content')
<div class="container mx-auto px-6 py-8" data-aos="fade-up">
    <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tight">Attendance</h2>
    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-[0.2em] mt-1">Submit your daily presence. On company WiFi = auto-approved; outside = supervisor approval required.</p>

    {{-- Rejection notification (trainee gets notified when SV rejects outside clock-in) --}}
    @if($rejectedAttendances->count() > 0)
        <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-5 rounded-xl shadow-sm flex items-start gap-4" data-aos="fade-down">
            <div class="shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-black text-red-800 uppercase tracking-wider">Attendance request rejected</h3>
                <p class="text-xs text-red-700 font-semibold mt-1">
                    Your supervisor has rejected {{ $rejectedAttendances->count() }} attendance request(s). See details below.
                </p>
                <a href="#rejection-inbox" class="inline-block mt-3 text-xs font-black uppercase tracking-widest text-red-600 hover:text-red-800 underline">
                    View rejection inbox &rarr;
                </a>
            </div>
        </div>
    @endif

    {{-- Success / Error --}}
    @if(session('success'))
        <div class="mt-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex justify-between items-center" data-aos="fade-down">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="mt-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm flex justify-between items-center" data-aos="fade-down">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</p>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- How it works --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4" data-aos="fade-up">
        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
            <div class="flex items-center gap-3 mb-2">
                <span class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                <h4 class="text-sm font-black text-green-800 uppercase tracking-wider">On company WiFi</h4>
            </div>
            <p class="text-xs text-green-700 font-semibold">When you clock in while connected to company network, your attendance is <strong>auto-approved</strong> — no supervisor action needed.</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
            <div class="flex items-center gap-3 mb-2">
                <span class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </span>
                <h4 class="text-sm font-black text-amber-800 uppercase tracking-wider">Outside clock-in</h4>
            </div>
            <p class="text-xs text-amber-700 font-semibold">When you clock in from outside (e.g. home), your request is sent to your <strong>supervisor for approval</strong>. You will be notified if it is rejected.</p>
        </div>
    </div>

    {{-- Daily clock-in --}}
    <div class="mt-10 bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden" data-aos="fade-up">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-black text-brand-navy uppercase tracking-tight">Today’s presence</h3>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-0.5">{{ now()->format('l, d F Y') }}</p>
            </div>
            @if($todayRecord && $todayRecord->status !== 'rejected')
                <div class="flex items-center gap-3">
                    @if($todayRecord->is_auto_approved)
                        <span class="px-4 py-2 rounded-full text-xs font-black uppercase bg-green-100 text-green-700 border border-green-200">Auto-approved</span>
                    @elseif($todayRecord->status === 'approved')
                        <span class="px-4 py-2 rounded-full text-xs font-black uppercase bg-green-100 text-green-700 border border-green-200">Approved</span>
                    @else
                        <span class="px-4 py-2 rounded-full text-xs font-black uppercase bg-amber-100 text-amber-700 border border-amber-200">Pending approval</span>
                    @endif
                    <span class="text-xs font-bold text-gray-500">Clock-in: {{ \Carbon\Carbon::parse($todayRecord->clock_in)->format('h:i A') }}</span>
                </div>
            @endif
        </div>

        @if(!$todayRecord || $todayRecord->status === 'rejected')
            @if($todayRecord && $todayRecord->status === 'rejected')
                <div class="px-6 pt-4 pb-2 bg-red-50 border-b border-red-100">
                    <p class="text-xs font-black text-red-700 uppercase tracking-wider">Your attendance request for today was rejected. You may resubmit with new remarks below.</p>
                    @if($todayRecord->remarks)
                        <p class="text-[10px] text-red-600 mt-1 font-semibold">Supervisor’s reason: {{ $todayRecord->remarks }}</p>
                    @endif
                </div>
            @endif
            <form action="{{ route('trainee.attendance.clockIn') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-5">
                    <label class="block text-xs font-black text-gray-600 uppercase tracking-widest mb-2">
                        Daily remarks <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="trainee_remark"
                        rows="3"
                        required
                        minlength="5"
                        maxlength="500"
                        placeholder="Describe your activities or tasks for today. This will appear on your monthly summary."
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-navy focus:border-brand-navy outline-none resize-none text-sm"
                    >{{ old('trainee_remark', $todayRecord->trainee_remark ?? '') }}</textarea>
                    <p class="text-[10px] text-gray-500 mt-1">Min 5 characters. Shown in monthly attendance reports.</p>
                    @error('trainee_remark')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full md:w-auto bg-brand-red hover:bg-red-700 text-white font-black py-3 px-8 rounded-xl text-xs uppercase tracking-[0.2em] transition shadow-lg">
                    {{ ($todayRecord && $todayRecord->status === 'rejected') ? 'Resubmit attendance' : 'Confirm attendance' }}
                </button>
            </form>
        @endif
    </div>

    {{-- Rejection Inbox --}}
    @if($rejectedAttendances->count() > 0)
        <div id="rejection-inbox" class="mt-10 bg-white rounded-2xl shadow-md border-l-4 border-red-500 overflow-hidden" data-aos="fade-up">
            <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h4 class="text-base font-black text-red-700 uppercase tracking-tight">Rejection inbox</h4>
                    </div>
                    <span class="px-3 py-1 bg-red-600 text-white text-xs font-black rounded-full">
                        {{ $rejectedAttendances->count() }} {{ $rejectedAttendances->count() === 1 ? 'rejection' : 'rejections' }}
                    </span>
                </div>
                <p class="text-xs text-red-600 font-semibold mt-2">
                    Your supervisor has rejected the following outside clock-in requests. Review the reasons below.
                </p>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($rejectedAttendances as $rejected)
                    <div class="px-6 py-4 hover:bg-red-50/50 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-black rounded-full uppercase">Rejected</span>
                                    <span class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($rejected->date)->format('l, d M Y') }}</span>
                                    <span class="text-xs text-gray-500">Clock-in: {{ \Carbon\Carbon::parse($rejected->clock_in)->format('h:i A') }}</span>
                                </div>
                                <div class="bg-gray-50 border-l-3 border-red-500 p-3 rounded-r-lg mt-2">
                                    <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">Supervisor’s remarks</p>
                                    <p class="text-sm text-gray-800 font-medium">{{ $rejected->remarks }}</p>
                                </div>
                                @if($rejected->approver)
                                    <p class="text-xs text-gray-500 mt-2 italic">Rejected by: <span class="font-semibold">{{ $rejected->approver->name }}</span></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- History --}}
    <div class="mt-12" data-aos="fade-up">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
            <h4 class="text-xl font-black text-brand-navy uppercase tracking-tight">Attendance history</h4>
            <form action="{{ route('trainee.attendance.index') }}" method="GET" class="flex gap-2">
                <select name="month" class="rounded-lg border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endforeach
                </select>
                <select name="year" class="rounded-lg border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                    @for($y = date('Y'); $y >= date('Y')-1; $y--)
                        <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit" class="bg-brand-navy text-white px-4 py-2 rounded-lg text-xs font-black uppercase hover:bg-opacity-90 transition">Filter</button>
            </form>
        </div>
        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase font-black tracking-widest">
                            <th class="px-5 py-3 border-b">Date</th>
                            <th class="px-5 py-3 border-b">Check-in</th>
                            <th class="px-5 py-3 border-b">Status</th>
                            <th class="px-5 py-3 border-b">Remarks</th>
                            <th class="px-5 py-3 border-b">Verified by</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($history as $record)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                                <td class="px-5 py-4 font-medium">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                                <td class="px-5 py-4">{{ \Carbon\Carbon::parse($record->clock_in)->format('h:i A') }}</td>
                                <td class="px-5 py-4">
                                    @if($record->is_auto_approved)
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-700">Auto-approved</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                                            {{ $record->status === 'approved' ? 'bg-green-100 text-green-700' : ($record->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                            {{ $record->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-gray-600 max-w-xs truncate" title="{{ $record->trainee_remark ?? '-' }}">{{ $record->trainee_remark ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    @if($record->is_auto_approved)
                                        <span class="text-gray-500 font-semibold">Company network</span>
                                    @elseif($record->approver)
                                        {{ $record->approver->name }}
                                    @else
                                        <span class="text-amber-600 font-semibold">Awaiting approval</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-400 font-semibold">No attendance records for this period.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
                {{ $history->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
