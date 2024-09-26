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
				    $periode->periode_name => route('dashboard.master.periodes.show', $periode->uuid),
				    $instrument->name => null,
				]" />
			</div>
			<div class="flex gap-3">
				<x-button :href="route('dashboard.master.periodes.instruments.edit', [$periode->uuid, $instrument->uuid])" color="success">
					Edit
				</x-button>
				<x-instruments.delete :$periode :$instrument />
			</div>
		</div>
	</x-main.section>
	<x-main.section class="grid grid-cols-1 gap-6 sm:grid-cols-3">
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
			    // (object) [
			    //     'label' => 'Standar',
			    //     'value' => $periode->standard->name,
			    // ],
			    (object) [
			        'label' => 'Tipe',
			        'value' => $periode->tipe,
			    ],
			    // (object) [
			    //     'label' => 'Ketua Auditor',
			    //     'value' => $periode->team->chief->user->name,
			    // ],
			    // (object) [
			    //     'label' => 'Anggota Auditor',
			    //     'values' =>
			    //         count($periode->team->members) > 0
			    //             ? $periode->team->members->map(function ($auditor) {
			    //                 return (object) [
			    //                     'value' => $auditor->user->name,
			    //                 ];
			    //             })
			    //             : [
			    //                 (object) [
			    //                     'value' => '-',
			    //                 ],
			    //             ],
			    // ],
			    (object) [
			        'label' => 'Instrumen',
			        'value' => $instrument->name,
			    ],
			    (object) [
			        'label' => 'Area',
			        'value' => $instrument->units->pluck('unit_name')->implode(', '),
			    ],
			    (object) [
			        'label' => 'Indikator',
			        'value' => $indicator->name ?? '-',
			    ],
			]" />
		</x-main.card>
		<div class="col-span-2 grid gap-6">
			<x-main.card>
				<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
					<h5 class="text-lg font-bold">Area Survei & Tim Pelaksana</h5>
				</div>
				<x-areas.table :$instrument :$areas :$teams />
			</x-main.card>
			<x-main.card>
				<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
					<h5 class="text-lg font-bold">Daftar Indikator</h5>
					<x-indicators.add :$periode :$instrument />
				</div>
				<x-indicators.table :$periode :$instrument :indicators="$instrument->indicators" />
			</x-main.card>
			<x-main.card>
				<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
					<h5 class="text-lg font-bold">Daftar Pertanyaan</h5>
					@isset($indicator)
						<x-questions.add :$periode :$instrument :$indicator :units="$instrument->units" />
					@endisset
				</div>
				<div x-data>
					<x-form.select name="indicator" placeholder="Pilih Indikator" :value="request('indicator')" class="mb-4" :options="$instrument->indicators->map(function ($indicator) {
					    return (object) [
					        'label' => $indicator->name,
					        'value' => $indicator->uuid,
					    ];
					})" @change="window.location.href = '{{ url()->current() }}?indicator=' + $event.target.value" />
				</div>
				<x-questions.table :$periode :$instrument :$indicator :$questions />
			</x-main.card>
		</div>
	</x-main.section>
@endsection
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
@endpush
