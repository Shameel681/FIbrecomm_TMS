@extends('layouts.admin')

@section('header_title', 'Root Authority: Profile Settings')

@section('admin_content')
<div class="max-w-4xl mx-auto space-y-8" data-aos="fade-up">

    {{-- SYSTEM ALERTS --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center" role="alert">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center" role="alert">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
        </div>
    @endif

    {{-- PROFILE HEADER --}}
    <div class="flex items-center gap-6 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-brand-red">
        <div class="h-24 w-24 bg-brand-navy rounded-2xl flex items-center justify-center text-white text-4xl font-black shadow-lg border-b-4 border-brand-red">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div>
            <h2 class="text-2xl font-black text-brand-navy uppercase tracking-tighter">System Administrator</h2>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-[0.2em]">{{ Auth::user()->email }}</p>
            <div class="mt-2 flex gap-2">
                <span class="px-3 py-1 bg-brand-red/10 text-brand-red text-[9px] font-black uppercase rounded-full">Root Access</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[9px] font-black uppercase rounded-full">Active Session</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        {{-- ACCOUNT INFORMATION --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-sm font-black text-brand-navy uppercase tracking-widest">Identity Details</h3>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST" class="p-8 space-y-5">
                @csrf
                @method('PUT')
                
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Administrator Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">System Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all">
                </div>

                <button type="submit" class="w-full bg-brand-navy text-white py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg hover:bg-brand-red transition-all transform hover:-translate-y-1">
                    Update Identity
                </button>
            </form>
        </div>

        {{-- SECURITY / PASSWORD --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-sm font-black text-brand-navy uppercase tracking-widest">Security Protocol</h3>
            </div>
            <form action="{{ route('admin.profile.password') }}" method="POST" class="p-8 space-y-5">
                @csrf
                @method('PUT')
                
                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Current Password</label>
                    <input type="password" name="current_password" required 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all">
                    @error('current_password') <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">New System Password</label>
                    <input type="password" name="password" required 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all">
                    @error('password') <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Confirm New Password</label>
                    <input type="password" name="password_confirmation" required 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all">
                </div>

                <button type="submit" class="w-full bg-white border-2 border-brand-navy text-brand-navy py-4 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-brand-navy hover:text-white transition-all transform hover:-translate-y-1">
                    Rotate Security Key
                </button>
            </form>
        </div>

    </div>

    {{-- SYSTEM LOCKDOWN --}}
    <div class="bg-red-50 rounded-2xl border border-red-100 p-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-red-700 font-black text-[11px] uppercase tracking-widest">System Lockdown</h4>
                    <p class="text-red-600/60 text-[9px] font-bold uppercase tracking-widest">Terminate ALL active sessions across all devices</p>
                </div>
            </div>

            {{-- Verification Form --}}
            <form action="{{ route('admin.emergency.exit') }}" method="POST" class="flex flex-col md:flex-row items-start gap-3">
                @csrf
                
                {{-- Input Wrapper --}}
                <div class="flex flex-col gap-1 w-full md:w-auto">
                    <input type="password" name="current_password" placeholder="VERIFY PASSWORD..." required 
                        class="px-4 py-3 bg-white border border-red-200 rounded-xl text-[10px] font-black uppercase outline-none focus:border-red-500 transition-all w-full md:w-48 shadow-sm">
                    
                    {{-- THE MISSING ERROR MESSAGE --}}
                    @error('current_password')
                        <span class="text-red-600 font-bold text-[9px] uppercase tracking-widest pl-1">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <button type="submit" onclick="return confirm('CRITICAL: This will log you out of EVERY device. Proceed?')" 
                    class="w-full md:w-auto bg-red-600 text-white px-8 py-3.5 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg active:scale-95 whitespace-nowrap">
                    Confirm Lockdown
                </button>
            </form>
        </div>
    </div>
</div>
@endsection