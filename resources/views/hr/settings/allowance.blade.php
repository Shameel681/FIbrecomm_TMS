@extends('layouts.hr')

@section('header_title', 'Allowance Settings')

@section('hr_content')
<div class="max-w-xl mx-auto space-y-6" data-aos="fade-up" data-aos-duration="800">
    <div class="bg-white p-8 border border-gray-200 rounded-2xl shadow-sm">
        <h2 class="text-2xl font-black text-brand-navy uppercase tracking-tighter mb-1">
            Allowance Settings
        </h2>
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">
            Global rate per approved working day
        </p>

        @if(session('success'))
            <div class="mb-4 px-4 py-2 rounded-md bg-green-50 border border-green-200 text-[11px] text-green-800 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 px-4 py-2 rounded-md bg-red-50 border border-red-200 text-[11px] text-red-800 font-semibold">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('hr.settings.allowance.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-1">
                    Allowance Rate Per Approved Working Day (RM)
                </label>
                <input
                    type="number"
                    name="rate"
                    value="{{ old('rate', $rate) }}"
                    step="0.01"
                    min="0"
                    class="w-full rounded-md border-gray-300 text-sm focus:border-brand-navy focus:ring-brand-navy"
                >
                <p class="mt-1 text-[10px] text-gray-400">
                    This rate will be used for all monthly attendance PDFs (trainee, supervisor, and HR views).
                </p>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-5 py-2 bg-brand-navy text-white rounded-lg text-[11px] font-black uppercase tracking-[0.2em] hover:bg-brand-red transition"
                >
                    Save Rate
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

