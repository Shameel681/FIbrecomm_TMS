@extends('layouts.supervisor')

@section('content')
<div class="p-10">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-brand-navy">Attendance Approvals</h2>
        <p class="text-gray-500">Review and approve daily clock-ins from your assigned trainees.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-brand-navy uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4">Trainee Name</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Clock In Time</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingAttendances as $attendance)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $attendance->trainee->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-brand-navy">{{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-3">
                                <form action="{{ route('supervisor.attendance.approve', $attendance->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-green-600 transition">
                                        APPROVE
                                    </button>
                                </form>
                                <form action="{{ route('supervisor.attendance.reject', $attendance->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-600 transition">
                                        REJECT
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">No pending attendance requests at the moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection