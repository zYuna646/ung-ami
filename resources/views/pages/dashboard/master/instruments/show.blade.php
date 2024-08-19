@extends('layouts.app', [
    'title' => 'Detail Instrumen',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Detail Instrumen</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Survei' => route('dashboard.master.periodes.index'),
				    $instrument->periode->formatted_start_date . ' - ' . $instrument->periode->formatted_end_date => route('dashboard.master.periodes.show', $instrument->periode->uuid),
				    $instrument->name => null,
				]" />
			</div>
			<div class="flex gap-3">
				<x-instruments.edit :$instrument />
			</div>
		</div>
	</x-main.section>
	<x-main.section class="grid grid-cols-1 gap-6 sm:grid-cols-3">
		<div>
			<x-main.card>
				<x-main.list :items="[
				    (object) [
				        'label' => 'Tahun',
				        'value' => $instrument->periode->year,
				    ],
				    (object) [
				        'label' => 'Periode',
				        'value' => $instrument->periode->formatted_start_date . ' - ' . $instrument->periode->formatted_end_date,
				    ],
				    (object) [
				        'label' => 'Standar',
				        'value' => $instrument->periode->standard->name,
				    ],
				    (object) [
				        'label' => 'Area',
				        'value' => $instrument->periode->units->pluck('unit_name')->implode(', '),
				    ],
				    (object) [
				        'label' => 'Tipe',
				        'value' => $instrument->periode->tipe,
				    ],
				    (object) [
				        'label' => 'Ketua Auditor',
				        'value' => $instrument->periode->chief_auditor->user->name,
				    ],
				    (object) [
				        'label' => 'Anggota Auditor',
				        'values' =>
				            count($instrument->periode->auditor_members) > 0
				                ? $instrument->periode->auditor_members->map(function ($auditor) {
				                    return (object) [
				                        'value' => $auditor->user->name,
				                    ];
				                })
				                : [
				                    (object) [
				                        'value' => '-',
				                    ],
				                ],
				    ],
				    (object) [
				        'label' => 'Instrumen',
				        'value' => $instrument->name,
				    ],
				]" />
			</x-main.card>
		</div>
		<div class="col-span-2 flex-col gap-6">
			<x-main.card>
				<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
					<h5 class="text-lg font-bold">Daftar Indikator</h5>
					<x-indicators.add :instrument-id="$instrument->id" />
				</div>
				<x-indicators.table :indicators="$instrument->indicators" />
			</x-main.card>
		</div>
	</x-main.section>
@endsection
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
@endpush
