@extends('layouts.app', [
    'title' => 'Laporan',
])
@push('styles')
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
@endpush
@section('content')
	<section class="mx-auto grid w-full max-w-screen-xl gap-5 p-5 pt-7">
		<div class="flex flex-col justify-between gap-5 lg:flex-row">
			<div class="grow space-y-5">
				<div class="rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
					<h1 class="text-lg font-bold">Daftar Laporan</h1>
					<p class="text-sm text-slate-500">Berikut merupakan daftar laporan hasil audit mutu internal</p>
				</div>
				<div class="grid grid-cols-1 gap-4">
					@forelse ($programPeriodes as $periode)
						<x-main.card class="flex justify-between gap-5">
							<div class="grow">
								<p class="text-base font-medium">
									Laporan Hasil <br>
									Audit Mutu Internal Fakultas {{ $program->department->faculty->faculty_name }} <br>
									Program Studi {{ $program->program_name }} <br>
									Tahun {{ $periode->year }}
								</p>
							</div>
							<div class="flex basis-1/2 items-start justify-end gap-3">
								{{-- <x-button :href="asset('files/template.docx')" color="info" size="sm">
									Berita Acara
									<i class="fa-solid fa-download ms-2"></i>
								</x-button> --}}
								<div x-data="{ generateBeritaAcaraModal: false }">
									<x-button @click="generateBeritaAcaraModal = true" color="info" size="sm">
										Berita Acara
										<i class="fa-solid fa-upload ms-2"></i>
									</x-button>
									<div x-cloak x-show="generateBeritaAcaraModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
										<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg max-h-[90%] overflow-y-auto">
											<div class="flex items-center justify-between border-b pb-4">
												<h3 class="text-lg font-bold">Generate Berita Acara</h3>
												<button type="button" @click="generateBeritaAcaraModal = false" class="text-gray-400 hover:text-gray-900">
													<i class="fas fa-times"></i>
												</button>
											</div>
											<div class="p-4">
												<form action="{{ route('report.generate', [$periode->uuid, $program->uuid]) }}" method="POST" class="flex flex-col gap-5" enctype="multipart/form-data">
													@csrf
													<input type="hidden" name="periode_id" value="{{ $periode->id }}">
													<x-form.input type="date" name="berita_acara_date" label="Tanggal Berita Acara" />
													<x-form.input name="kaprodi_name" label="Nama Kaprodi" placeholder="Nama Kaprodi" />
													<div class="flex justify-end gap-2">
														<x-button @click="generateBeritaAcaraModal = false" color="default">Batal</x-button>
														<x-button type="submit" color="info">Submit</x-button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								@if (auth()->user()->isAuditor())
									<div x-data="{ addFilesModal: false }">
										<x-button @click="addFilesModal = true" color="info" size="sm">
											Unggah
											<i class="fa-solid fa-upload ms-2"></i>
										</x-button>
										<div x-cloak x-show="addFilesModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
											<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg max-h-[90%] overflow-y-auto">
												<div class="flex items-center justify-between border-b pb-4">
													<h3 class="text-lg font-bold">Unggah</h3>
													<button type="button" @click="addFilesModal = false" class="text-gray-400 hover:text-gray-900">
														<i class="fas fa-times"></i>
													</button>
												</div>
												<div class="p-4">
													<form action="{{ route('report.upload', [$periode->uuid, $program->uuid]) }}" method="POST" class="flex flex-col gap-5" enctype="multipart/form-data">
														@csrf
														<input type="hidden" name="periode_id" value="{{ $periode->id }}">
														@php
															$auditReport = $program
															    ->auditReports()
															    ->where('periode_id', $periode->id)
															    ->get()
															    ->last();
															$evidences = json_decode($auditReport?->pivot?->activity_evidences);
														@endphp
														<div>
															<label for="saran-{{ $periode->uuid }}" class="mb-2 block text-sm font-medium text-gray-900">
																Saran
															</label>
															<textarea id="saran-{{ $periode->uuid }}" name="saran">{{ $auditReport?->pivot?->saran }}</textarea>
														</div>
														<x-form.input type="file" name="meeting_report" label="Unggah Berita Acara" />
														<div>
															@isset($auditReport->pivot->meeting_report)
																<a href="{{ asset('storage/audits/' . $auditReport->pivot->meeting_report) }}" target="_blank" class="text-xs text-blue-500 underline">{{ $auditReport->pivot->meeting_report }}</a>
															@else
																<p class="text-xs text-red-400">Berita acara belum diunggah.</p>
															@endisset
														</div>
														<x-form.input type="file" name="activity_evidences[]" label="Unggah Bukti Kegiatan" multiple />
														<div class="flex flex-col">
															@if (isset($evidences) && count($evidences) > 0)
																@foreach ($evidences as $evidence)
																	<a href="{{ asset('storage/audits/' . $evidence) }}" target="_blank" class="text-xs text-blue-500 underline">{{ $evidence }}</a>
																@endforeach
															@else
																<p class="text-xs text-red-400">Bukti kegiatan belum diunggah.</p>
															@endif
														</div>
														<div class="flex justify-end gap-2">
															<x-button @click="addFilesModal = false" color="default">Batal</x-button>
															<x-button type="submit" color="info">Submit</x-button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								@endif
								<div x-data="{ open: false }" class="relative">
									<x-button @click="open = !open" color="info" size="sm">
										Unduh
										<i class="fa-solid fa-chevron-down ms-2"></i>
									</x-button>

									<div x-cloak x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-32 rounded-md bg-white shadow-lg">
										<ul class="py-1">
											<li>
												<a href="{{ route('report.cover', [$periode->uuid, $program->uuid]) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													COVER
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
											<li>
												<a href="{{ route('report.bab1', [$periode->uuid, $program->uuid]) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													BAB I
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
											<li>
												<a href="{{ route('report.bab2', [$periode->uuid, $program->uuid]) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													BAB II
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
											<li>
												<a href="{{ route('report.bab3', [$periode->uuid, $program->uuid]) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													BAB III
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
											<li>
												<a href="{{ route('report.bab4', [$periode->uuid, $program->uuid]) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													BAB IV
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
											<li>
												<a href="{{ route('report.bab5', [$periode->uuid, $program->uuid]) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													BAB V
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
											<li>
												<a href="{{ route('report.lampiran', [$periode->uuid, $program->uuid]) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													LAMPIRAN
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
											<li>
												<a href="{{ route('report.full', [$periode->uuid, $program->uuid]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
													FULL
													<i class="fa-solid fa-download float-end ms-2"></i>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</x-main.card>
					@empty
						<div class="col-span-12 py-8 text-center">
							<p class="text-lg font-semibold text-slate-600">Data tidak ditemukan.</p>
						</div>
					@endforelse
				</div>
			</div>
			<div class="basis-1/4">
				@if (auth()->user()->isAuditor())
					<div class="space-y-3 rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
						<h1 class="mb-3 text-lg font-bold">Filter</h1>
						<x-form.select name="program" label="Program Studi" :value="request('program')" :options="$programs->map(function ($program) {
						    return (object) [
						        'label' => $program->program_name,
						        'value' => $program->uuid,
						    ];
						})" x-data="" @change="window.location.href = '{{ route('report.index') }}' + '?program=' + $event.target.value" />
					</div>
				@endif
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	@foreach ($programPeriodes as $periode)
		<script>
			$(document).ready(function() {
				$("#saran-{{ $periode->uuid }}").summernote();
			});
		</script>
	@endforeach
@endpush
