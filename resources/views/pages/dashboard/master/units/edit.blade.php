@extends('layouts.app', [
    'title' => 'Edit Badan & UPT',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Badan & UPT</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Badan & UPT' => route('dashboard.master.units.index'),
				    $unit->name => null,
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.units.update', $unit->uuid) }}" method="POST" class="flex flex-col gap-5">
				@csrf
				@method('PUT')
				<x-form.input name="unit_name" label="Nama" :value="$unit->unit_name" />
				<div>
					<x-button type="submit" color="info">
						Perbarui
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
