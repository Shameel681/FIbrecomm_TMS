@extends('layouts.hr')

@section('header_title', 'Inactive Trainees')

@section('hr_content')
<div class="space-y-8" data-aos="fade-up">
    <div class="bg-white p-8 border border-gray-100 rounded-2xl shadow-sm flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tighter">Inactive / Deactivated Interns</h2>
            <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-[10px]">Read-only archive for HR reference</p>
        </div>
        <div class="text-center bg-gray-100 px-8 py-4 rounded-2xl border border-gray-200">
            <span class="block text-4xl font-black text-brand-navy leading-none">{{ $inactiveTrainees->count() }}</span>
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Total Inactive</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-[11px] font-black text-brand-navy uppercase tracking-[0.2em]">Inactive Trainee Directory</h3>
            <a href="{{ route('hr.trainees') }}" class="px-4 py-2 text-[9px] font-black uppercase tracking-widest rounded-lg border border-brand-navy text-brand-navy hover:bg-brand-navy hover:text-white transition">
                Back to Active List
            </a>
        </div>

        <div class="overflow-y-auto max-h-[600px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white z-10 shadow-sm">
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-4">Trainee</th>
                        <th class="px-8 py-4 text-center">Contact Information</th>
                        <th class="px-8 py-4 text-center">Internship Period</th>
                        <th class="px-8 py-4 text-center">Account Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($inactiveTrainees as $trainee)
                        <tr class="hover:bg-brand-red/[0.02] transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 bg-gray-300 text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                        {{ strtoupper(substr($trainee->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-brand-navy uppercase">{{ $trainee->name }}</p>
                                        <p class="text-[9px] font-bold text-gray-400">REG-ID: {{ str_pad($trainee->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <p class="text-[10px] font-black text-brand-navy uppercase tracking-tighter">{{ $trainee->email }}</p>
                                @if($trainee->user)
                                    <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-2 py-0.5 rounded border border-gray-100">
                                        User: {{ $trainee->user->email }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="inline-flex flex-col">
                                    <span class="text-[10px] font-black text-brand-navy uppercase">
                                        {{ \Carbon\Carbon::parse($trainee->start_date)->format('M d, Y') }}
                                    </span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase">
                                        to {{ \Carbon\Carbon::parse($trainee->end_date)->format('M d, Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="bg-red-100 text-red-700 text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-red-200 shadow-sm">
                                    Account Deactivated
                                </span>
                                @if($trainee->status === 'completed')
                                    <div class="mt-1 text-[8px] text-gray-400 font-bold uppercase tracking-widest">
                                        Internship Completed
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="flex flex-col items-center text-gray-300">
                                    <svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <p class="text-[10px] font-black uppercase tracking-[0.5em]">No inactive trainees found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

