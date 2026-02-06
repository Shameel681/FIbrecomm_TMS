@extends('layouts.trainee')

@section('header_title', 'Daily Attendance')

@section('content')
<div class="container mx-auto px-6 py-8" data-aos="fade-up">
    <h3 class="text-gray-700 text-3xl font-medium text-brand-navy">Attendance Management</h3>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- Top Section: Daily Action --}}
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md border-t-4 border-brand-navy">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-semibold text-gray-800">Daily Presence</h4>
                <p class="text-gray-500">{{ now()->format('D, d M Y') }}</p>
            </div>
            
            @if(!$todayRecord)
                <form action="{{ route('trainee.attendance.clockIn') }}" method="POST" class="w-full max-w-md">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Daily Remarks <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="trainee_remark"
                            rows="3"
                            required
                            minlength="5"
                            maxlength="500"
                            placeholder="Describe your activities or tasks for today..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-navy focus:border-brand-navy outline-none resize-none text-sm"
                        >{{ old('trainee_remark') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Minimum 5 characters required. This will be included in your monthly attendance summary.
                        </p>
                        @error('trainee_remark')
                            <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-brand-red hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 shadow-lg transform hover:scale-105">
                        CONFIRM ATTENDANCE
                    </button>
                </form>
            @else
                <div class="text-right">
                    <span class="px-4 py-2 rounded-full font-semibold 
                        {{ $todayRecord->status == 'approved' ? 'bg-green-100 text-green-700' : ($todayRecord->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ strtoupper($todayRecord->status) }}
                    </span>
                    <p class="mt-2 text-sm text-gray-600 italic">Marked present at: {{ \Carbon\Carbon::parse($todayRecord->clock_in)->format('h:i A') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Rejection Inbox --}}
    @if($rejectedAttendances->count() > 0)
    <div class="mt-8 bg-white rounded-lg shadow-md border-l-4 border-red-500 overflow-hidden" data-aos="fade-up">
        <div class="bg-red-50 px-6 py-4 border-b border-red-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h4 class="text-lg font-black text-red-700 uppercase tracking-tight">Rejection Inbox</h4>
                </div>
                <span class="px-3 py-1 bg-red-600 text-white text-xs font-black rounded-full">
                    {{ $rejectedAttendances->count() }} {{ $rejectedAttendances->count() === 1 ? 'Rejection' : 'Rejections' }}
                </span>
            </div>
            <p class="text-xs text-red-600 font-semibold mt-2">
                Your supervisor has rejected the following attendance requests. Please review the reasons below.
            </p>
        </div>
        
        <div class="divide-y divide-gray-100">
            @foreach($rejectedAttendances as $rejected)
                <div class="px-6 py-4 hover:bg-red-50/50 transition-colors">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-black rounded-full uppercase">
                                    Rejected
                                </span>
                                <span class="text-sm font-bold text-gray-700">
                                    {{ \Carbon\Carbon::parse($rejected->date)->format('l, d M Y') }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    Clock-in: {{ \Carbon\Carbon::parse($rejected->clock_in)->format('h:i A') }}
                                </span>
                            </div>
                            <div class="bg-gray-50 border-l-3 border-red-500 p-3 rounded-r-lg mt-2">
                                <p class="text-xs font-black text-gray-500 uppercase tracking-wider mb-1">
                                    Supervisor's Remarks:
                                </p>
                                <p class="text-sm text-gray-800 font-medium">
                                    {{ $rejected->remarks }}
                                </p>
                            </div>
                            @if($rejected->approver)
                            <p class="text-xs text-gray-500 mt-2 italic">
                                Rejected by: <span class="font-semibold">{{ $rejected->approver->name }}</span>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- STEP 7: History Filtering UI --}}
    <div class="mt-12 flex justify-between items-center mb-4">
        <h4 class="text-gray-600 text-xl font-semibold">Attendance History</h4>
        <form action="{{ route('trainee.attendance.index') }}" method="GET" class="flex gap-2">
            <select name="month" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-brand-navy focus:ring-brand-navy">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endforeach
            </select>
            <select name="year" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-brand-navy focus:ring-brand-navy">
                @for($y = date('Y'); $y >= date('Y')-1; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="bg-brand-navy text-white px-4 py-1 rounded text-sm hover:bg-opacity-90 transition">
                Filter History
            </button>
        </form>
    </div>

    {{-- Bottom Section: History Table --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-100">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-left text-xs uppercase font-semibold">
                    <th class="px-5 py-3 border-b">Date</th>
                    <th class="px-5 py-3 border-b">Check-In Time</th>
                    <th class="px-5 py-3 border-b">Status</th>
                    <th class="px-5 py-3 border-b">Remarks</th>
                    <th class="px-5 py-3 border-b">Verified By</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($history as $record)
                    <tr>
                        <td class="px-5 py-5 border-b text-sm font-medium">{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                        <td class="px-5 py-5 border-b text-sm">{{ \Carbon\Carbon::parse($record->clock_in)->format('h:i A') }}</td>
                        <td class="px-5 py-5 border-b text-sm">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                                {{ $record->status == 'approved' ? 'bg-green-100 text-green-700' : ($record->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b text-sm text-gray-600 max-w-xs">
                            <div class="truncate" title="{{ $record->trainee_remark ?? 'No remarks' }}">
                                {{ $record->trainee_remark ?? '-' }}
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b text-sm">
                            {{ $record->approver ? $record->approver->name : 'Awaiting Approval' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400 italic">No attendance records found for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-5 bg-white border-t">
            {{ $history->links() }}
        </div>
    </div>
</div>
@endsection