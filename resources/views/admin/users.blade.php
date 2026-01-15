@extends('layouts.hr') {{-- Reusing your HR layout for styling consistency --}}

@section('header_title', 'System User Management')

@section('hr_content')
<div class="space-y-8">

    {{-- STATS HEADER --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" data-aos="fade-down">
        <div class="md:col-span-2 bg-white p-8 border border-gray-100 rounded-2xl shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tighter">System Users</h2>
                <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-[10px]">Access Control & Identity Hub</p>
            </div>
            <button onclick="openCreateModal()" class="px-6 py-4 bg-brand-navy text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-sm hover:bg-brand-red transition-all shadow-lg active:scale-95">
                + Add New User
            </button>
        </div>
        
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center">
            <h3 class="text-gray-400 font-black text-[10px] uppercase tracking-widest">Total Staff</h3>
            <p class="text-brand-navy text-3xl font-black mt-1">{{ $users->count() }}</p>
        </div>

        <div class="bg-brand-navy p-8 rounded-2xl shadow-lg flex flex-col justify-center relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform text-white">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </div>
            <h3 class="text-white/60 font-black text-[9px] uppercase tracking-[0.2em] relative z-10">Admin Authority</h3>
            <p class="text-white text-3xl font-black mt-1 relative z-10">ROOT</p>
        </div>
    </div>

    {{-- USER DIRECTORY TABLE --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <div class="flex gap-2">
                <button onclick="filterRole('all')" class="role-tab active-tab px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all">All</button>
                <button onclick="filterRole('hr')" class="role-tab px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all">HR</button>
                <button onclick="filterRole('supervisor')" class="role-tab px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all">Supervisors</button>
                <button onclick="filterRole('trainee')" class="role-tab px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all">Trainees</button>
            </div>
            <input type="text" id="userSearch" placeholder="Search by name or email..." class="px-4 py-2 border border-gray-200 rounded-lg text-xs focus:ring-1 focus:ring-brand-red focus:outline-none w-64">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-4">User Identity</th>
                        <th class="px-8 py-4 text-center">System Role</th>
                        <th class="px-8 py-4 text-center">Account Created</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="userTableBody">
                    @forelse($users as $user)
                    <tr class="hover:bg-brand-red/[0.01] transition-colors group user-row" data-role="{{ $user->role }}">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-brand-navy text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-brand-navy uppercase user-name">{{ $user->name }}</p>
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
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('WARNING: This will permanently delete this account and all associated profile data.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-300 hover:text-brand-red transition-colors p-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-20 text-center opacity-20">
                            <p class="text-[10px] font-black uppercase tracking-[0.5em]">No system users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CREATE USER MODAL --}}
<div id="createUserModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-brand-navy/80 backdrop-blur-sm"></div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden animate-modalZoom">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <div>
                    <h3 class="text-xs font-black text-brand-navy uppercase tracking-widest">Register New System User</h3>
                    <p class="text-[8px] font-bold text-gray-400 uppercase mt-0.5">Automated Profile Generation</p>
                </div>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-brand-red">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block ml-1">Full Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-xs font-bold text-brand-navy focus:ring-1 focus:ring-brand-red outline-none">
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block ml-1">Official Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-xs font-bold text-brand-navy focus:ring-1 focus:ring-brand-red outline-none">
                    </div>

                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest block ml-1">Assign Access Role</label>
                        <select name="role" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-xs font-black text-brand-navy uppercase tracking-widest focus:ring-1 focus:ring-brand-red outline-none cursor-pointer">
                            <option value="hr">Human Resources (HR)</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="trainee">Trainee</option>
                            <option value="admin">System Admin</option>
                        </select>
                    </div>
                </div>

                <div class="p-4 bg-red-50 rounded-lg border border-dashed border-red-200">
                    <p class="text-[8px] font-bold text-brand-red uppercase leading-relaxed text-center">
                        Default Password: <span class="font-black">password123</span><br>
                        User will be prompted to change this upon first login.
                    </p>
                </div>

                <button type="submit" class="w-full py-4 bg-brand-navy text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg hover:bg-brand-red transition-all shadow-lg active:scale-95">
                    Provision Account
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .role-tab { color: #94a3b8; border: 1px solid #f1f5f9; }
    .role-tab.active-tab { background: #001f3f; color: white; border-color: #001f3f; }
</style>

@push('scripts')
<script>
    function openCreateModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCreateModal() {
        document.getElementById('createUserModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Role Filtering Logic
    function filterRole(role) {
        const rows = document.querySelectorAll('.user-row');
        const tabs = document.querySelectorAll('.role-tab');
        
        // Update Tabs UI
        tabs.forEach(tab => {
            tab.classList.remove('active-tab');
            if(tab.innerText.toLowerCase().includes(role)) tab.classList.add('active-tab');
            if(role === 'all' && tab.innerText === 'ALL') tab.classList.add('active-tab');
        });

        // Update Rows
        rows.forEach(row => {
            if (role === 'all' || row.getAttribute('data-role') === role) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Search Logic
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