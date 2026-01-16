@extends('layouts.admin')

@section('header_title', 'Core Authority: Manage HR')

@section('admin_content')
<div class="space-y-8">

    {{-- STATS & ACTIONS --}}
    <div class="flex flex-col md:flex-row gap-6 items-end justify-between">
        <div class="bg-white px-8 py-6 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-brand-red min-w-[250px]" data-aos="fade-right">
            <h3 class="text-gray-400 font-black text-[10px] uppercase tracking-widest">Total HR Officers</h3>
            <p class="text-brand-navy text-4xl font-black mt-1">{{ $hrs->count() }}</p>
        </div>

        <button onclick="document.getElementById('addHrModal').classList.remove('hidden')" 
                class="bg-brand-navy text-white px-8 py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl hover:bg-brand-red transition-all transform hover:-translate-y-1 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Add New HR Officer
        </button>
    </div>

    {{-- HR REGISTRY TABLE --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-black text-brand-navy uppercase tracking-tighter">HR Personnel Registry</h2>
                <p class="text-gray-400 font-bold text-[9px] uppercase tracking-widest">Authorized Management Access Only</p>
            </div>
            
            {{-- SEARCH FIELD --}}
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="hrSearchInput" onkeyup="filterHrTable()" 
                    placeholder="SEARCH NAME, ID, OR EMAIL..." 
                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl outline-none font-bold text-[10px] uppercase tracking-widest focus:border-brand-red transition-all shadow-sm">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="hrRegistryTable">
                <thead>
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-4">Officer Identity</th>
                        <th class="px-8 py-4 text-center">Employee ID</th>
                        <th class="px-8 py-4 text-center">System Email</th>
                        <th class="px-8 py-4 text-center">Onboarded</th>
                        <th class="px-8 py-4 text-right">Operational Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($hrs as $hr)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-brand-navy text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                    {{ strtoupper(substr($hr->name, 0, 1)) }}
                                </div>
                                <div class="text-sm font-black text-brand-navy uppercase">
                                    {{ $hr->name }}
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center text-[11px] font-bold text-brand-red uppercase">
                            {{ $hr->hrProfile->employee_id ?? 'N/A' }}
                        </td>
                        <td class="px-8 py-5 text-center text-[11px] font-bold text-gray-500 lowercase">
                            {{ $hr->email }}
                        </td>
                        <td class="px-8 py-5 text-center text-[10px] font-bold text-gray-400">{{ $hr->created_at->format('d M Y') }}</td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end gap-2 items-center">
                                <button onclick="openViewModal({{ json_encode($hr->load('hrProfile')) }})" title="View Details" class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                
                                <button onclick="openEditModal({{ json_encode($hr->load('hrProfile')) }})" title="Modify Account" class="p-2 hover:bg-gray-100 text-brand-navy rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <form action="{{ route('admin.hr.destroy', $hr->id) }}" method="POST" onsubmit="return confirm('CRITICAL: Permanent deletion of HR account. Proceed?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-50 text-brand-red rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center opacity-20 italic">No HR Personnel detected in system.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL: ADD HR --}}
<div id="addHrModal" class="fixed inset-0 z-[100] hidden bg-brand-navy/90 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-brand-navy p-6 text-white flex justify-between items-center">
            <h3 class="font-black uppercase tracking-widest text-sm text-white">Register HR Officer</h3>
            <button onclick="document.getElementById('addHrModal').classList.add('hidden')" class="text-white/50 hover:text-white">&times;</button>
        </div>
        <form action="{{ route('admin.hr.store') }}" method="POST" class="p-8 space-y-5">
            @csrf
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Employee ID</label>
                <input type="text" name="employee_id" required placeholder="e.g. HR-2024-001" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm uppercase">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Full Name</label>
                <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm uppercase">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <button type="submit" class="w-full bg-brand-red text-white py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg hover:bg-brand-navy transition-all">
                Confirm Deployment
            </button>
        </form>
    </div>
</div>

{{-- MODAL: VIEW HR --}}
<div id="viewHrModal" class="fixed inset-0 z-[100] hidden bg-brand-navy/90 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-gray-50 p-6 border-b flex justify-between items-center">
            <h3 class="font-black uppercase tracking-widest text-sm text-brand-navy">Officer Profile</h3>
            <button onclick="closeModal('viewHrModal')" class="text-gray-400 hover:text-brand-navy">&times;</button>
        </div>
        <div class="p-8 space-y-4">
            <div>
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Employee ID</label>
                <p id="view_employee_id" class="text-brand-red font-black text-lg uppercase"></p>
            </div>
            <div>
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Full Name</label>
                <p id="view_name" class="text-brand-navy font-bold text-lg uppercase"></p>
            </div>
            <div>
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Email Address</label>
                <p id="view_email" class="text-brand-navy font-bold"></p>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: EDIT HR --}}
<div id="editHrModal" class="fixed inset-0 z-[100] hidden bg-brand-navy/90 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-brand-navy p-6 text-white flex justify-between items-center">
            <h3 class="font-black uppercase tracking-widest text-sm text-white">Modify HR Records</h3>
            <button onclick="closeModal('editHrModal')" class="text-white/50 hover:text-white">&times;</button>
        </div>
        <form id="editHrForm" method="POST" class="p-8 space-y-5">
            @csrf @method('PUT')
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Employee ID</label>
                <input type="text" name="employee_id" id="edit_employee_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm uppercase">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Full Name</label>
                <input type="text" name="name" id="edit_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm uppercase">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Email Address</label>
                <input type="email" name="email" id="edit_email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">New Password (Optional)</label>
                <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <button type="submit" class="w-full bg-brand-red text-white py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg hover:bg-brand-navy transition-all">
                Update Records
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // --- UI HELPERS ---
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // --- SEARCH LOGIC ---
    function filterHrTable() {
        const input = document.getElementById("hrSearchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("hrRegistryTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            if (tr[i].cells.length < 5) continue;
            const nameColumn = tr[i].getElementsByTagName("td")[0];
            const idColumn = tr[i].getElementsByTagName("td")[1];
            const emailColumn = tr[i].getElementsByTagName("td")[2];

            if (nameColumn || idColumn || emailColumn) {
                const nameText = nameColumn.textContent || nameColumn.innerText;
                const idText = idColumn.textContent || idColumn.innerText;
                const emailText = emailColumn.textContent || emailColumn.innerText;

                if (nameText.toUpperCase().indexOf(filter) > -1 || 
                    idText.toUpperCase().indexOf(filter) > -1 || 
                    emailText.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // --- MODAL POPULATION ---
    function openViewModal(user) {
        document.getElementById('view_name').innerText = user.name;
        document.getElementById('view_email').innerText = user.email;
        document.getElementById('view_employee_id').innerText = user.hr_profile ? user.hr_profile.employee_id : 'N/A';
        document.getElementById('viewHrModal').classList.remove('hidden');
    }

    function openEditModal(user) {
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        if(user.hr_profile) document.getElementById('edit_employee_id').value = user.hr_profile.employee_id || '';
        document.getElementById('editHrForm').action = `/admin/hr/update/${user.id}`;
        document.getElementById('editHrModal').classList.remove('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('bg-brand-navy/90')) {
            event.target.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection