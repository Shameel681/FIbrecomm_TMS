{{-- Tell this file to use the layout we just made --}}
@extends('layouts.app')

{{-- Put this content into the 'main_content' hole --}}
@section('main_content')
    
    {{-- Hero Image --}}
    <div class="w-full">
        <img 
            src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&h=450&fit=crop" 
            alt="Professional team" 
            class="w-full h-[450px] object-cover block"
        >
    </div>

    {{-- Feature Cards Section --}}
    <div class="w-full bg-gray-50 py-16 px-10"> 
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-brand-navy">Our Portals</h2>
            <p class="text-gray-500">Select your category to begin</p>
        </div>

        <main class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Intern Card --}}
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center">
                <div class="mb-5 text-brand-navy">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM3.89 9L12 4.57 20.11 9 12 13.43 3.89 9z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-navy mb-3">For Interns</h3>
                <p class="text-sm text-gray-500 mb-8">Access training modules and logs.</p>
                <button class="mt-auto bg-brand-red text-white px-10 py-2 rounded font-bold uppercase text-xs tracking-widest">Enter Now</button>
            </div>

            {{-- Supervisor Card --}}
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center">
                <div class="mb-5 text-brand-navy">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-navy mb-3">Supervisors</h3>
                <p class="text-sm text-gray-500 mb-8">Review and approve trainee reports.</p>
                <button class="mt-auto bg-brand-red text-white px-10 py-2 rounded font-bold uppercase text-xs tracking-widest">Enter Now</button>
            </div>

            {{-- HR Card --}}
            <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm text-center flex flex-col items-center">
                <div class="mb-5 text-brand-navy">
                    <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5zm7.43-2.53l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-brand-navy mb-3">HR Personnel</h3>
                <p class="text-sm text-gray-500 mb-8">Manage trainee records and data.</p>
                <button class="mt-auto bg-brand-red text-white px-10 py-2 rounded font-bold uppercase text-xs tracking-widest">Enter Now</button>
            </div>
        </main>
    </div>

@endsection