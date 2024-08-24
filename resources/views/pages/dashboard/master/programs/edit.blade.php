@extends('layouts.app', [
    'title' => 'Edit Program Studi',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Program Studi</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Program Studi' => route('dashboard.master.programs.index'),
				    $program->name => null,
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.programs.update', $program->uuid) }}" method="POST" class="flex flex-col gap-5">
				@csrf
				@method('PUT')
				<x-form.input name="program_name" label="Nama" :value="$program->program_name" />
				<div>
					<x-button type="submit" color="info">
						Perbarui
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
