@extends('layouts.supervisor')

@section('header_title', 'Manage Profile')

@section('supervisor_content')
<div class="max-w-4xl mx-auto space-y-8" data-aos="fade-up">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('error') }}</p>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
        </div>
    @endif

    {{-- Profile header --}}
    <div class="flex items-center gap-6 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-brand-red">
        <div class="h-20 w-20 bg-brand-navy rounded-2xl flex items-center justify-center text-white text-3xl font-black shadow-lg border-b-4 border-brand-red">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <h2 class="text-2xl font-black text-brand-navy uppercase tracking-tighter">Supervisor Profile</h2>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-[0.2em]">{{ $user->email }}</p>
            <div class="mt-2 flex gap-2">
                <span class="px-3 py-1 bg-brand-red/10 text-brand-red text-[9px] font-black uppercase rounded-full">Active</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[9px] font-black uppercase rounded-full">Trainee Supervisor</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Identity details --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-sm font-black text-brand-navy uppercase tracking-widest">Identity Details</h3>
            </div>
            <form action="{{ route('supervisor.profile.update') }}" method="POST" class="p-8 space-y-5">
                @csrf
                @method('PUT')

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Full Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                    >
                    @error('name')
                        <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                    >
                    @error('email')
                        <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-brand-navy text-white py-3.5 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg hover:bg-brand-red transition-all transform hover:-translate-y-0.5"
                >
                    Update Profile
                </button>
            </form>
        </div>

        {{-- Password --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-sm font-black text-brand-navy uppercase tracking-widest">Change Password</h3>
            </div>
            <form action="{{ route('supervisor.profile.password') }}" method="POST" class="p-8 space-y-5">
                @csrf
                @method('PUT')

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Current Password</label>
                    <input
                        type="password"
                        name="current_password"
                        required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                    >
                    @error('current_password')
                        <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">New Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                    >
                    @error('password')
                        <p class="text-red-500 text-[9px] font-black uppercase">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Confirm New Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none font-bold text-sm focus:border-brand-red transition-all"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-white border-2 border-brand-navy text-brand-navy py-3.5 rounded-xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-brand-navy hover:text-white transition-all transform hover:-translate-y-0.5"
                >
                    Update Password
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

