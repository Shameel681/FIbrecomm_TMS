@extends('layouts.hr')

@section('header_title', 'Trainee Management')

@section('hr_content')
<div class="space-y-8">
    {{-- Active Status Header --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-down">
        <div class="col-span-2 bg-white p-8 border border-gray-100 rounded-2xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tighter">Active Interns</h2>
                <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-[10px]">Current Live Placements</p>
            </div>
            <div class="text-center bg-brand-navy/5 px-8 py-4 rounded-2xl border border-brand-navy/10">
                <span class="block text-4xl font-black text-brand-navy leading-none">{{ $activeCount }}</span>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Active Now</span>
            </div>
        </div>
        
        <div class="bg-brand-red p-8 rounded-2xl shadow-lg flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </div>
            <h3 class="text-white font-black text-xs uppercase tracking-[0.2em] relative z-10">Total Registered</h3>
            <p class="text-white text-4xl font-black mt-2 relative z-10">{{ $totalRegistered }}</p>
        </div>
    </div>

    {{-- Trainee List Section --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        {{-- List Header/Filters --}}
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">Personnel Directory</h3>
            <div class="flex gap-4">
                <input type="text" id="traineeSearch" placeholder="Search trainee name..." class="px-4 py-2 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-brand-red focus:outline-none w-64">
            </div>
        </div>

        {{-- Scrollable Box --}}
        <div class="overflow-y-auto max-h-[600px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white z-10 shadow-sm">
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-4">Trainee</th>
                        <th class="px-8 py-4 text-center">Contact Information</th>
                        <th class="px-8 py-4 text-center">Internship Period</th>
                        <th class="px-8 py-4 text-center">Status</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="traineeTableBody">
                    @forelse($trainees as $trainee)
                    <tr class="hover:bg-brand-red/[0.02] transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-brand-navy text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                    {{ strtoupper(substr($trainee->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-brand-navy uppercase trainee-name">{{ $trainee->name }}</p>
                                    <p class="text-[9px] font-bold text-gray-400">REG-ID: {{ str_pad($trainee->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <p class="text-[10px] font-black text-brand-navy uppercase tracking-tighter">{{ $trainee->email }}</p>
                            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-0.5 rounded border border-gray-100">Verified Account</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <div class="inline-flex flex-col">
                                <span class="text-[10px] font-black text-brand-navy uppercase">
                                    {{ \Carbon\Carbon::parse($trainee->start_date)->format('M d, Y') }}
                                </span>
                                <span class="text-[9px] font-bold text-gray-400 uppercase">to {{ \Carbon\Carbon::parse($trainee->end_date)->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $isActive = now()->between($trainee->start_date, $trainee->end_date);
                            @endphp
                            @if($isActive)
                                <span class="bg-green-100 text-green-700 text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-green-200 shadow-sm">Active Now</span>
                            @else
                                <span class="bg-gray-100 text-gray-400 text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Completed</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button class="text-brand-navy hover:text-brand-red transition-colors p-2 bg-gray-50 rounded-lg border border-gray-100 hover:border-brand-red/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">No registered trainees found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Inline Search Logic --}}
@push('scripts')
<script>
    document.getElementById('traineeSearch').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelector("#traineeTableBody").rows;
        
        for (let i = 0; i < rows.length; i++) {
            let nameCol = rows[i].querySelector(".trainee-name");
            if (nameCol) {
                let textValue = nameCol.textContent || nameCol.innerText;
                rows[i].style.display = textValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    });
</script>
@endpush
@endsection