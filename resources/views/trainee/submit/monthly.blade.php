@extends('layouts.trainee')

@section('content')
<div class="container mx-auto px-6 py-8" data-aos="fade-up">
    <h3 class="text-gray-700 text-3xl font-medium text-brand-navy">Monthly Attendance Report</h3>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    {{-- Summary Card & Calendar --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-md border-t-4 border-brand-navy relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-brand-navy/5 rounded-bl-full"></div>

            <div class="relative z-10 space-y-4">
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Reporting Month</p>
                    <p class="text-xl font-black text-brand-navy">
                        {{ $targetDate->format('F Y') }}
                    </p>
                </div>

                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Total Records</p>
                        <p class="text-2xl font-black text-brand-navy">{{ $records->count() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Approved Days</p>
                        <p class="text-3xl font-black text-brand-red">{{ $approvedCount }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 space-y-2 text-xs text-gray-500">
                    <p class="font-semibold">
                        This report groups all your daily attendances for the selected month so HR can process your allowance.
                    </p>
                    <p class="italic">
                        Make sure your clock-ins are correct before submitting.
                    </p>
                </div>

                <div class="pt-4 space-y-2 border-t border-gray-100">
                    <form action="{{ route('trainee.monthly.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="year" value="{{ $year }}">
                        <button type="submit"
                            class="w-full bg-brand-navy hover:bg-brand-red text-white font-black text-[11px] uppercase tracking-[0.2em] py-3 rounded-xl shadow-lg transition-all active:scale-95 mb-2">
                            Submit Monthly Report to HR
                        </button>
                    </form>
                    <a href="{{ route('trainee.monthly.export', ['month' => $month, 'year' => $year]) }}"
                       class="block w-full text-center bg-white border-2 border-brand-navy text-brand-navy hover:bg-brand-navy hover:text-white font-black text-[11px] uppercase tracking-[0.2em] py-3 rounded-xl shadow-sm transition-all active:scale-95">
                        Export PDF Summary
                    </a>
                </div>
            </div>
        </div>

        {{-- Calendar-style Attendance --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
                    Daily Attendance Calendar &mdash; {{ $targetDate->format('F Y') }}
                </h4>
                <form method="GET" action="{{ route('trainee.monthly.index') }}" class="flex gap-2 items-center">
                    <select name="month" class="rounded-md border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="year" class="rounded-md border-gray-300 shadow-sm text-xs focus:border-brand-navy focus:ring-brand-navy">
                        @for($y = date('Y'); $y >= date('Y')-1; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-brand-navy text-white px-3 py-1 rounded text-[11px] hover:bg-opacity-90 transition">
                        Change Month
                    </button>
                </form>
            </div>

            @php
                $startOfMonth = $targetDate->copy()->startOfMonth();
                $endOfMonth = $targetDate->copy()->endOfMonth();
                $startDay = $startOfMonth->dayOfWeek; // 0 = Sunday
                $daysInMonth = $endOfMonth->day;
            @endphp

            <div class="p-4 border-t border-gray-100">
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

                <div class="mt-4 text-[10px] text-gray-400">
                    <p class="font-black uppercase tracking-[0.2em] mb-1">Legend</p>
                    <p class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-500"></span> Approved</p>
                    <p class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Pending</p>
                    <p class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-500"></span> Rejected</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

