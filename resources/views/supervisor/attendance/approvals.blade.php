@extends('layouts.supervisor')

{{-- Match the header title in your layout --}}
@section('header_title', 'Attendance Approvals')

{{-- CHANGED: Must match @yield('supervisor_content') in your layout --}}
@section('supervisor_content') 
<div class="p-2"> {{-- Reduced padding as layout already provides p-10 --}}
    <div class="mb-8" data-aos="fade-right">
        <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tighter">Attendance Approvals</h2>
        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.2em]">Review and approve daily clock-ins from your assigned trainees.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-brand-navy uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-5">Trainee Name</th>
                    <th class="px-8 py-5">Date</th>
                    <th class="px-8 py-5">Clock In Time</th>
                    <th class="px-8 py-5 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingAttendances as $attendance)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-8 py-5 font-bold text-brand-navy uppercase text-xs">
                            {{ $attendance->trainee?->user?->name ?? $attendance->trainee?->name ?? 'Unknown Trainee' }}
                        </td>
                        <td class="px-8 py-5 text-xs font-bold text-gray-500">
                            {{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-8 py-5 text-xs font-black text-blue-600">
                            {{ $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') : '-' }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-center gap-3">
                                <form action="{{ route('supervisor.attendance.approve', $attendance->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded font-black text-[10px] uppercase tracking-widest hover:bg-brand-navy transition shadow-sm">
                                        APPROVE
                                    </button>
                                </form>
                                <form action="{{ route('supervisor.attendance.reject', $attendance->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="border-2 border-red-500 text-red-500 px-5 py-2 rounded font-black text-[10px] uppercase tracking-widest hover:bg-red-500 hover:text-white transition shadow-sm">
                                        REJECT
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">No pending attendance requests</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection