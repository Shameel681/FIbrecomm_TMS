@extends('layouts.hr')

@section('header_title', 'Trainee Monthly Attendance')

@section('hr_content')
<div class="space-y-6 relative" data-aos="fade-up" data-aos-duration="800">
    
    {{-- Notification Alert for New Submissions --}}
    @if($unreadSubmissions->count() > 0)
        <div class="bg-white border-l-4 border-brand-red p-6 rounded-xl shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-brand-red/5 rounded-bl-full"></div>
            <div class="relative z-10 flex items-start justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="shrink-0 pt-1">
                        <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-brand-navy uppercase tracking-wider mb-2">
                            New Monthly Attendance Submissions
                        </h3>
                        <p class="text-xs text-gray-600 font-semibold mb-3">
                            {{ $unreadSubmissions->count() }} {{ $unreadSubmissions->count() === 1 ? 'trainee has' : 'trainees have' }} submitted their monthly attendance report.
                        </p>
                        <div class="space-y-2">
                            @foreach($unreadSubmissions->take(5) as $submission)
                                <div class="flex items-center gap-2 text-xs text-gray-700">
                                    <span class="w-2 h-2 bg-brand-red rounded-full"></span>
                                    <span class="font-bold">{{ $submission->trainee->name ?? 'Unknown Trainee' }}</span>
                                    <span class="text-gray-400">—</span>
                                    <span class="font-semibold text-brand-navy">{{ \Carbon\Carbon::create($submission->year, $submission->month, 1)->format('F Y') }}</span>
                                    <span class="text-gray-400 text-[10px]">({{ $submission->created_at->diffForHumans() }})</span>
                                </div>
                            @endforeach
                            @if($unreadSubmissions->count() > 5)
                                <p class="text-[10px] text-brand-red font-bold italic mt-2">
                                    +{{ $unreadSubmissions->count() - 5 }} more submission(s)
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Header / Step 1: Select Period & Global Actions --}}
    <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-navy/5 rounded-bl-full"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h2 class="text-2xl font-black text-brand-navy uppercase tracking-tighter">Trainee Monthly Attendance</h2>
                <div class="flex items-center gap-2 mt-1">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                        Step 1 &mdash; Filter Period
                    </p>
                    @if($periodChosen)
                        <span class="h-1 w-1 bg-gray-300 rounded-full"></span>
                        <p class="text-[10px] font-black text-brand-red uppercase tracking-[0.2em]">
                            Active: {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('hr.submissions.traineeMonthly') }}" class="flex flex-wrap gap-2 items-center">
                    <select name="month" class="rounded-lg border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                        <option value="" {{ !$month ? 'selected' : '' }} disabled>Month</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="year" class="rounded-lg border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                        <option value="" {{ !$year ? 'selected' : '' }} disabled>Year</option>
                        @for($y = date('Y'); $y >= date('Y')-1; $y--)
                            <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-brand-navy text-white px-5 py-2.5 rounded-lg text-[11px] font-black uppercase tracking-[0.2em] hover:bg-brand-navy/90 transition shadow-sm">
                        Apply
                    </button>
                </form>

                <div class="h-8 w-px bg-gray-200 mx-1 hidden md:block"></div>

                <button
                    type="button"
                    onclick="openSetRateModal()"
                    class="bg-white text-brand-navy px-5 py-2.5 rounded-lg text-[11px] font-black uppercase tracking-[0.2em] hover:bg-brand-navy hover:text-white transition-all duration-300 border-2 border-brand-navy/10 shadow-sm flex items-center gap-2"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Allowance Rate
                </button>
            </div>
        </div>

        @if(!$periodChosen)
            <p class="text-[10px] font-black text-brand-red uppercase tracking-[0.2em] mt-4 flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-brand-red rounded-full animate-pulse"></span>
                Please select a month and year to load records.
            </p>
        @endif
    </div>

    @if($periodChosen)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left Column: Trainee List --}}
        <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">Step 2 &mdash; Trainees</h3>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Active accounts only</p>
                </div>
                <span class="px-2 py-1 bg-brand-navy/5 text-brand-navy rounded text-[9px] font-black uppercase">{{ $trainees->count() }} Total</span>
            </div>
            <div class="max-h-[600px] overflow-y-auto">
                <table class="w-full text-left text-xs">
                    <tbody class="divide-y divide-gray-50">
                        @forelse($trainees as $trainee)
                            <tr class="hover:bg-gray-50 transition-colors {{ $selectedTraineeId == $trainee->id ? 'bg-brand-red/[0.03] border-l-4 border-brand-red' : 'border-l-4 border-transparent' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div class="h-9 w-9 bg-brand-navy text-white flex items-center justify-center font-black rounded-lg text-xs shadow-sm">
                                                {{ strtoupper(substr($trainee->name, 0, 1)) }}
                                            </div>
                                            @if(isset($trainee->submission_is_unread) && $trainee->submission_is_unread)
                                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-brand-red rounded-full border-2 border-white"></span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="font-black text-brand-navy uppercase text-[11px]">{{ $trainee->name }}</p>
                                                @if(isset($trainee->has_submitted) && $trainee->has_submitted)
                                                    <span class="px-1.5 py-0.5 bg-green-100 text-green-700 text-[8px] font-black uppercase rounded">Submitted</span>
                                                @endif
                                            </div>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">
                                                Approved: {{ $trainee->monthly_approved_count }} days
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('hr.submissions.traineeMonthly', ['month' => $month, 'year' => $year, 'trainee_id' => $trainee->id]) }}"
                                       class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-brand-red hover:text-brand-navy transition p-2">
                                        <span>View</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center opacity-40">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        <p class="text-[11px] font-black uppercase tracking-widest">No Trainees Found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column: Detailed View --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            @if($selectedTrainee)
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h4 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">
                            {{ $selectedTrainee->name }} &mdash; Step 3
                        </h4>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                            {{ $selectedDate->format('F Y') }} &middot; Approved: {{ $traineeRecords->where('status','approved')->count() }} Days
                        </p>
                    </div>
                    <a href="{{ route('hr.submissions.traineeMonthly.export', ['trainee' => $selectedTrainee->id, 'month' => $month, 'year' => $year]) }}"
                       class="px-4 py-2 bg-brand-navy text-white rounded-lg text-[10px] font-black uppercase tracking-[0.2em] hover:bg-brand-red transition shadow-sm">
                        Export PDF
                    </a>
                </div>

                @if($traineeRecords && $traineeRecords->count())
                    <div class="grid grid-cols-1 xl:grid-cols-5 h-full">
                        {{-- Calendar --}}
                        <div class="xl:col-span-3 border-r border-gray-100 p-6">
                            @php
                                $startOfMonth = $selectedDate->copy()->startOfMonth();
                                $endOfMonth = $selectedDate->copy()->endOfMonth();
                                $startDay = $startOfMonth->dayOfWeek;
                                $daysInMonth = $endOfMonth->day;
                            @endphp

                            <div class="grid grid-cols-7 bg-brand-navy/5 border border-brand-navy/10 rounded-t-xl overflow-hidden">
                                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dow)
                                    <div class="px-2 py-3 text-center text-[9px] font-black text-brand-navy uppercase tracking-widest">
                                        {{ $dow }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="grid grid-cols-7 border border-t-0 border-gray-100 rounded-b-xl overflow-hidden">
                                @for($i = 0; $i < $startDay; $i++)
                                    <div class="min-h-[80px] border-r border-b border-gray-50 bg-gray-50/50"></div>
                                @endfor

                                @for($day = 1; $day <= $daysInMonth; $day++)
                                    @php
                                        $currentDate = $startOfMonth->copy()->day($day);
                                        $dateKey = $currentDate->toDateString();
                                        $dayRecords = $calendarByDate->get($dateKey, collect());
                                        $approved = $dayRecords->where('status','approved')->count();
                                        $pending  = $dayRecords->where('status','pending')->count();
                                        $rejected = $dayRecords->where('status','rejected')->count();
                                    @endphp
                                    <div class="min-h-[80px] border-r border-b border-gray-100 p-2 hover:bg-gray-50 transition-colors">
                                        <div class="font-black text-brand-navy mb-2 text-xs">{{ $day }}</div>
                                        @if($dayRecords->count())
                                            <div class="space-y-1">
                                                @if($approved)
                                                    <div class="flex items-center gap-1.5 px-1.5 py-0.5 bg-green-50 rounded">
                                                        <span class="w-1 h-1 rounded-full bg-green-500"></span>
                                                        <span class="text-[8px] text-green-700 font-black uppercase">Appr x{{ $approved }}</span>
                                                    </div>
                                                @endif
                                                @if($pending)
                                                    <div class="flex items-center gap-1.5 px-1.5 py-0.5 bg-amber-50 rounded">
                                                        <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                                                        <span class="text-[8px] text-amber-700 font-black uppercase">Pend x{{ $pending }}</span>
                                                    </div>
                                                @endif
                                                @if($rejected)
                                                    <div class="flex items-center gap-1.5 px-1.5 py-0.5 bg-red-50 rounded">
                                                        <span class="w-1 h-1 rounded-full bg-red-500"></span>
                                                        <span class="text-[8px] text-red-700 font-black uppercase">Rej x{{ $rejected }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-[8px] text-gray-300 italic">No logs</span>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Metadata Panel --}}
                        <div class="xl:col-span-2 p-6 bg-gray-50/50 space-y-6">
                            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Submission Info</p>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[11px] font-bold text-gray-500 uppercase">Supervisor</span>
                                        <span class="text-[11px] font-black text-brand-navy uppercase">{{ $selectedTrainee->supervisor->name ?? 'Not Assigned' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[11px] font-bold text-gray-500 uppercase">Total Logs</span>
                                        <span class="text-[11px] font-black text-brand-navy uppercase">{{ $traineeRecords->count() }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                                        <span class="text-[11px] font-bold text-brand-red uppercase">Approved Days</span>
                                        <span class="text-lg font-black text-brand-navy">{{ $traineeRecords->where('status','approved')->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Status Legend</p>
                                <div class="grid grid-cols-1 gap-2">
                                    <div class="flex items-center gap-3 p-2 rounded-lg bg-white border border-gray-100">
                                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-600">Approved Log</span>
                                    </div>
                                    <div class="flex items-center gap-3 p-2 rounded-lg bg-white border border-gray-100">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-600">Awaiting Verification</span>
                                    </div>
                                    <div class="flex items-center gap-3 p-2 rounded-lg bg-white border border-gray-100">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-600">Rejected Entry</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-6 py-24 text-center">
                        <div class="flex flex-col items-center opacity-30">
                            <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-sm font-black uppercase tracking-widest text-gray-500 italic">No attendance logs for {{ $selectedDate->format('F Y') }}</p>
                        </div>
                    </div>
                @endif
            @else
                <div class="h-full flex items-center justify-center p-16">
                    <div class="text-center max-w-xs">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        </div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest leading-loose">
                            Select a trainee from the list to preview their monthly records and export data.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- Global Allowance Rate Modal --}}
<div id="setRateModal" class="fixed inset-0 bg-brand-navy/60 hidden items-center justify-center z-50 backdrop-blur-sm transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 border border-white/20 overflow-hidden" data-aos="zoom-in" data-aos-duration="300">
        <div class="p-8 border-b border-gray-100 bg-brand-navy relative">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full"></div>
            <h3 class="text-xl font-black text-white uppercase tracking-tighter">Global Allowance Rate</h3>
            <p class="text-[10px] font-bold text-white/60 uppercase tracking-widest mt-1">
                Configure the default daily rate for all trainees
            </p>
        </div>

        <form id="setRateForm" method="POST" action="{{ route('hr.submissions.traineeMonthly.setGlobalRate') }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                    Daily Rate (RM) <span class="text-brand-red">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-brand-navy">RM</span>
                    <input
                        type="number"
                        name="rate"
                        id="globalRateInput"
                        step="0.01"
                        min="0"
                        max="9999.99"
                        value="{{ $globalDefaultRate ?? 30 }}"
                        required
                        class="w-full pl-12 pr-4 py-4 bg-gray-50 border-2 border-gray-100 rounded-xl outline-none font-black text-brand-navy text-lg focus:border-brand-navy focus:bg-white transition-all"
                        placeholder="0.00"
                    >
                </div>
                <div class="flex items-center gap-2 px-1">
                    <svg class="w-3.5 h-3.5 text-brand-red" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">
                        Current system rate: <span class="text-brand-navy">RM {{ number_format($globalDefaultRate ?? 30, 2) }}</span>
                    </p>
                </div>
                @error('rate')
                    <p class="text-brand-red text-[9px] font-black uppercase mt-2 px-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button
                    type="button"
                    onclick="closeSetRateModal()"
                    class="flex-1 px-6 py-3 border-2 border-gray-100 text-gray-400 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-50 transition"
                >
                    Discard
                </button>
                <button
                    type="submit"
                    class="flex-1 px-6 py-3 bg-brand-navy text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-brand-red transition shadow-lg shadow-brand-navy/20"
                >
                    Update Rate
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openSetRateModal() {
    const modal = document.getElementById('setRateModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeSetRateModal() {
    const modal = document.getElementById('setRateModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

document.addEventListener('click', function(e) {
    const modal = document.getElementById('setRateModal');
    if (modal && e.target === modal) {
        closeSetRateModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const setRateForm = document.getElementById('setRateForm');
    if (setRateForm) {
        setRateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            submitButton.disabled = true;
            submitButton.textContent = 'UPDATING...';
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Error updating rate.');
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            });
        });
    }
});
</script>
@endpush
@endsection