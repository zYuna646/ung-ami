@extends('layouts.app', [
    'title' => 'Tambah Survei',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Tambah Survei</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Survei' => route('dashboard.master.periodes.index'),
				    'Tambah Data' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.periodes.store') }}" method="POST" class="flex flex-col gap-5">
				@csrf
				<x-form.input type="number" name="year" label="Tahun" placeholder="Isi tahun" min="1999" max="2099" step="1" />
				<x-form.input type="date" name="start_date" label="Tanggal Mulai" />
				<x-form.input type="date" name="end_date" label="Tanggal Selesai" />
				<x-form.select name="standard_id" label="Standar" :options="$standards->map(function ($standard) {
				    return (object) [
				        'label' => $standard->name,
				        'value' => $standard->id,
				    ];
				})" />
				<x-form.input name="tipe" label="Tipe" placeholder="Isi tipe" />
				<x-form.select name="chief_auditor_id" label="Ketua Auditor" :options="$auditors->map(function ($auditor) {
				    return (object) [
				        'label' => $auditor->user->name,
				        'value' => $auditor->id,
				    ];
				})" />
				<x-form.input name="code" label="Kode Dokumen" placeholder="Isi Kode Dokumen" />
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
