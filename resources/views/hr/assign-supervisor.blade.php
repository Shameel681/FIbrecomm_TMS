@extends('layouts.hr')

{{-- This updates the text in the blue sub-navbar --}}
@section('header_title', 'Supervisor Assignment')

{{-- This MUST match the @yield('hr_content') in your layouts/hr.blade.php --}}
@section('hr_content')
<div class="space-y-8" data-aos="fade-up">
    {{-- Header Section --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-brand-navy uppercase tracking-tighter">Supervisor Assignment</h2>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Link trainees to authority units for attendance approval</p>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Trainee Identity</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Current Authority</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Reassign Supervisor</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($trainees as $trainee)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        {{-- Trainee Name --}}
                        <td class="px-8 py-5">
                            <p class="font-bold text-brand-navy uppercase tracking-tighter">{{ $trainee->name }}</p>
                            <p class="text-[10px] text-gray-400 font-medium">ID: #{{ $trainee->id }}</p>
                        </td>

                        {{-- Current Supervisor Badge --}}
                        <td class="px-8 py-5">
                            @if($trainee->supervisor)
                                <div class="flex flex-col">
                                    <span class="text-brand-red text-[10px] font-black uppercase tracking-widest italic">Assigned to:</span>
                                    <span class="text-sm font-bold text-brand-navy">{{ $trainee->supervisor->name }}</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                                        {{ $trainee->supervisor->department ?? 'Unit: Technical' }}
                                    </span>
                                </div>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-600 text-[10px] font-black rounded-full uppercase tracking-tighter shadow-sm">
                                    Unassigned
                                </span>
                            @endif
                        </td>

                        {{-- Assignment Form --}}
                        <td class="px-8 py-5">
                            <form action="{{ route('hr.attendance.assign_store', $trainee->id) }}" method="POST" class="flex justify-center gap-3">
                                @csrf
                                <div class="relative w-64">
                                    <select name="supervisor_id" class="w-full appearance-none bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold text-brand-navy focus:ring-2 focus:ring-brand-red focus:border-transparent outline-none transition-all cursor-pointer">
                                        <option value="" disabled {{ !$trainee->supervisor_id ? 'selected' : '' }}>Select Supervisor Unit</option>
                                        @foreach($supervisors as $sv)
                                            @php
                                                $isAssigned = in_array($sv->id, $assignedSupervisorIds ?? []);
                                                $isCurrent  = $trainee->supervisor_id == $sv->id;
                                            @endphp
                                            <option 
                                                value="{{ $sv->id }}" 
                                                {{ $isCurrent ? 'selected' : '' }}
                                                {{ $isAssigned && !$isCurrent ? 'disabled' : '' }}
                                            >
                                                {{ $sv->name }} ({{ $sv->department ?? 'General' }})
                                                @if($isAssigned && !$isCurrent)
                                                    - Already assigned
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                <button type="submit" class="bg-brand-navy text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-brand-red transition-all shadow-md active:scale-95">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Empty State (Optional) --}}
    @if($trainees->isEmpty())
        <div class="bg-white p-20 rounded-2xl border-2 border-dashed border-gray-100 text-center">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">No active trainees found</p>
        </div>
    @endif
</div>
@endsection