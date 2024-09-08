@extends('layouts.app', [
    'title' => 'Tambah Auditi',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Tambah Auditi</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Auditi' => route('dashboard.users.auditees.index'),
				    'Tambah Auditi' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.users.auditees.store') }}" method="POST" class="flex flex-col gap-5">
				@csrf
				<x-form.select name="type" label="Pilih Jenis" :value="request('type')" x-data="{ type: '{{ request('type') }}' }" x-on:change="window.location.href = '{{ url()->current() }}' + '?type=' + $event.target.value" :options="[
				    (object) [
				        'label' => 'Badan & UPT',
				        'value' => 'unit',
				    ],
				    (object) [
				        'label' => 'Fakultas',
				        'value' => 'faculty',
				    ],
				    (object) [
				        'label' => 'Program Studi',
				        'value' => 'program',
				    ],
				]" />
				@if (request('type') == 'unit')
					<x-form.select name="unit_id" label="Badan & UPT" :options="$units->map(function ($unit) {
					    return (object) [
					        'label' => $unit->unit_name,
					        'value' => $unit->id,
					    ];
					})" />
				@endif
				@if (request('type') == 'faculty')
					<x-form.select name="faculty_id" label="Fakultas" :options="$faculties->map(function ($faculty) {
					    return (object) [
					        'label' => $faculty->faculty_name,
					        'value' => $faculty->id,
					    ];
					})" />
				@endif
				@if (request('type') == 'program')
					<x-form.select name="program_id" label="Program Studi" :options="$programs->map(function ($program) {
					    return (object) [
					        'label' => $program->program_name,
					        'value' => $program->id,
					    ];
					})" />
				@endif
				<x-form.input name="name" label="Nama Lengkap" placeholder="Isi nama lengkap" />
				<x-form.input type="email" name="email" label="Email" placeholder="Isi email" />
				<x-form.input type="password" name="password" label="Password" placeholder="***************" />
				<x-form.input type="password" name="password_confirmation" label="Konfirmasi Password" placeholder="***************" />
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
