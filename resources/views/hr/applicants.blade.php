@extends('layouts.hr')

@section('header_title', 'Applicants Queue')

@section('hr_content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-end bg-white p-8 border border-gray-100 rounded-2xl shadow-sm relative overflow-hidden" data-aos="fade-down">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-red/5 rounded-bl-full"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-black text-brand-navy uppercase tracking-tighter">Application Queue</h2>
            <p class="text-brand-red font-bold mt-1 uppercase tracking-widest text-xs">Total Submissions: {{ $applicants->count() }}</p>
        </div>
        <div class="relative z-10 text-[10px] font-black text-gray-400 uppercase tracking-widest">Fibrecomm Network Sdn Bhd</div>
    </div>

    {{-- Applicants List Box --}}
    <div class="space-y-4">
        @forelse($applicants as $index => $applicant)
            <div id="applicant-row-{{ $applicant->id }}" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}" class="group relative bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 hover:border-brand-red/30 {{ !$applicant->is_read ? 'border-l-4 border-l-brand-red bg-brand-red/[0.01]' : 'border-l-4 border-l-gray-200' }}">
                
                <div class="flex items-center gap-6 relative z-10">
                    <div class="relative">
                        <div class="h-14 w-14 rounded-xl bg-brand-navy flex items-center justify-center text-white font-black text-xl uppercase shadow-lg group-hover:bg-brand-red transition-colors duration-500">{{ substr($applicant->full_name, 0, 1) }}</div>
                        @if(!$applicant->is_read)
                            <span class="unread-dot absolute -top-1 -right-1 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-red opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-brand-red border-2 border-white"></span>
                            </span>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="text-sm font-black text-brand-navy uppercase tracking-tight group-hover:text-brand-red transition-colors">{{ $applicant->full_name }}</h3>
                            @if(!$applicant->is_read)
                                <span class="badge-new text-[8px] font-black bg-brand-red text-white px-2 py-0.5 rounded-sm uppercase tracking-widest animate-pulse">New</span>
                            @endif
                        </div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">{{ $applicant->institution }} <span class="mx-2 text-gray-200">|</span> {{ $applicant->major }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 relative z-10">
                    {{-- 1. VIEW PROFILE BUTTON --}}
                    <button onclick="viewApplicant({{ $applicant->id }})" 
                            class="px-6 py-3 bg-brand-navy text-white text-[10px] font-black uppercase tracking-widest rounded-sm hover:bg-brand-red hover:shadow-lg active:scale-95 transition-all duration-300">
                        View Profile
                    </button>

                    {{-- 2. ACTION BUTTONS (MODIFIED TO USE CUSTOM MODAL) --}}
                    <div class="flex gap-2">
                        <form id="approve-form-{{ $applicant->id }}" action="{{ route('hr.applicants.approve', $applicant->id) }}" method="POST">
                            @csrf
                            <button type="button" 
                                onclick="confirmAction('approve', '{{ $applicant->id }}', '{{ $applicant->full_name }}')"
                                class="p-3 border-2 border-green-100 text-green-600 hover:border-green-500 hover:bg-green-50 transition-all rounded-sm group" title="Approve">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </button>
                        </form>
                        
                        <form id="reject-form-{{ $applicant->id }}" action="{{ route('hr.applicants.reject', $applicant->id) }}" method="POST">
                            @csrf
                            <button type="button" 
                                onclick="confirmAction('reject', '{{ $applicant->id }}', '{{ $applicant->full_name }}')"
                                class="p-3 border-2 border-orange-100 text-orange-400 hover:border-orange-500 hover:bg-orange-50 transition-all rounded-sm group" title="Reject">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </button>
                        </form>
                    </div>

                    {{-- 3. DOWNLOAD BUTTON DROPDOWN --}}
                    <div class="relative dropdown">
                        <button onclick="toggleDropdown('list-drop-{{ $applicant->id }}')" 
                                class="p-3 border-2 border-gray-100 text-gray-400 hover:border-brand-navy hover:text-brand-navy hover:bg-gray-50 transition-all rounded-sm group/btn">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </button>
                        <div id="list-drop-{{ $applicant->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-100 shadow-xl rounded-md z-50 overflow-hidden">
                            <a href="{{ route('hr.applicants.downloadForm', $applicant->id) }}" class="block px-4 py-3 text-[10px] font-black text-brand-navy uppercase hover:bg-gray-50 hover:text-brand-red border-b border-gray-50">Download Form</a>
                            <a href="{{ route('hr.applicants.downloadCV', $applicant->id) }}" class="block px-4 py-3 text-[10px] font-black text-brand-navy uppercase hover:bg-gray-50 hover:text-brand-red border-b border-gray-50">Download CV/Resume</a>
                            <a href="{{ route('hr.applicants.downloadLetter', $applicant->id) }}" class="block px-4 py-3 text-[10px] font-black text-brand-navy uppercase hover:bg-gray-50 hover:text-brand-red">University Letter</a>
                        </div>
                    </div>

                    {{-- 4. DELETE BUTTON --}}
                    <button onclick="openDeleteModal({{ $applicant->id }}, '{{ $applicant->full_name }}')" 
                             class="p-3 border-2 border-gray-100 text-gray-400 hover:border-brand-red hover:text-brand-red hover:bg-red-50 transition-all rounded-sm group/del">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-white p-20 rounded-2xl border border-dashed border-gray-200 text-center">
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.5em]">The applicant queue is empty</p>
            </div>
        @endforelse
    </div>
