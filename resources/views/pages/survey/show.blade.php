@extends('layouts.app', [
    'title' => 'Detail Survei',
])
@section('content')
	<section class="mx-auto grid w-full max-w-screen-xl gap-5 p-5 pt-7">
		<div class="flex flex-col items-start justify-between gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-semibold uppercase">Audit Dokumen</h1>
				<p class="text-xl uppercase text-slate-500">{{ $instrumen->name }}</p>
			</div>
			<div>
				<x-form.select name="year" :multiple="false" item-select-text="" :search="false" class="min-w-20" :options="[
				    (object) [
				        'label' => '2022',
				        'value' => '2022',
				    ],
				    (object) [
				        'label' => '2023',
				        'value' => '2023',
				    ],
				]" />
			</div>
		</div>
		<div class="grid grid-cols-2 gap-5">
			<div class="flex flex-col gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
				<div class="inline-flex items-center gap-x-2">
					<span>
						<i class="fas fa-book"></i>
					</span>
					<p><span class="font-semibold">Standar:</span> {{ $instrumen->standar->name }}</p>
				</div>
				<div class="inline-flex items-center gap-x-2">
					<span>
						<i class="fas fa-clipboard-list"></i>
					</span>
					<p><span class="font-semibold">Tipe Audit:</span> {{ $instrumen->tipe }}</p>
				</div>
			</div>
			<div class="flex flex-col gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
				<div class="inline-flex items-center gap-x-2">
					<span>
						<i class="fas fa-user-tie"></i>
					</span>
					<p><span class="font-semibold">Auditor:</span></p>
				</div>
				<ul class="space-y-1list-disc list-inside">
					<li><span class="font-semibold">Ketua:</span> {{ $instrumen->ketua->name }}</li>
					<li><span class="font-semibold">Anggota:</span>
						{{-- anggota --}}
					</li>
				</ul>
			</div>
		</div>
		@foreach ($instrumen->indikator as $indikator)
			<div class="rounded-lg border border-slate-100 bg-white shadow-sm">
				<div class="border-b border-color-primary-100 p-6">
					<h2 class="font-semibold">{{ $indikator->name }}</h2>
				</div>
				<div class="space-y-5 p-6">
					@foreach ($indikator->butir as $butir)
						<div class="space-y-3">
							<div>
								<h3 class="font-semibold">Butir Pertanyaan</h3>
								<p class="mb-1 text-lg">{{ $butir->name }}</p>
								<p class="text-sm text-gray-600">Universitas, UPPS, Prodi</p>
							</div>
							<x-form.select name="{{ $butir->kode }}" :multiple="false" :search="false" class="w-52" placeholder="Ketersediaan Dokumen" :options="[
							    (object) [
							        'label' => 'Tersedia',
							        'value' => 'Tersedia',
							    ],
							    (object) [
							        'label' => 'Tidak Tersedia',
							        'value' => 'Tidak Tersedia',
							    ],
							]" />
							<textarea rows="4" class="block w-full rounded-md border border-neutral-200 bg-neutral-100 p-4 text-sm text-slate-600 focus:outline-color-info-500" placeholder="Catatan..."></textarea>
							<p class="text-right text-sm text-gray-600">{{ $butir->kode }}</p>
						</div>
					@endforeach
				</div>
			</div>
		@endforeach
		<div>
			<x-button>
				Kirim Penilaian
				<i class="fas fa-check"></i>
			</x-button>
			<x-button color="info">
				Edit
				<i class="fas fa-pencil-square"></i>
			</x-button>
		</div>
	</section>
@endsection
