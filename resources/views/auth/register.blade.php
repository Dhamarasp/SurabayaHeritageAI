@extends('layouts.auth', ['title' => 'Register'])

@section('content')
<div class="bg-white rounded-lg shadow-xl p-8">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Daftar di SurabayaAI</h2>
        <p class="text-gray-600 mt-2">Buat akun untuk menjelajahi sejarah Surabaya</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input placeholder="Masukkan Nama" type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input placeholder="Masukkan Email" type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input placeholder="Masukkan Password" type="password" name="password" id="password" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input placeholder="Ulangi Password" type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
        </div>

        <div class="mb-6">
            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Daftar
            </button>
        </div>

        <div class="text-center text-sm">
            <p class="text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login</a></p>
        </div>
    </form>
</div>
@endsection
