@extends('layouts.app', [
    'title' => 'Login',
])
@section('content')
	<div class="flex h-screen w-full items-center">
		<section class="hidden h-full w-full flex-[3] items-center justify-center bg-color-primary-100 lg:flex">
			<div class="relative">
				<img src="{{ asset('images/illustration1.png') }}" alt="Illustration" class="w-full">
				<div class="absolute -left-24 -top-16 max-w-xs rounded-lg rounded-br-none bg-white p-4">
					<p class="text-sm font-medium">Bantu isi survei ini ya??</p>
				</div>
				<div class="absolute -right-8 -top-16 max-w-xs rounded-lg rounded-bl-none bg-color-primary-500 p-4 text-white">
					<p class="text-sm font-bold">Boleh-boleh aja</p>
				</div>
			</div>
		</section>
		<section class="flex h-full w-full flex-[4] items-center justify-center bg-white px-6">
			<div class="flex w-full max-w-md flex-col gap-y-2">
				<p class="text-sm text-slate-500">Selamat Datang Kembali👋</p>
				<h1 class="text-2xl font-bold">Masuk Ke Akun Kamu</h1>
				<form action="{{ route('auth.authenticate') }}" method="POST" x-data="{ showPassword: false }">
					@csrf
					<div class="mt-3 flex flex-col gap-y-2">
						<label for="email" class="text-sm">Email</label>
						<input type="text" name="email" wire:model="email" class="rounded-md border border-gray-300 bg-neutral-100 p-4 text-sm text-slate-600 focus:outline-color-primary-500">
						@error('email')
							<div class="text-xs text-color-danger-500">
								{{ $message }}
							</div>
						@enderror
					</div>
					<div class="mt-3 flex flex-col gap-y-2">
						<label for="password" class="text-sm">Password</label>
						<input :type="showPassword ? 'text' : 'password'" name="password" wire:model="password" class="rounded-md border border-gray-300 bg-neutral-100 p-4 text-sm text-slate-600 focus:outline-color-primary-500">
						@error('password')
							<div class="text-xs text-color-danger-500">
								{{ $message }}
							</div>
						@enderror
					</div>
					<div class="mt-6 flex px-2">
						<input type="checkbox" id="show_pass" x-model="showPassword" class="mr-2 leading-tight">
						<label for="show_pass" class="text-sm">Tampil Password</label>
					</div>
					<div class="mt-4">
						<x-button color="primary" class="w-full" size="lg" type="submit">
							Login
						</x-button>
					</div>
					<div class="mt-4">
						<x-button color="primary" outlined="true" class="w-full" size="lg" onclick="window.location.href='{{ route('home.index') }}'">
							Beranda
						</x-button>
					</div>
				</form>
			</div>
		</section>
	</div>
@endsection
