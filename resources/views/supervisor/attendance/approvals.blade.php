@extends('layouts.supervisor')

@section('header_title', 'Attendance Approvals')

@section('supervisor_content')
<div class="p-2">

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center" data-aos="fade-down">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center" data-aos="fade-down">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- Section Header --}}
    <div class="mb-10" data-aos="fade-right">
        <h2 class="text-4xl font-black text-brand-navy uppercase tracking-tight">Attendance Approvals</h2>
        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-[0.25em] mt-1">
            Review and approve clock-ins from your trainees.
        </p>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden" data-aos="fade-up">
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-brand-navy uppercase text-[10px] font-black tracking-widest border-b">
                <tr>
                    <th class="px-8 py-4">Trainee Name</th>
                    <th class="px-8 py-4">Date</th>
                    <th class="px-8 py-4">Clock In</th>
                    <th class="px-8 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingAttendances as $attendance)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-8 py-4 font-bold text-brand-navy uppercase text-xs">
                            {{ $attendance->trainee?->user?->name ?? $attendance->trainee?->name ?? 'Unknown Trainee' }}
                        </td>
                        <td class="px-8 py-4 text-xs font-bold text-gray-500">
                            {{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-8 py-4 text-xs font-black text-blue-600">
                            {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex justify-center gap-3">
                                {{-- Approve --}}
                                <form action="{{ route('supervisor.attendance.approve', $attendance->id) }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="bg-blue-600 text-white px-5 py-2 rounded-full font-black text-[10px] uppercase tracking-widest hover:bg-brand-navy transition shadow"
                                    >
                                        Approve
                                    </button>
                                </form>

                                {{-- Reject Button (opens modal) --}}
                                <button
                                    type="button"
                                    onclick="openRejectModal({{ $attendance->id }})"
                                    class="border-2 border-red-500 text-red-500 px-5 py-2 rounded-full font-black text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition shadow"
                                >
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-16 text-center">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">
                                No pending attendance requests
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Trainee Attendance Calendar --}}
    @if($assignedTrainees->count() > 0)
        <div class="mt-16 mb-8" data-aos="fade-right">
            <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tight">Assigned Trainee Attendance Overview</h2>
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-[0.25em] mt-1">
                Attendance history for your assigned trainees.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up">
            @foreach($assignedTrainees as $trainee)
                @if($trainee->startDate && $trainee->endDate)

                    @php
                        $startDate = $trainee->startDate->copy()->startOfDay();
                        $endDate = $trainee->endDate->copy()->endOfDay();
                        $currentDate = $startDate->copy();
                        $days = [];

                        while ($currentDate->lte($endDate)) {
                            $dateKey = $currentDate->toDateString();
                            $dayRecords = $trainee->calendarByDate->get($dateKey, collect());

                            $days[] = [
                                'date' => $currentDate->copy(),
                                'day' => $currentDate->day,
                                'dayOfWeek' => $currentDate->dayOfWeek,
                                'month' => $currentDate->month,
                                'year' => $currentDate->year,
                                'records' => $dayRecords,
                                'approved' => $dayRecords->where('status', 'approved')->count(),
                                'pending' => $dayRecords->where('status', 'pending')->count(),
                                'rejected' => $dayRecords->where('status', 'rejected')->count(),
                            ];
                            $currentDate->addDay();
                        }

                        $daysByMonth = collect($days)->groupBy(fn($day) => $day['date']->format('Y-m'));
                    @endphp

                    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                        {{-- Card Header --}}
                        <div class="bg-gray-100 px-4 py-3 border-b">
                            <h3 class="text-lg font-black text-brand-navy uppercase">
                                {{ $trainee->user->name ?? $trainee->name ?? 'Unknown Trainee' }}
                            </h3>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">
                                {{ $startDate->format('d M Y') }} — {{ $endDate->format('d M Y') }}
                            </p>
                        </div>

                        <div class="p-4">

                            {{-- Month Selector --}}
                            @php
                                $monthKeys = $daysByMonth->keys()->sort()->values();
                                $defaultMonthKey = $monthKeys->last();
                            @endphp

                            <div class="mb-4 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">
                                        Select Month
                                    </p>
                                    <select
                                        class="trainee-month-select border border-gray-300 rounded-lg px-3 py-2 text-[11px] font-semibold text-brand-navy bg-white focus:outline-none focus:ring-2 focus:ring-blue-300"
                                        data-trainee-id="{{ $trainee->id }}"
                                    >
                                        @foreach($monthKeys as $monthKey)
                                            @php $cursor = \Carbon\Carbon::createFromFormat('Y-m', $monthKey)->startOfMonth(); @endphp
                                            <option value="{{ $monthKey }}" {{ $monthKey === $defaultMonthKey ? 'selected' : '' }}>
                                                {{ $cursor->format('F Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Export Monthly PDF (Supervisor) --}}
                                <form
                                    method="GET"
                                    action="{{ route('supervisor.attendance.exportMonthly', $trainee->id) }}"
                                    class="flex items-center"
                                    onsubmit="event.preventDefault(); supervisorExportMonthly(this);"
                                >
                                    <input type="hidden" name="month" value="">
                                    <input type="hidden" name="year" value="">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-brand-navy text-brand-navy text-[10px] font-black uppercase tracking-[0.15em] hover:bg-brand-navy hover:text-white transition"
                                        data-trainee-id="{{ $trainee->id }}"
                                    >
                                        <span>Export PDF</span>
                                    </button>
                                </form>
                            </div>

                            {{-- Calendars --}}
                            @foreach($daysByMonth as $monthKey => $monthDays)
                                @php
                                    $firstDay = $monthDays->first()['date'];
                                    $startOfMonth = $firstDay->copy()->startOfMonth();
                                    $endOfMonth = $firstDay->copy()->endOfMonth();
                                    $startDay = $startOfMonth->dayOfWeek;
                                    $daysInMonth = $endOfMonth->day;
                                    $monthDaysMap = $monthDays->keyBy(fn($day) => $day['date']->toDateString());
                                @endphp

                                <div
                                    class="mb-6 trainee-month-calendar trainee-{{ $trainee->id }}-month"
                                    data-month-key="{{ $monthKey }}"
                                    @if($monthKey !== $defaultMonthKey) style="display:none" @endif
                                >

                                    {{-- Calendar Header --}}
                                    <div class="flex items-center rounded-t-lg overflow-hidden border border-b-0 border-gray-200">
                                        <div class="bg-brand-red text-white px-3 py-2 text-[10px] font-black tracking-widest">
                                            {{ $startOfMonth->format('Y') }}
                                        </div>
                                        <div class="flex-1 bg-white px-3 py-2 text-sm font-black text-brand-navy uppercase text-right">
                                            {{ $startOfMonth->format('F') }}
                                        </div>
                                    </div>

                                    {{-- Day of Week --}}
                                    <div class="grid grid-cols-7 bg-gray-50 border border-b-0 border-gray-200">
                                        @foreach(['SUN','MON','TUE','WED','THU','FRI','SAT'] as $dow)
                                            <div class="px-1 py-2 text-center text-[9px] font-black text-gray-500 uppercase">
                                                {{ $dow }}
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Calendar Grid --}}
                                    <div class="grid grid-cols-7 border border-gray-200 rounded-b-lg">

                                        @for($i = 0; $i < $startDay; $i++)
                                            <div class="min-h-[45px] border-r border-b border-gray-200 bg-gray-50"></div>
                                        @endfor

                                        @for($day = 1; $day <= $daysInMonth; $day++)
                                            @php
                                                $currentDate = $startOfMonth->copy()->day($day);
                                                $dateKey = $currentDate->toDateString();
                                                $isInRange = $currentDate->gte($startDate) && $currentDate->lte($endDate);

                                                $dayData = $monthDaysMap->get($dateKey);
                                                $cellBgClass = !$isInRange ? 'bg-gray-50' : '';

                                                if ($isInRange && $dayData && $dayData['approved'] > 0) {
                                                    $cellBgClass = 'bg-green-50';
                                                }
                                            @endphp

                                            <div class="min-h-[40px] border-r border-b border-gray-200 p-1.5 text-[8px] {{ $cellBgClass }}">
                                                <div class="font-black {{ $isInRange ? 'text-brand-navy' : 'text-gray-300' }} text-[9px]">
                                                    {{ $day }}
                                                </div>

                                                @if($isInRange && $dayData)
                                                    @if($dayData['approved'])
                                                        <div class="flex items-center gap-1">
                                                            <span class="w-1 h-1 rounded-full bg-green-500"></span>
                                                            <span class="text-[8px] text-green-700 font-black">A</span>
                                                        </div>
                                                    @endif
                                                    @if($dayData['pending'])
                                                        <div class="flex items-center gap-1">
                                                            <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                                                            <span class="text-[8px] text-amber-700 font-black">P</span>
                                                        </div>
                                                    @endif
                                                    @if($dayData['rejected'])
                                                        <div class="flex items-center gap-1">
                                                            <span class="w-1 h-1 rounded-full bg-red-500"></span>
                                                            <span class="text-[8px] text-red-700 font-black">R</span>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach

                            {{-- Legend --}}
                            <div class="border-t border-gray-200 pt-3 mt-4">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Legend</p>
                                <div class="flex flex-wrap gap-3 text-[9px]">
                                    <p class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span> Approved
                                    </p>
                                    <p class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Pending
                                    </p>
                                    <p class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span> Rejected
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4" data-aos="zoom-in">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-black text-brand-navy uppercase tracking-tighter">Reject Attendance</h3>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">
                Please provide a reason for rejection
            </p>
        </div>
        
        <form id="rejectForm" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">
                    Rejection Remarks <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="remarks"
                    id="rejectRemarks"
                    rows="4"
                    required
                    minlength="5"
                    maxlength="500"
                    placeholder="Enter the reason for rejecting this attendance request..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-semibold text-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all resize-none"
                ></textarea>
                <p class="text-[9px] text-gray-400 mt-1">
                    Minimum 5 characters required. Maximum 500 characters.
                </p>
                @error('remarks')
                    <p class="text-red-500 text-[9px] font-black uppercase mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button
                    type="button"
                    onclick="closeRejectModal()"
                    class="px-5 py-2 border-2 border-gray-300 text-gray-700 rounded-full font-black text-[10px] uppercase tracking-widest hover:bg-gray-100 transition"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 bg-red-500 text-white rounded-full font-black text-[10px] uppercase tracking-widest hover:bg-red-600 transition shadow"
                >
                    Confirm Rejection
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openRejectModal(attendanceId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    const remarks = document.getElementById('rejectRemarks');
    
    // Set the form action
    form.action = `/supervisor/attendance/reject/${attendanceId}`;
    
    // Clear previous remarks
    remarks.value = '';
    
    // Show modal
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
    
    // Focus on textarea
    setTimeout(() => remarks.focus(), 100);
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    const remarks = document.getElementById('rejectRemarks');
    
    // Hide modal
    modal.style.display = 'none';
    modal.classList.add('hidden');
    
    // Clear form
    remarks.value = '';
    form.action = '';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRejectModal();
    }
});

