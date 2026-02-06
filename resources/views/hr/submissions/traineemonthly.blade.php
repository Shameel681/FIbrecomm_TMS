@extends('layouts.hr')

@section('header_title', 'Trainee Monthly Attendance')

@section('hr_content')
<div class="space-y-8" data-aos="fade-up" data-aos-duration="800">

    {{-- Notification Alert for New Submissions --}}
    @if($unreadSubmissions->count() > 0)
        <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-lg shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-bl-full"></div>
            <div class="relative z-10 flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-amber-900 uppercase tracking-wider mb-2">
                            New Monthly Attendance Submissions
                        </h3>
                        <p class="text-xs text-amber-700 font-semibold mb-3">
                            {{ $unreadSubmissions->count() }} {{ $unreadSubmissions->count() === 1 ? 'trainee has' : 'trainees have' }} submitted their monthly attendance report.
                        </p>
                        <div class="space-y-2">
                            @foreach($unreadSubmissions->take(5) as $submission)
                                <div class="flex items-center gap-2 text-xs text-amber-800">
                                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                    <span class="font-bold">{{ $submission->trainee->name ?? 'Unknown Trainee' }}</span>
                                    <span class="text-amber-600">—</span>
                                    <span class="font-semibold">{{ \Carbon\Carbon::create($submission->year, $submission->month, 1)->format('F Y') }}</span>
                                    <span class="text-amber-500 text-[10px]">({{ $submission->created_at->diffForHumans() }})</span>
                                </div>
                            @endforeach
                            @if($unreadSubmissions->count() > 5)
                                <p class="text-[10px] text-amber-600 font-bold italic">
                                    +{{ $unreadSubmissions->count() - 5 }} more submission(s)
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Header / Step 1: Select Period --}}
    <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-navy/5 rounded-bl-full"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <h2 class="text-2xl font-black text-brand-navy uppercase tracking-tighter">Trainee Monthly Attendance</h2>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mt-1">
                    Step 1 &mdash; Choose the reporting period
                </p>
            </div>

            <form method="GET" action="{{ route('hr.submissions.traineeMonthly') }}" class="flex flex-wrap gap-2 items-center">
                <select name="month" class="rounded-md border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                    <option value="" {{ !$month ? 'selected' : '' }} disabled>Select Month</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ (int)$month === $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
                <select name="year" class="rounded-md border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                    <option value="" {{ !$year ? 'selected' : '' }} disabled>Select Year</option>
                    @for($y = date('Y'); $y >= date('Y')-1; $y--)
                        <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                @if($selectedTraineeId)
                    <input type="hidden" name="trainee_id" value="{{ $selectedTraineeId }}">
                @endif
                <button type="submit" class="bg-brand-navy text-white px-4 py-2 rounded text-[11px] font-black uppercase tracking-[0.2em] hover:bg-brand-red transition">
                    Apply Period
                </button>
            </form>
        </div>

        @if($periodChosen)
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
                Active Period: {{ \Carbon\Carbon::create($year, $month, 1)->format('F Y') }}
            </p>
        @else
            <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.2em]">
                Please select a month and year to load active trainees.
            </p>
        @endif
    </div>

    @if($periodChosen)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left: Step 2 - Active Trainee List --}}
        <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">Step 2 &mdash; Select Active Trainee</h3>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Only active trainee accounts are listed</p>
                </div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $trainees->count() }} active</p>
            </div>
            <div class="max-h-[520px] overflow-y-auto">
                <table class="w-full text-left text-xs">
                    <tbody class="divide-y divide-gray-50">
                        @forelse($trainees as $trainee)
                            <tr class="hover:bg-brand-red/[0.02] transition-colors {{ $selectedTraineeId == $trainee->id ? 'bg-brand-red/[0.04]' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div class="h-8 w-8 bg-brand-navy text-white flex items-center justify-center font-black rounded-md text-xs">
                                                {{ strtoupper(substr($trainee->name, 0, 1)) }}
                                            </div>
                                            @if(isset($trainee->submission_is_unread) && $trainee->submission_is_unread)
                                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-amber-500 rounded-full border-2 border-white"></span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="font-black text-brand-navy uppercase text-[11px]">{{ $trainee->name }}</p>
                                                @if(isset($trainee->has_submitted) && $trainee->has_submitted)
                                                    <span class="px-1.5 py-0.5 bg-green-100 text-green-700 text-[8px] font-black uppercase rounded">Submitted</span>
                                                @endif
                                            </div>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                                                Approved: {{ $trainee->monthly_approved_count }} days
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('hr.submissions.traineeMonthly', ['month' => $month, 'year' => $year, 'trainee_id' => $trainee->id]) }}"
                                       class="inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-brand-red hover:text-brand-navy transition">
                                        <span>View</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-10 text-center text-gray-400 text-[11px] italic">
                                    No trainees have attendance for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right: Step 3 - Calendar & Details --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h4 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">
                        @if($selectedTrainee)
                            {{ $selectedTrainee->name }} &mdash; Daily Logs
                        @else
                            Select a trainee to view detailed logs
                        @endif
                    </h4>
                    @if($selectedTrainee)
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                            {{ $selectedDate->format('F Y') }} &middot; Approved Days: {{ $traineeRecords->where('status','approved')->count() }}
                        </p>
                    @endif
                </div>
            </div>

            @if($selectedTrainee && $traineeRecords->count())
                <div class="grid grid-cols-1 lg:grid-cols-5 border-t border-gray-100">
                    {{-- Calendar --}}
                    <div class="lg:col-span-3 border-r border-gray-100 p-4">
                        @php
                            $startOfMonth = $selectedDate->copy()->startOfMonth();
                            $endOfMonth = $selectedDate->copy()->endOfMonth();
                            $startDay = $startOfMonth->dayOfWeek; // 0=Sun
                            $daysInMonth = $endOfMonth->day;
                        @endphp

                        <div class="grid grid-cols-7 bg-gray-50 border border-gray-100 rounded-t-xl">
                            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dow)
                                <div class="px-2 py-2 text-center text-[10px] font-black text-gray-500 uppercase tracking-widest">
                                    {{ $dow }}
                                </div>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-7 border border-t-0 border-gray-100 rounded-b-xl">
                            @for($i = 0; $i < $startDay; $i++)
                                <div class="min-h-[70px] border-r border-b border-gray-100 bg-gray-50"></div>
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
                                <div class="min-h-[70px] border-r border-b border-gray-100 p-2 text-[10px]">
                                    <div class="font-black text-brand-navy mb-1">{{ $day }}</div>
                                    @if($dayRecords->count())
                                        @if($approved)
                                            <div class="flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                <span class="text-[9px] text-green-700 font-black">Approved x{{ $approved }}</span>
                                            </div>
                                        @endif
                                        @if($pending)
                                            <div class="flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                <span class="text-[9px] text-amber-700 font-black">Pending x{{ $pending }}</span>
                                            </div>
                                        @endif
                                        @if($rejected)
                                            <div class="flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                <span class="text-[9px] text-red-700 font-black">Rejected x{{ $rejected }}</span>
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-[9px] text-gray-300 italic">No records</span>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Details + Export --}}
                    <div class="lg:col-span-2 p-4 space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Summary</p>
                                <p class="text-sm font-black text-brand-navy">
                                    {{ $selectedTrainee->name }} &middot; {{ $selectedDate->format('F Y') }}
                                </p>
                            </div>
                            <a href="{{ route('hr.submissions.traineeMonthly.export', ['trainee' => $selectedTrainee->id, 'month' => $month, 'year' => $year]) }}"
                               class="px-4 py-2 bg-gray-100 hover:bg-brand-navy hover:text-white rounded-lg text-[10px] font-black uppercase tracking-[0.2em] border border-gray-200 hover:border-brand-navy transition">
                                Export PDF
                            </a>
                        </div>

                        <div class="border-t border-gray-100 pt-3 text-[11px] text-gray-600 space-y-1">
                            <p><span class="font-bold text-brand-navy">Approved days:</span> {{ $traineeRecords->where('status','approved')->count() }}</p>
                            <p><span class="font-bold text-brand-navy">Total records:</span> {{ $traineeRecords->count() }}</p>
                            <p><span class="font-bold text-brand-navy">Supervisor:</span> {{ $selectedTrainee->supervisor->name ?? 'Not Assigned' }}</p>
                        </div>

                        <div class="border-t border-gray-100 pt-3 text-[10px] text-gray-400">
                            <p class="font-black uppercase tracking-[0.2em] mb-1">Legend</p>
                            <p class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-500"></span> Approved</p>
                            <p class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Pending</p>
                            <p class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-500"></span> Rejected</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="px-6 py-16 text-center text-gray-400 text-[11px] italic">
                    @if($selectedTrainee)
                        No attendance logs found for this trainee in {{ $selectedDate->format('F Y') }}.
                    @else
                        Choose a trainee from the list on the left to inspect their daily logs.
                    @endif
                </div>
            @endif
        </div>

    </div>
    @endif
</div>
@endsection

