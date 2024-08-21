@extends('layouts.error')

@section('title', 'Akses Ditolak')

@section('content')
	<div class="flex min-h-screen items-center justify-center bg-gray-100">
		<div class="text-center">
			<img src="{{ asset('images/illustration1.png') }}" alt="Forbidden" class="mx-auto mb-4 h-40 w-auto">
			<h1 class="mb-2 text-4xl font-bold text-gray-800">Akses Ditolak</h1>
			<p class="mb-4 text-lg text-gray-600">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
			<a href="{{ route('home.index') }}" class="inline-block rounded-lg bg-color-primary-500 px-6 py-3 text-white hover:bg-color-primary-600">Kembali Ke Beranda</a>
		</div>
	</div>
@endsection
