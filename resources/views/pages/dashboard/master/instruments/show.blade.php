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
				    'Master Instrumen' => route('dashboard.master.instruments.index'),
				    $instrument->instrument => null,
				]" />
			</div>
			<div class="flex gap-3">
				<x-master.instruments.edit :$instrument />
				<x-master.instruments.delete :$instrument />
			</div>
		</div>
	</x-main.section>
	<x-main.section class="grid grid-cols-1 gap-6 sm:grid-cols-3">
		<div>
			<x-main.card>
				<x-main.list :items="[
				    (object) [
				        'label' => 'Instrumen',
				        'value' => $instrument->instrument,
				    ],
						(object) [
				        'label' => 'Jumlah Indikator',
				        'value' => $instrument->indicators->count(),
				    ],
						(object) [
				        'label' => 'Jumlah Pertanyaan',
				        'value' => $instrument->questions->count(),
				    ],
				]" />
			</x-main.card>
		</div>
		<div class="col-span-2 flex-col space-y-6">
			<x-main.card>
				<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
					<h5 class="text-lg font-bold">Daftar Indikator</h5>
					<x-master.indicators.add :instrument-id="$instrument->id" />
				</div>
				<x-master.indicators.table :indicators="$instrument->indicators" />
			</x-main.card>
			<x-main.card>
				<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
					<h5 class="text-lg font-bold">Daftar Pertanyaan</h5>
					@isset($indicator)
						<x-master.questions.add :indicator-id="$indicator->id" />
					@endisset
				</div>
				<div x-data>
					<x-form.select name="indicator" placeholder="Pilih Indikator" :value="request('indicator')" class="mb-4" :options="$instrument->indicators->map(function ($indicator) {
					    return (object) [
					        'label' => $indicator->indicator,
					        'value' => $indicator->uuid,
					        'desc' => $indicator->desc,
					    ];
					})" @change="window.location.href = '{{ url()->current() }}?indicator=' + $event.target.value" />
				</div>
				<x-master.questions.table :$questions />
			</x-main.card>
		</div>
	</x-main.section>
@endsection
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
@endpush
