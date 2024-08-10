@extends('layouts.app', [
    'title' => 'Dasbor',
])
@section('content')
	<section class="mx-auto grid max-w-screen-xl grid-cols-12 gap-4 px-8 pt-10">
		<!--[if BLOCK]><![endif]-->
		<div class="col-span-3 flex items-center gap-x-4 rounded-md border border-neutral-100 bg-white p-8 shadow-sm">
			<div class="text-4xl">
				<span class="text-color-primary-500">
					<i class="fas fa-university"></i>
				</span>
			</div>
			<div class="flex flex-col">
				<p class="text-2xl font-bold">12</p>
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
				<p class="text-2xl font-bold">24</p>
				<p class="text-sm font-semibold text-slate-500">Total Prodi</p>
			</div>
		</div>
		<div class="col-span-3 flex items-center gap-x-4 rounded-md border border-neutral-100 bg-white p-8 shadow-sm">
			<div class="text-4xl">
				<span class="text-color-primary-500">
					<i class="fas fa-clipboard-check"></i>
				</span>
			</div>
			<div class="flex flex-col">
				<p class="text-2xl font-bold">50</p>
				<p class="text-sm font-semibold text-slate-500">Total Survey</p>
			</div>
		</div>
		<div class="col-span-3 flex items-center gap-x-4 rounded-md border border-neutral-100 bg-white p-8 shadow-sm">
			<div class="text-4xl">
				<span class="text-color-primary-500">
					<i class="fas fa-users"></i>
				</span>
			</div>
			<div class="flex flex-col">
				<p class="text-2xl font-bold">560</p>
				<p class="text-sm font-semibold text-slate-500">Total Responden</p>
			</div>
		</div>
		<!--[if ENDBLOCK]><![endif]-->
	</section>
@endsection
