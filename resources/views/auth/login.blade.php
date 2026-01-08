@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="w-full max-w-md p-8 bg-white border border-gray-200 rounded-2xl shadow-xl">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">System Login</h2>
            <p class="text-gray-500 mt-2">Enter your credentials to access your dashboard</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700">Email Address</label>
                <input type="email" name="email" required autofocus
                    class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200"
                    placeholder="name@fibrecomm.com">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition duration-200"
                    placeholder="••••••••">
            </div>

            <button type="submit" 
                class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform active:scale-[0.98]">
                Login to Dashboard
            </button>
        </form>
    </div>
</div>
@endsection