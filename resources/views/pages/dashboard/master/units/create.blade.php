@extends('layouts.app', [
    'title' => 'Tambah Badan & UPT',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Tambah Badan & UPT</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Badan & UPT' => route('dashboard.master.units.index'),
				    'Tambah Data' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.units.store') }}" method="POST" class="flex flex-col gap-5">
				@csrf
				<x-form.input name="unit_name" label="Nama Badan / UPT" />
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
