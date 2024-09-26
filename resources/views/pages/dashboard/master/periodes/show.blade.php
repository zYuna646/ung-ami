@extends('layouts.app', [
    'title' => 'Detail Survei',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Detail Survei</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Survei' => route('dashboard.master.periodes.index'),
				    $periode->periode_name => null,
				]" />
			</div>
			<div class="flex gap-3">
				<x-button :href="route('dashboard.master.periodes.edit', $periode->uuid)" color="success">
					Edit
				</x-button>
				<x-button.delete :action="route('dashboard.master.periodes.destroy', $periode->uuid)">
					<p>Anda akan menghapus data berikut:</p>
					<x-main.list :items="[
					    (object) [
					        'label' => 'ID',
					        'value' => $periode->uuid,
					    ],
					    (object) [
					        'label' => 'Periode',
					        'value' => $periode->formatted_start_date . ' - ' . $periode->formatted_end_date,
					    ],
					]" />
				</x-button.delete>
			</div>
		</div>
	</x-main.section>
	<x-main.section class="grid grid-cols-1 items-start gap-6 sm:grid-cols-3">
		<x-main.card>
			<x-main.list :items="[
			    (object) [
			        'label' => 'Nama',
			        'value' => $periode->periode_name,
			    ],
			    (object) [
			        'label' => 'Tahun',
			        'value' => $periode->year,
			    ],
			    (object) [
			        'label' => 'Periode',
			        'value' => $periode->formatted_start_date . ' - ' . $periode->formatted_end_date,
			    ],
			    (object) [
			        'label' => 'Tipe',
			        'value' => $periode->tipe,
			    ]
			]" />
		</x-main.card>
		<div class="col-span-2 grid gap-6">
			<x-main.card>
				<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
					<h5 class="text-lg font-bold">Daftar Instrumen</h5>
					<x-instruments.add :$periode :$units :$masterInstruments />
				</div>
				<x-instruments.table :$periode />
			</x-main.card>
		</div>
	</x-main.section>
@endsection
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
@endpush
