@extends('layouts.app', [
    'title' => 'Edit Fakultas',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Fakultas</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Fakultas' => route('dashboard.master.faculties.index'),
				    $faculty->name => null,
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.faculties.update', $faculty->uuid) }}" method="POST" class="flex flex-col gap-5">
				@csrf
				@method('PUT')
				<x-form.input name="faculty_name" label="Nama" :value="$faculty->faculty_name" />
				<div>
					<x-button type="submit" color="info">
						Perbarui
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
