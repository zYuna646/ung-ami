@extends('layouts.app', [
    'title' => 'Edit Pengguna',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Pengguna</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Pengguna' => route('dashboard.users.auditors.index'),
				    $auditor->user->name => null,
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.users.auditors.update', $auditor->uuid) }}" method="POST" class="flex flex-col gap-5">
				@csrf
				@method('PUT')
				<x-form.input name="name" label="Nama Lengkap" placeholder="Isi nama lengkap" :value="$auditor->user->name" />
				<x-form.input type="email" name="email" label="Email" placeholder="Isi email" :value="$auditor->user->email" />
				<x-form.input type="password" name="password" label="Password" placeholder="(Opsional)" />
				<x-form.input type="password" name="password_confirmation" label="Konfirmasi Password" placeholder="Konfirmasi password (Jika ada)" />
				<div>
					<x-button type="submit" color="info">
						Perbarui
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
