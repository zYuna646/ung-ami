@extends('layouts.app', [
    'title' => 'Tambah Instrumen',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Tambah Instrumen</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Instrumen' => route('dashboard.master.instrumens.index'),
				    'Tambah Data' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.instrumens.store') }}" method="POST" class="flex flex-col gap-5">
				@csrf
				<x-form.input name="name" label="Instrumen" placeholder="Isi instrumen" />
				<x-form.select name="standar_id" label="Standar" :options="$standars->map(function ($standar) {
				    return (object) [
				        'label' => $standar->name,
				        'value' => $standar->id,
				    ];
				})" />
				<x-form.input name="tipe" label="Tipe" placeholder="Isi tipe" />
				<x-form.input name="periode" label="Periode" placeholder="Isi periode" type="number" min="1998" max="2099" />
				<x-form.select name="ketua_id" label="Ketua" :options="$auditors->map(function ($auditor) {
				    return (object) [
				        'label' => $auditor->user->name,
				        'value' => $auditor->id,
				    ];
				})" />
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection