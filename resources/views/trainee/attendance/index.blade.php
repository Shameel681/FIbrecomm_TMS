@extends('layouts.trainee')

@section('content')
<div class="container mx-auto px-6 py-8" data-aos="fade-up">
    <h3 class="text-gray-700 text-3xl font-medium text-brand-navy">Attendance Management</h3>

    {{-- Top Section: Daily Action --}}
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md border-t-4 border-brand-navy">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-semibold text-gray-800">Daily Presence</h4>
                <p class="text-gray-500">{{ now()->format('D, d M Y') }}</p>
            </div>
            
            @if(!$todayRecord)
                <form action="{{ route('trainee.attendance.clockIn') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-brand-red hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 shadow-lg transform hover:scale-105">
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
                        <td class="px-5 py-5 border-b text-sm">
                            {{ $record->approver ? $record->approver->name : 'Awaiting Approval' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-gray-400 italic">No attendance records found for this period.</td>
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