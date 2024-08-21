@extends('layouts.app', [
    'title' => 'Detail Survei',
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
		<div class="flex flex-col items-start justify-between gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-semibold uppercase">Audit Dokumen</h1>
				<p class="text-xl uppercase text-slate-500">{{ $instrument->name }}</p>
			</div>
		</div>
		<div class="grid grid-cols-2 gap-5">
			<div class="flex flex-col gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
				<div class="inline-flex items-center gap-x-2">
					<span>
						<i class="fas fa-book"></i>
					</span>
					<p><span class="font-semibold">Standar:</span> {{ $instrument->periode->standard->name }}</p>
				</div>
				<div class="inline-flex items-center gap-x-2">
					<span>
						<i class="fas fa-clipboard-list"></i>
					</span>
					<p><span class="font-semibold">Tipe Audit:</span> {{ $instrument->periode->tipe }}</p>
				</div>
				<div class="inline-flex items-center gap-x-2">
					<span>
						<i class="fas fa-clipboard-list"></i>
					</span>
					<p><span class="font-semibold">Periode:</span> {{ $instrument->periode->formatted_start_date . ' - ' . $instrument->periode->formatted_end_date }}</p>
				</div>
			</div>
			<div class="flex flex-col gap-y-3 rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
				<div class="inline-flex items-center gap-x-2">
					<span>
						<i class="fas fa-user-tie"></i>
					</span>
					<p><span class="font-semibold">Auditor:</span></p>
				</div>
				<ul class="space-y-2">
					<li><span class="font-semibold">Ketua:</span> {{ $instrument->periode->chief_auditor->user->name }}</li>
					<li><span class="font-semibold">Anggota:</span> {{ $instrument->periode->auditor_members->pluck('user.name')->implode(' - ') }}</li>
				</ul>
			</div>
		</div>
		<form action="{{ route('survey.store', $instrument->uuid) }}" method="POST">
			@csrf
			<div class="space-y-5">
				@foreach ($instrument->indicators as $key => $indicator)
					<div class="rounded-lg border border-slate-100 bg-white shadow-sm">
						<div class="border-b border-gray-300 p-6">
							<h2 class="font-semibold">{{ $loop->iteration }}. {{ $indicator->name }}</h2>
						</div>
						<div class="space-y-5 p-6">
							@foreach ($indicator->questions as $question)
								@can('view', $question)
									<div class="space-y-3">
										<div>
											<h3 class="font-semibold">Butir Pertanyaan</h3>
											<p class="mb-1 text-lg">{{ $question->text }}</p>
											<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
										</div>

										@php
											$availabilityFieldName = "availability.{$question->id}";
											$notesFieldName = "notes.{$question->id}";
										@endphp

										<x-form.select name="availability[{{ $question->id }}]" placeholder="Pilih Ketersediaan Dokumen" :value="old($availabilityFieldName) ?? $question->response->availability" :options="[
										    (object) [
										        'label' => 'Tersedia',
										        'value' => 'Tersedia',
										    ],
										    (object) [
										        'label' => 'Tidak Tersedia',
										        'value' => 'Tidak Tersedia',
										    ],
										]" :inputClass="$errors->has($availabilityFieldName) ? 'border-red-700' : ''" />
										@error($availabilityFieldName)
											<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
										@enderror

										<x-form.textarea name="notes[{{ $question->id }}]" placeholder="Catatan" :inputClass="$errors->has($notesFieldName) ? 'border-red-700' : ''" :value="old($notesFieldName) ?? $question->response->notes" />
										@error($notesFieldName)
											<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
										@enderror

										<p class="text-right text-sm text-gray-600">{{ $question->code }}</p>
									</div>
								@endcan
							@endforeach
						</div>
					</div>
				@endforeach
				<div class="flex justify-end gap-3">
					{{-- <x-button color="success">
						Edit
						<i class="fas fa-pencil-square ms-2"></i>
					</x-button> --}}
					<x-button type="submit" color="info">
						Simpan Penilaian
						<i class="fas fa-arrow-right ms-2"></i>
					</x-button>
				</div>
			</div>
		</form>
	</section>
@endsection