</div>

{{-- CUSTOM ACTION CONFIRMATION MODAL (Approve/Reject) --}}
<div id="customConfirmModal" class="fixed inset-0 z-[150] hidden bg-brand-navy/95 backdrop-blur-sm flex items-center justify-center p-4">
    <div id="confirmModalBox" class="bg-white w-full max-w-sm rounded-2xl p-8 shadow-2xl border-t-8 transition-all transform scale-95">
        <div id="confirmIcon" class="w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
            </div>
        
        <h3 id="confirmTitle" class="text-2xl font-black text-center uppercase tracking-tighter mb-2"></h3>
        <p id="confirmMessage" class="text-gray-500 text-center text-[11px] font-bold uppercase tracking-wide leading-relaxed px-4"></p>
        
        <div class="mt-8 flex flex-col gap-2">
            <button id="finalConfirmBtn" class="w-full py-4 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg shadow-lg active:scale-95 transition-all">
                Confirm & Proceed
            </button>
            <button onclick="closeConfirmModal()" class="w-full py-3 text-gray-400 text-[9px] font-black uppercase tracking-widest hover:text-brand-navy transition-colors">
                Cancel
            </button>
        </div>
    </div>
</div>

{{-- DELETE CONFIRMATION MODAL --}}
<div id="deleteModal" class="fixed inset-0 z-[110] hidden bg-brand-navy/95 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-8 shadow-2xl border-t-4 border-brand-red">
        <h3 class="text-2xl font-black text-brand-navy uppercase tracking-tighter">Confirm Deletion</h3>
        <p class="text-gray-500 mt-2 text-xs leading-relaxed">You are about to remove <span id="deleteName" class="font-bold text-brand-red"></span>. This action is permanent.</p>
        
        <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" id="safetyCheck" onchange="toggleDeleteBtn()" class="w-5 h-5 rounded border-gray-300 text-brand-red focus:ring-brand-red">
                <span class="text-[10px] font-black text-brand-navy uppercase tracking-wider">I understand and want to delete this applicant</span>
            </label>
        </div>

        <div class="mt-8 flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:bg-gray-100 rounded-lg transition-all">Cancel</button>
            <form id="deleteForm" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" id="finalDeleteBtn" disabled 
                        class="w-full px-6 py-4 bg-gray-200 text-white text-[10px] font-black uppercase tracking-widest rounded-lg transition-all cursor-not-allowed">
                    Delete Applicant
                </button>
            </form>
        </div>
    </div>
</div>

