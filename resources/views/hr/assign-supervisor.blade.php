@extends('layouts.hr')

@section('content')
<div class="p-10">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-brand-navy">Supervisor Assignment</h2>
        <p class="text-gray-500">Link trainees to their respective supervisors for attendance approval.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-brand-navy uppercase text-sm">
                <tr>
                    <th class="px-6 py-4 font-bold">Trainee Name</th>
                    <th class="px-6 py-4 font-bold">Current Supervisor</th>
                    <th class="px-6 py-4 font-bold text-center">Assign New Supervisor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($trainees as $trainee)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $trainee->name }}</td>
                        <td class="px-6 py-4">
                            @if($trainee->supervisor)
                                <span class="text-green-600 bg-green-50 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $trainee->supervisor->name }}
                                </span>
                            @else
                                <span class="text-red-500 bg-red-50 px-3 py-1 rounded-full text-xs font-bold">Unassigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('hr.attendance.assign_store', $trainee->id) }}" method="POST" class="flex justify-center gap-3">
                                @csrf
                                <select name="supervisor_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-navy outline-none">
                                    <option value="" disabled selected>Select Supervisor</option>
                                    @foreach($supervisors as $sv)
                                        <option value="{{ $sv->id }}" {{ $trainee->supervisor_id == $sv->id ? 'selected' : '' }}>
                                            {{ $sv->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-brand-navy text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-900 transition shadow-sm">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection