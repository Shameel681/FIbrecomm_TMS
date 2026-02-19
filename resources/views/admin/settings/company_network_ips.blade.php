@extends('layouts.admin')

@section('header_title', 'Auto-approve clock-in IPs')

@section('admin_content')
<div class="space-y-8" data-aos="fade-up">

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex justify-between items-center">
            <p class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 font-bold text-lg leading-none">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
            <ul class="text-[10px] font-black text-red-700 uppercase tracking-widest list-disc list-inside">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden max-w-2xl">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-black text-brand-navy uppercase tracking-tighter">Company network IPs (auto-approve clock-in)</h2>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">
                Only admin can change these. Trainee clock-in from these IPs is auto-approved; others need supervisor approval.
            </p>
        </div>
        <form method="POST" action="{{ route('admin.settings.companyNetworkIps.update') }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
                    Allowed IPs or prefixes (comma-separated)
                </label>
                <textarea
                    name="ips"
                    rows="4"
                    maxlength="500"
                    placeholder="e.g. 203.201.184., 192.168.1., 127.0.0.1"
                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl outline-none font-mono text-sm focus:border-brand-navy focus:bg-white transition-all resize-none"
                >{{ old('ips', $companyClockInIps ?? '') }}</textarea>
                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest">
                    Use full IP (e.g. 203.201.184.38) or prefix with dot (e.g. 203.201.184.) to match a range. Leave empty to require supervisor approval for all clock-ins.
                </p>
            </div>
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="px-8 py-3 bg-brand-navy text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-brand-red transition shadow-lg">
                    Save IPs
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-8 py-3 border-2 border-gray-200 text-gray-500 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-50 transition">
                    Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
