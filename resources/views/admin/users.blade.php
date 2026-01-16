@extends('layouts.admin')

@section('header_title', 'Command Center - System Overview')

@section('admin_content')
<div class="space-y-8">

    {{-- SYSTEM SEGMENT STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4" data-aos="fade-down">
        {{-- Total Admin --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center border-l-4 border-l-purple-500">
            <h3 class="text-gray-400 font-black text-[9px] uppercase tracking-widest">System Admins</h3>
            <p class="text-brand-navy text-2xl font-black mt-1">{{ $users->where('role', 'admin')->count() }}</p>
        </div>

        {{-- Total HR --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center border-l-4 border-l-brand-red">
            <h3 class="text-gray-400 font-black text-[9px] uppercase tracking-widest">HR Officers</h3>
            <p class="text-brand-navy text-2xl font-black mt-1">{{ $users->where('role', 'hr')->count() }}</p>
        </div>
        
        {{-- Total SV --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center border-l-4 border-l-blue-500">
            <h3 class="text-gray-400 font-black text-[9px] uppercase tracking-widest">Supervisors</h3>
            <p class="text-brand-navy text-2xl font-black mt-1">{{ $users->where('role', 'supervisor')->count() }}</p>
        </div>

        {{-- Total Trainees --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center border-l-4 border-l-green-500">
            <h3 class="text-gray-400 font-black text-[9px] uppercase tracking-widest">Total Trainees</h3>
            <p class="text-brand-navy text-2xl font-black mt-1">{{ $users->where('role', 'trainee')->count() }}</p>
        </div>

        {{-- Active Sessions/Status --}}
        <div class="bg-brand-navy p-5 rounded-2xl shadow-lg flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute -right-2 -bottom-2 opacity-10 group-hover:rotate-12 transition-transform text-white">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
            </div>
            <h3 class="text-white/60 font-black text-[9px] uppercase tracking-[0.2em] relative z-10">System Status</h3>
            <p class="text-white text-xl font-black mt-1 relative z-10 uppercase">Operational</p>
        </div>
    </div>

    {{-- CONSOLIDATED USER LOGS --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-black text-brand-navy uppercase tracking-tighter">Identity Registry</h2>
                <p class="text-brand-red font-bold text-[9px] uppercase tracking-widest">Read-Only Global Access</p>
            </div>
            <div class="relative">
                <input type="text" id="userSearch" placeholder="SEARCH REGISTRY..." class="px-4 py-2 border border-gray-200 rounded-lg text-[10px] font-black focus:ring-1 focus:ring-brand-red focus:outline-none w-64 uppercase tracking-widest">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-4">Identity</th>
                        <th class="px-8 py-4 text-center">Class</th>
                        <th class="px-8 py-4 text-center">Date Onboarded</th>
                        <th class="px-8 py-4 text-right">Access Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="userTableBody">
                    @forelse($users as $user)
                    <tr class="hover:bg-brand-red/[0.02] transition-colors group user-row">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-brand-navy text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-brand-navy uppercase">{{ $user->name }}</p>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $badgeClass = [
                                    'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'hr' => 'bg-red-100 text-brand-red border-brand-red/20',
                                    'supervisor' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'trainee' => 'bg-green-100 text-green-700 border-green-200',
                                ][$user->role] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="{{ $badgeClass }} text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest border shadow-sm">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-[10px] font-bold text-gray-500 uppercase">
                                {{ $user->created_at->format('M d, Y') }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <span class="text-[9px] font-black text-green-500 uppercase tracking-widest bg-green-50 px-2 py-1 rounded">Authorized</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center opacity-20">
                            <p class="text-[10px] font-black uppercase tracking-[0.5em]">System Registry Empty</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Simple Search logic remains for global filtering
    document.getElementById('userSearch').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelectorAll('.user-row');
        rows.forEach(row => {
            let text = row.innerText.toUpperCase();
            row.style.display = text.indexOf(filter) > -1 ? "" : "none";
        });
    });
</script>
@endpush
@endsection