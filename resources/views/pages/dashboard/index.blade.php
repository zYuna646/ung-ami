@extends('layouts.app', [
    'title' => 'Dasbor',
])
@section('content')
	<section class="mx-auto grid max-w-screen-xl grid-cols-12 gap-4 px-8 pt-10">
		<div class="col-span-3 flex items-center gap-x-4 rounded-md border border-neutral-100 bg-white p-8 shadow-sm">
			<div class="text-4xl">
				<span class="text-color-primary-500">
					<i class="fas fa-building"></i>
				</span>
			</div>
			<div class="flex flex-col">
				<p class="text-2xl font-bold">{{ $counts->units }}</p>
				<p class="text-sm font-semibold text-slate-500">Total Badan & UPT</p>
			</div>
		</div>
		<div class="col-span-3 flex items-center gap-x-4 rounded-md border border-neutral-100 bg-white p-8 shadow-sm">
			<div class="text-4xl">
				<span class="text-color-primary-500">
					<i class="fas fa-university"></i>
				</span>
			</div>
			<div class="flex flex-col">
				<p class="text-2xl font-bold">{{ $counts->faculties }}</p>
				<p class="text-sm font-semibold text-slate-500">Total Fakultas</p>
			</div>
		</div>
		<div class="col-span-3 flex items-center gap-x-4 rounded-md border border-neutral-100 bg-white p-8 shadow-sm">
			<div class="text-4xl">
				<span class="text-color-primary-500">
					<i class="fas fa-graduation-cap"></i>
				</span>
			</div>
			<div class="flex flex-col">
				<p class="text-2xl font-bold">{{ $counts->departments }}</p>
				<p class="text-sm font-semibold text-slate-500">Total Jurusan</p>
			</div>
		</div>
		<div class="col-span-3 flex items-center gap-x-4 rounded-md border border-neutral-100 bg-white p-8 shadow-sm">
			<div class="text-4xl">
				<span class="text-color-primary-500">
					<i class="fas fa-chalkboard-teacher"></i>
				</span>
			</div>
			<div class="flex flex-col">
				<p class="text-2xl font-bold">{{ $counts->programs }}</p>
				<p class="text-sm font-semibold text-slate-500">Total Program Studi</p>
			</div>
		</div>
	</section>
@endsection
