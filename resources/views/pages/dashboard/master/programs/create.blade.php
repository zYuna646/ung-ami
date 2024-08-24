@extends('layouts.app', [
    'title' => 'Tambah Program Studi',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Tambah Program Studi</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Program Studi' => route('dashboard.master.programs.index'),
				    'Tambah Data' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.programs.store') }}" method="POST" class="flex flex-col gap-5">
				@csrf
				<x-form.select name="department_id" label="Pilih Jurusan" :options="$departments->map(function ($department) {
				    return (object) [
				        'label' => $department->department_name,
				        'value' => $department->id,
				    ];
				})" />
				<x-form.input name="program_name" label="Nama Program Studi" placeholder="Sistem Informasi" />
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