{{-- VIEW MODAL --}}
<div id="viewModal" class="fixed inset-0 z-[100] hidden bg-brand-navy/90 backdrop-blur-md flex items-center justify-center p-4">
    <div class="modal-content bg-white w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl overflow-hidden relative flex flex-col">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white sticky top-0">
            <div>
                <h2 id="modalName" class="text-3xl font-black text-brand-navy uppercase tracking-tighter"></h2>
                <p class="text-[10px] font-black text-brand-red uppercase tracking-[0.2em]">Detailed Application Profile</p>
            </div>
            <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-full transition-colors group">
                <svg class="w-8 h-8 text-gray-300 group-hover:text-brand-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </button>
        </div>
        
        <div id="modalBody" class="p-10 overflow-y-auto custom-scrollbar flex-grow bg-gray-50/30"></div>
        
        <div class="p-6 border-t border-gray-100 bg-white flex justify-end items-center gap-4">
            <button onclick="closeModal()" class="px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-brand-navy transition-colors">Close Review</button>
            <div class="relative dropdown">
                <button onclick="toggleDropdown('modalDownloadDrop')" class="px-8 py-3 bg-brand-red text-white text-[10px] font-black uppercase tracking-widest rounded-sm shadow-lg hover:bg-brand-navy transition-all flex items-center gap-2">
                    Download Options
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </button>
                <div id="modalDownloadDrop" class="hidden absolute right-0 bottom-full mb-2 w-56 bg-white border border-gray-100 shadow-2xl rounded-md overflow-hidden">
                    <a id="dropForm" href="#" class="block px-4 py-4 text-[10px] font-black text-brand-navy uppercase hover:bg-gray-50 hover:text-brand-red border-b border-gray-50">Applicant Form (PDF)</a>
                    <a id="dropCV" href="#" class="block px-4 py-4 text-[10px] font-black text-brand-navy uppercase hover:bg-gray-50 hover:text-brand-red border-b border-gray-50">Curriculum Vitae/Resume</a>
                    <a id="dropLetter" href="#" class="block px-4 py-4 text-[10px] font-black text-brand-navy uppercase hover:bg-gray-50 hover:text-brand-red">University Letter</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let activeFormId = null;

    function confirmAction(type, id, name) {
        const modal = document.getElementById('customConfirmModal');
        const box = document.getElementById('confirmModalBox');
        const iconContainer = document.getElementById('confirmIcon');
        const title = document.getElementById('confirmTitle');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('finalConfirmBtn');

        activeFormId = `${type}-form-${id}`;
        
        // Reset Modal
        modal.classList.remove('hidden');
        setTimeout(() => box.classList.remove('scale-95'), 10);

        if (type === 'approve') {
            box.style.borderTopColor = '#10B981'; // Green
            iconContainer.className = "w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto bg-green-50 text-green-500";
            iconContainer.innerHTML = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
            title.innerText = 'Approve Applicant?';
            title.className = 'text-2xl font-black text-center uppercase tracking-tighter mb-2 text-green-600';
            message.innerText = `You are approving ${name}. They will be moved to the onboarding queue.`;
            confirmBtn.className = 'w-full py-4 bg-green-500 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg shadow-lg hover:bg-green-600 active:scale-95 transition-all';
        } else {
            box.style.borderTopColor = '#F97316'; // Orange
            iconContainer.className = "w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto bg-orange-50 text-orange-500";
            iconContainer.innerHTML = '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
            title.innerText = 'Reject Applicant?';
            title.className = 'text-2xl font-black text-center uppercase tracking-tighter mb-2 text-orange-500';
            message.innerText = `Are you sure you want to reject ${name}? This action will decline their application.`;
            confirmBtn.className = 'w-full py-4 bg-orange-500 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-lg shadow-lg hover:bg-orange-600 active:scale-95 transition-all';
        }

        confirmBtn.onclick = function() {
            if (activeFormId) {
                document.getElementById(activeFormId).submit();
            }
        };
    }

    function closeConfirmModal() {
        const modal = document.getElementById('customConfirmModal');
        const box = document.getElementById('confirmModalBox');
        box.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 200);
        activeFormId = null;
    }

    // Reuse existing toggleDropdown logic
    function toggleDropdown(id) {
        document.querySelectorAll('.dropdown div[id]').forEach(el => {
            if (el.id !== id) el.classList.add('hidden');
        });
        const element = document.getElementById(id);
        if (element) element.classList.toggle('hidden');
    }

    // Reuse Delete Modal logic
    function openDeleteModal(id, name) {
        document.getElementById('deleteName').innerText = name;
        document.getElementById('deleteForm').action = `/hr/applicants/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('safetyCheck').checked = false;
        toggleDeleteBtn();
    }

    function closeDeleteModal() { document.getElementById('deleteModal').classList.add('hidden'); }

    function toggleDeleteBtn() {
        const checkbox = document.getElementById('safetyCheck');
        const btn = document.getElementById('finalDeleteBtn');
        if(checkbox && checkbox.checked) {
            btn.disabled = false;
            btn.classList.remove('bg-gray-200', 'cursor-not-allowed');
            btn.classList.add('bg-brand-red', 'hover:bg-brand-navy', 'shadow-lg');
        } else {
            btn.disabled = true;
            btn.classList.add('bg-gray-200', 'cursor-not-allowed');
            btn.classList.remove('bg-brand-red', 'hover:bg-brand-navy', 'shadow-lg');
        }
    }

    function viewApplicant(id) {
        document.getElementById('modalBody').innerHTML = '<p class="text-center font-black text-gray-400 uppercase tracking-widest">Loading Profile...</p>';
        document.getElementById('viewModal').classList.remove('hidden');

        fetch(`/hr/applicants/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalName').innerText = data.full_name;
                document.getElementById('dropForm').href = `/hr/applicants/download-form/${id}`;
                document.getElementById('dropCV').href = `/hr/applicants/download-cv/${id}`;
                document.getElementById('dropLetter').href = `/hr/applicants/download-letter/${id}`;
                
                document.getElementById('modalBody').innerHTML = `
                    <div class="grid grid-cols-2 gap-x-12 gap-y-8">
                        <div class="col-span-2 border-b border-gray-100 pb-2 mb-2"><h4 class="text-[11px] font-black text-brand-red uppercase tracking-[0.2em]">Personal Information</h4></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Full Name</p><p class="font-bold text-brand-navy">${data.full_name}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Email Address</p><p class="font-bold text-brand-navy">${data.email}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Phone Number</p><p class="font-bold text-brand-navy">${data.phone}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Permanent Address</p><p class="font-bold text-brand-navy text-xs leading-relaxed">${data.address}</p></div>
                        <div class="col-span-2 border-b border-gray-100 pb-2 mt-4 mb-2"><h4 class="text-[11px] font-black text-brand-red uppercase tracking-[0.2em]">Academic Records</h4></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">University / Institution</p><p class="font-bold text-brand-navy uppercase">${data.institution}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Course of Study</p><p class="font-bold text-brand-navy uppercase">${data.major}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Study Level</p><p class="font-bold text-brand-navy uppercase">${data.study_level}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Expected Graduation</p><p class="font-bold text-brand-navy uppercase">${data.grad_date || 'N/A'}</p></div>
                        <div class="col-span-2 border-b border-gray-100 pb-2 mt-4 mb-2"><h4 class="text-[11px] font-black text-brand-red uppercase tracking-[0.2em]">Internship Details</h4></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Proposed Start Date</p><p class="font-bold text-brand-navy uppercase">${data.start_date}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Expected End Date</p><p class="font-bold text-brand-navy uppercase">${data.expected_end_date || 'N/A'}</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Internship Duration</p><p class="font-bold text-brand-navy uppercase">${data.duration} Months</p></div>
                        <div class="space-y-1"><p class="text-[9px] font-black text-gray-400 uppercase">Area of Interest</p><p class="font-bold text-brand-navy uppercase">${data.interest}</p></div>
                    </div>
                `;
            });
    }

    function closeModal() { document.getElementById('viewModal').classList.add('hidden'); }
</script>
@endpush
@endsection