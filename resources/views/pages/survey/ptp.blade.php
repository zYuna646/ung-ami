@extends('layouts.app', [
    'title' => 'Permintaan Tindakan Peningkatan',
    'showAlert' => false,
])
@section('content')
	@if (session('success'))
		<x-alerts.success />
	@endif
	@if ($errors->any())
		<section class="mx-auto grid w-full max-w-screen-xl gap-5 p-5">
			<x-alerts.error>
				<span class="mt-1.5 block">Terjadi kesalahan saat mengirim penilaian.</span>
			</x-alerts.error>
		</section>
	@endif
	<section class="mx-auto grid w-full max-w-screen-xl gap-5 p-5 pt-7">
		<div class="border-b border-gray-200 text-center text-sm font-medium text-gray-500">
			<x-tabs.audit :$instrument />
		</div>
		<x-main.card>
			<div class="flex flex-col items-start justify-between gap-y-2 sm:flex-row sm:items-center">
				<div>
					<h1 class="text-lg font-semibold uppercase">Audit Lapangan</h1>
					<p class="text-xl uppercase text-slate-500">Permintaan Tindakan Peningkatan</p>
				</div>
			</div>
		</x-main.card>
		<div class="grid grid-cols-1 items-start gap-6 sm:grid-cols-3">
			<x-survey.detail :$instrument />
			<div class="col-span-2">
				<x-survey.form6 :$instrument :$showInstrument :$questions />
			</div>
		</div>
	</section>
@endsection
