@extends('layouts.app', [
    'title' => 'Laporan',
])
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
							<div class="flex basis-1/2 items-start justify-end">
								<div x-data="{ open: false }" class="relative">
									<x-button @click="open = !open" color="info" size="sm">
										Unduh
										<i class="fa-solid fa-chevron-down ms-2"></i>
									</x-button>

									<div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-32 rounded-md bg-white shadow-lg">
										<ul class="py-1">
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
