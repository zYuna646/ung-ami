@extends('layouts.app', [
    'title' => 'Hasil Audit Lapangan Ketidaksesuaian',
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
		<div class="flex flex-col items-start justify-between gap-y-2 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-semibold uppercase">Audit Lapangan</h1>
				<p class="text-xl uppercase text-slate-500">Hasil Audit Lapangan Ketidaksesuaian</p>
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

		<div>
			Hasil Audit Lapangan Ketidaksesuaian
		</div>
	</section>
@endsection
