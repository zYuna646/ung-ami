@extends('layouts.app', [
    'title' => 'Survei',
])
@section('content')
	<section class="mx-auto grid w-full max-w-screen-xl gap-5 p-5 pt-7">
		<div class="flex flex-col justify-between gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm lg:flex-row lg:items-center">
			<div>
				<h1 class="text-lg font-bold">Daftar Survei</h1>
				<p class="text-sm text-slate-500">Berikut merupakan daftar instrumen yang tersedia</p>
			</div>
			<div class="flex gap-x-2">
				<form class="inline-flex w-full gap-x-2" wire:submit.prevent="applySearch">
					<input type="text" wire:model.debounce.300ms="search" placeholder="Masukan kata kunci" class="min-w-xl w-full rounded-md border border-neutral-200 bg-neutral-100 p-2 text-xs text-slate-600 focus:outline-none focus:outline-color-info-500">
					<x-button class="" color="info" size="sm" type="submit">
						<span>
							<i class="fas fa-search"></i>
						</span>
					</x-button>
				</form>
				{{-- <div class="inline-flex gap-x-2">
					<x-button class="inline-flex items-center gap-x-2" size="sm" color="default" @click="filterModal = !filterModal">
						<span>
							<i class="fas fa-filter"></i>
						</span>
						Filter
					</x-button>
					<div style="display: none" x-show="filterModal" x-on:keydown.escape.window="filterModal = false" class="fixed left-0 right-0 top-0 z-50 flex h-full max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black/20 md:inset-0">
						<div class="relative max-h-full w-full max-w-2xl p-4" @click.outside="filterModal = false">
							<div class="relative rounded-lg bg-white shadow">
								<div class="flex items-center justify-between rounded-t border-b p-4 md:p-5">
									<h3 class="text-lg font-bold text-gray-900">
										Filter {{ $master }}
									</h3>
									<button type="button" @click="filterModal = false" class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900" data-modal-hide="default-modal">
										<span>
											<i class="fas fa-times"></i>
										</span>
										<span class="sr-only">Close modal</span>
									</button>
								</div>
								<div class="space-y-4 p-4 md:p-5">
									<form wire:submit.prevent="applyFilter" class="grid grid-cols-12 p-2">
										<div class="col-span-12 mb-4 flex flex-col gap-y-2">
											<label for="jenis" class="text-sm">Jenis {{ $master }}:</label>
											<select wire:model="filterJenis" name="jenis" class="rounded-md border border-neutral-200 bg-neutral-100 p-4 text-sm text-slate-600 focus:outline-none focus:outline-color-info-500">
												<option value="">Pilih Jenis</option>
												@foreach ($jenis as $jenis)
													<option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-span-12 mb-4 flex flex-col gap-y-2">
											<label for="target" class="text-sm">Target {{ $master }}:</label>
											<select wire:model="filterTarget" name="target" class="rounded-md border border-neutral-200 bg-neutral-100 p-4 text-sm text-slate-600 focus:outline-none focus:outline-color-info-500">
												<option value="">Pilih Target</option>
												@foreach ($target as $target)
													<option value="{{ $target->id }}">{{ $target->name }}</option>
												@endforeach
											</select>
										</div>
										<x-button class="col-span-12 inline-flex w-fit items-center gap-x-2" color="info" type="submit">
											<span wire:loading.remove>
												<i class="fas fa-filter"></i>
											</span>
											<span wire:loading class="animate-spin">
												<i class="fas fa-circle-notch"></i>
											</span>
											Filter {{ $master }}
										</x-button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div> --}}
			</div>
		</div>
		<div class="grid grid-cols-12 gap-4">
			@foreach ($instrumens as $instrumen)
				<a href="{{ route('survey.show', $instrumen->id) }}" class="flex cursor-pointer flex-col gap-x-4 gap-y-2 rounded-lg border border-slate-100 bg-white p-8 shadow-sm transition-colors hover:border-color-info-500 lg:col-span-4">
					<div class="flex max-w-lg flex-col gap-y-2">
						<p class="text-base font-bold">{{ $instrumen->name }}</p>
						<div class="flex flex-col gap-y-2">
							<div class="inline-flex items-center gap-x-2 text-xs">
								<span>
									<i class="fas fa-book"></i>
								</span>
								<p><span class="font-semibold">Standar:</span> {{ $instrumen->standar->name }}</p>
							</div>
							<div class="inline-flex items-center gap-x-2 text-xs">
								<span>
									<i class="fas fa-clipboard-list"></i>
								</span>
								<p><span class="font-semibold">Tipe Audit:</span> {{ $instrumen->tipe }}</p>
							</div>
							<div class="inline-flex items-center gap-x-2 text-xs">
								<span>
									<i class="fas fa-user-tie"></i>
								</span>
								<p><span class="font-semibold">Auditor Ketua:</span> {{ $instrumen->ketua->name }}</p>
							</div>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	</section>
@endsection