// FIXED & UPDATED — 100% WORKING MONTH SELECTOR
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.trainee-month-select').forEach(select => {

        select.addEventListener('change', function () {

            const traineeId = this.dataset.traineeId;

            // Normalize dropdown key → always YYYY-MM
            let selected = this.value.trim();
            const parts = selected.split('-');
            if (parts.length === 2) {
                selected = `${parts[0]}-${parts[1].padStart(2, '0')}`;
            }

            // Toggle calendars
            document.querySelectorAll(`.trainee-${traineeId}-month`).forEach(calendar => {

                let calKey = calendar.dataset.monthKey.trim();
                const cParts = calKey.split('-');
                if (cParts.length === 2) {
                    calKey = `${cParts[0]}-${cParts[1].padStart(2, '0')}`;
                }

                // Show only the selected calendar
                calendar.style.display = (calKey === selected) ? '' : 'none';
            });
        });
    });

});

/**
 * When supervisor clicks "Export PDF", read currently selected month
 * from the dropdown, split it into year + month, and submit the form
 * with proper query parameters.
 */
function supervisorExportMonthly(formEl) {
    const card = formEl.closest('.bg-white.rounded-xl.shadow-md.border');
    if (!card) {
        formEl.submit();
        return;
    }

    const select = card.querySelector('.trainee-month-select');
    if (!select || !select.value) {
        alert('Please select a month before exporting.');
        return;
    }

    const [yearStr, monthStr] = select.value.split('-');
    const year = parseInt(yearStr, 10);
    const month = parseInt(monthStr, 10);

    if (!year || !month) {
        alert('Invalid month selected.');
        return;
    }

    formEl.querySelector('input[name="month"]').value = month;
    formEl.querySelector('input[name="year"]').value = year;

    formEl.removeAttribute('onsubmit');
    formEl.submit();
}
</script>
@endpush
