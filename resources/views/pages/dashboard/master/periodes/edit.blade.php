@extends('layouts.app', [
    'title' => 'Edit Survei',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Survei</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Survei' => route('dashboard.master.periodes.index'),
				    $periode->periode_name => route('dashboard.master.periodes.show', $periode->uuid),
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.periodes.update', $periode->uuid) }}" method="POST" class="flex flex-col gap-5">
				@csrf
				@method('PUT')
				<x-form.input name="periode_name" label="Nama Periode" placeholder="Isi nama periode" :value="$periode->periode_name" />
				<x-form.input type="number" name="year" label="Tahun" placeholder="Isi tahun" min="1999" max="2099" step="1" :value="$periode->year" />
				<x-form.input type="date" name="start_date" label="Tanggal Mulai" :value="$periode->start_date" />
				<x-form.input type="date" name="end_date" label="Tanggal Selesai" :value="$periode->end_date" />
				<x-form.select name="standard_id" label="Standar" :value="$periode->standard_id" :options="$standards->map(function ($standard) {
				    return (object) [
				        'label' => $standard->name,
				        'value' => $standard->id,
				    ];
				})" />
				<x-form.input name="tipe" label="Tipe" placeholder="Isi tipe" :value="$periode->tipe" />
				<x-form.select name="team_id" label="Tim Auditor" :value="$periode->team_id" :options="$teams->map(function ($team) {
				    return (object) [
				        'label' => $team->chief->user->name . ' (Ketua)',
				        'value' => $team->id,
				    ];
				})" />
				<x-form.input name="code" label="Kode Dokumen" placeholder="Isi Kode Dokumen" :value="$periode->code" />
				<div>
					<x-button type="submit" color="info">
						Perbarui
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
