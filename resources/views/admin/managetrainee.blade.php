@extends('layouts.admin')

@section('header_title', 'Core Authority: Manage Trainees')

@section('admin_content')
<div class="space-y-8">

    {{-- STATS & ACTIONS --}}
    <div class="flex flex-col md:flex-row gap-6 items-end justify-between">
        <div class="bg-white px-8 py-6 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-brand-red min-w-[250px]" data-aos="fade-right">
            <h3 class="text-gray-400 font-black text-[10px] uppercase tracking-widest">Total Active Trainees</h3>
            <p class="text-brand-navy text-4xl font-black mt-1">{{ $trainees->count() }}</p>
        </div>

        <button onclick="document.getElementById('addTraineeModal').classList.remove('hidden')" 
                class="bg-brand-navy text-white px-8 py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl hover:bg-brand-red transition-all transform hover:-translate-y-1 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                Deploy New Trainee
        </button>
    </div>

    {{-- TRAINEE REGISTRY TABLE --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-black text-brand-navy uppercase tracking-tighter">Trainee Personnel Registry</h2>
                <p class="text-gray-400 font-bold text-[9px] uppercase tracking-widest">Operational Management Access</p>
            </div>
            
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="traineeSearchInput" onkeyup="filterTraineeTable()" 
                    placeholder="SEARCH TRAINEE NAME OR EMAIL..." 
                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl outline-none font-bold text-[10px] uppercase tracking-widest focus:border-brand-red transition-all shadow-sm">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="traineeRegistryTable">
                <thead>
                    <tr class="text-[9px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-4">Trainee Identity</th>
                        <th class="px-8 py-4 text-center">Duration</th>
                        <th class="px-8 py-4 text-center">Status</th>
                        <th class="px-8 py-4 text-center">System Email</th>
                        <th class="px-8 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($trainees as $trainee)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-brand-navy text-white flex items-center justify-center font-black rounded-lg text-sm group-hover:bg-brand-red transition-colors">
                                    {{ strtoupper(substr($trainee->name, 0, 1)) }}
                                </div>
                                <div class="text-sm font-black text-brand-navy uppercase">
                                    {{ $trainee->name }}
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <p class="text-[10px] font-black text-gray-600 uppercase">{{ \Carbon\Carbon::parse($trainee->start_date)->format('d M Y') }}</p>
                            <p class="text-[9px] font-bold text-gray-400">TO</p>
                            <p class="text-[10px] font-black text-brand-red uppercase">{{ \Carbon\Carbon::parse($trainee->end_date)->format('d M Y') }}</p>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter {{ $trainee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $trainee->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center text-[11px] font-bold text-gray-500 lowercase">
                            {{ $trainee->email }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end gap-2 items-center">
                                {{-- Preview Button --}}
                                <button onclick="openViewModal(@js($trainee))" class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                
                                {{-- Edit Button --}}
                                <button onclick="openEditModal(@js($trainee))" class="p-2 hover:bg-gray-100 text-brand-navy rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                {{-- Delete Form --}}
                                <form action="{{ route('admin.trainee.destroy', $trainee->id) }}" method="POST" onsubmit="return confirm('WARNING: Terminate trainee record?')">
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
                        <td colspan="5" class="p-20 text-center opacity-20 italic font-black uppercase tracking-widest text-xs">Zero Trainee Assets Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL: ADD TRAINEE --}}
<div id="addTraineeModal" class="fixed inset-0 z-[100] hidden bg-brand-navy/90 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-brand-navy p-6 text-white flex justify-between items-center">
            <h3 class="font-black uppercase tracking-widest text-sm text-white">New Trainee Deployment</h3>
            <button onclick="closeModal('addTraineeModal')" class="text-white/50 hover:text-white">&times;</button>
        </div>
        <form action="{{ route('admin.trainee.store') }}" method="POST" class="p-8 grid grid-cols-2 gap-5">
            @csrf
            <div class="col-span-2 space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Full Name</label>
                <input type="text" name="name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm uppercase">
            </div>
            <div class="col-span-2 space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Start Date</label>
                <input type="date" name="start_date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">End Date</label>
                <input type="date" name="end_date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="col-span-2 space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Temporary Access Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <button type="submit" class="col-span-2 bg-brand-red text-white py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg hover:bg-brand-navy transition-all">
                Authorize Onboarding
            </button>
        </form>
    </div>
</div>

{{-- MODAL: VIEW TRAINEE --}}
<div id="viewTraineeModal" class="fixed inset-0 z-[100] hidden bg-brand-navy/90 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl overflow-hidden shadow-2xl border-t-4 border-brand-red">
        <div class="p-8">
            <div class="flex flex-col items-center text-center mb-6">
                <div id="view_initial" class="h-20 w-20 bg-brand-navy text-white flex items-center justify-center font-black rounded-2xl text-3xl mb-4 shadow-lg"></div>
                <h3 id="view_name" class="text-xl font-black text-brand-navy uppercase tracking-tighter"></h3>
                <p id="view_status_badge" class="mt-2 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"></p>
            </div>

            <div class="space-y-4 border-t border-gray-50 pt-6">
                <div class="flex justify-between items-center text-[11px]">
                    <span class="font-black text-gray-400 uppercase tracking-widest">System Email</span>
                    <span id="view_email" class="font-bold text-brand-navy"></span>
                </div>
                <div class="flex justify-between items-center text-[11px]">
                    <span class="font-black text-gray-400 uppercase tracking-widest">Report Duty Date</span>
                    <span id="view_start" class="font-bold text-brand-navy"></span>
                </div>
                <div class="flex justify-between items-center text-[11px]">
                    <span class="font-black text-gray-400 uppercase tracking-widest">Internship Completion Date</span>
                    <span id="view_end" class="font-bold text-brand-red"></span>
                </div>
            </div>

            <button onclick="closeModal('viewTraineeModal')" 
                    class="mt-8 w-full bg-gray-100 text-gray-500 py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-brand-navy hover:text-white transition-all">
                Close
            </button>
        </div>
    </div>
</div>

{{-- MODAL: EDIT TRAINEE --}}
<div id="editTraineeModal" class="fixed inset-0 z-[100] hidden bg-brand-navy/90 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-brand-navy p-6 text-white flex justify-between items-center">
            <h3 class="font-black uppercase tracking-widest text-sm text-white">Modify Trainee Records</h3>
            <button onclick="closeModal('editTraineeModal')" class="text-white/50 hover:text-white">&times;</button>
        </div>
        <form id="editTraineeForm" method="POST" class="p-8 grid grid-cols-2 gap-5">
            @csrf @method('PUT')
            <div class="col-span-2 space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Full Name</label>
                <input type="text" name="name" id="edit_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm uppercase">
            </div>
            <div class="col-span-2 space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Email Address</label>
                <input type="email" name="email" id="edit_email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Start Date</label>
                <input type="date" name="start_date" id="edit_start_date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">End Date</label>
                <input type="date" name="end_date" id="edit_end_date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm">
            </div>
            <div class="col-span-2 space-y-1">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Status Update</label>
                <select name="status" id="edit_status" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl outline-none font-bold text-sm uppercase">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <button type="submit" class="col-span-2 bg-brand-red text-white py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg hover:bg-brand-navy transition-all">
                Update Personnel File
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Universal Close
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Search Filtering
    function filterTraineeTable() {
        const input = document.getElementById("traineeSearchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("traineeRegistryTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            const nameColumn = tr[i].getElementsByTagName("td")[0];
            const emailColumn = tr[i].getElementsByTagName("td")[3];

            if (nameColumn || emailColumn) {
                const nameText = nameColumn.textContent || nameColumn.innerText;
                const emailText = emailColumn.textContent || emailColumn.innerText;

                if (nameText.toUpperCase().indexOf(filter) > -1 || emailText.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Open View Modal
    function openViewModal(trainee) {
        document.getElementById('view_name').innerText = trainee.name;
        document.getElementById('view_email').innerText = trainee.email;
        document.getElementById('view_start').innerText = trainee.start_date;
        document.getElementById('view_end').innerText = trainee.end_date;
        document.getElementById('view_initial').innerText = trainee.name.charAt(0).toUpperCase();
        
        const badge = document.getElementById('view_status_badge');
        badge.innerText = trainee.status;
        if(trainee.status === 'active') {
            badge.className = "mt-2 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700";
        } else {
            badge.className = "mt-2 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-600";
        }

        document.getElementById('viewTraineeModal').classList.remove('hidden');
    }

    // Open Edit Modal
    function openEditModal(trainee) {
        document.getElementById('edit_name').value = trainee.name;
        document.getElementById('edit_email').value = trainee.email;
        document.getElementById('edit_start_date').value = trainee.start_date;
        document.getElementById('edit_end_date').value = trainee.end_date;
        document.getElementById('edit_status').value = trainee.status;
        
        const updateUrl = "{{ route('admin.trainee.update', ':id') }}";
        document.getElementById('editTraineeForm').action = updateUrl.replace(':id', trainee.id);
        document.getElementById('editTraineeModal').classList.remove('hidden');
    }

    // Backdrop Click to Close
    window.onclick = function(event) {
        if (event.target.classList.contains('bg-brand-navy/90')) {
            event.target.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection