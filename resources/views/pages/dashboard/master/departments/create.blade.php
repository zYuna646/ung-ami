@extends('layouts.app', [
    'title' => 'Tambah Jurusan',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Tambah Jurusan</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Jurusan' => route('dashboard.master.departments.index'),
				    'Tambah Data' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.departments.store') }}" method="POST" class="flex flex-col gap-5">
				@csrf
				<x-form.select name="faculty_id" label="Pilih Fakultas" :options="$faculties->map(function ($faculty) {
				    return (object) [
				        'label' => $faculty->faculty_name,
				        'value' => $faculty->id,
				    ];
				})" />
				<x-form.input name="department_name" label="Nama Jurusan" placeholder="Teknik Informatika" />
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
