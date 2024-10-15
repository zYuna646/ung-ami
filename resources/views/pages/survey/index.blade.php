@extends('layouts.app', [
    'title' => 'Survei',
])
@section('content')
	<section class="mx-auto grid w-full max-w-screen-xl gap-5 p-5 pt-7">
		<div class="flex flex-col justify-between gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm lg:flex-row lg:items-center">
			<div>
				<h1 class="text-lg font-bold">Daftar Survei</h1>
				<p class="text-sm text-slate-500">Berikut merupakan daftar instrument yang tersedia</p>
			</div>
			<div>
				<x-form.select name="periode" placeholder="Pilih Periode" :value="request('periode')" :options="$periodes->map(function ($periode) {
				    return (object) [
				        'label' => $periode->formatted_start_date . ' - ' . $periode->formatted_end_date,
				        'value' => $periode->uuid,
				    ];
				})" x-data="" @change="window.location.href = '{{ route('survey.index') }}' + '?periode=' + $event.target.value" />
			</div>
		</div>
		<div class="grid grid-cols-12 gap-4">
			@php
				$filteredInstruments = $instruments->filter(function ($instrument) {
				    return auth()->user()->can('view', $instrument);
				});
			@endphp

			@if ($filteredInstruments->isEmpty())
				<div class="col-span-12 py-8 text-center">
					<p class="text-lg font-semibold text-slate-600">No instruments available at the moment.</p>
				</div>
			@else
				@foreach ($filteredInstruments as $instrument)
					<a href="{{ auth()->user()->isAuditor() ? route('survey.audit_results', $instrument->uuid) : route('survey.show', $instrument->uuid) }}" class="flex cursor-pointer flex-col gap-x-4 gap-y-2 rounded-lg border border-slate-100 bg-white p-8 shadow-sm transition-colors hover:border-color-info-500 lg:col-span-4">
						<div class="flex max-w-lg flex-col gap-y-2">
							<p class="text-base font-bold">{{ $instrument->name }}</p>
							<div class="flex flex-col gap-y-2">
								<div class="inline-flex items-center gap-x-2 text-xs">
									<span>
										<i class="fas fa-book"></i>
									</span>
									<p><span class="font-semibold">Area:</span> {{ $instrument->units->pluck('unit_name')->implode(', ') }}</p>
								</div>
								<div class="inline-flex items-center gap-x-2 text-xs">
									<span>
										<i class="fas fa-clipboard-list"></i>
									</span>
									<p><span class="font-semibold">Tipe Audit:</span> {{ $instrument->periode->tipe }}</p>
								</div>
								{{-- <div class="inline-flex items-center gap-x-2 text-xs">
									<span>
										<i class="fas fa-user-tie"></i>
									</span>
									@php
										$data = $instrument
										    ->entityTeams()
										    ->where('entity_id', auth()->user()->entityId())
										    ->where('entity_type', auth()->user()->entityType())
										    ->first();
									@endphp
									<p><span class="font-semibold">Auditor Ketua:</span> {{ $data->team->chief->user->name }}</p>
								</div> --}}
							</div>
						</div>
					</a>
				@endforeach
			@endif
		</div>
	</section>
@endsection
