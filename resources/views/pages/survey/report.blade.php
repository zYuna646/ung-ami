@extends('layouts.app', [
    'title' => 'Laporan',
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
					<p class="text-xl uppercase text-slate-500">Laporan</p>
				</div>
			</div>
		</x-main.card>
		<div class="grid grid-cols-1 items-start gap-6 sm:grid-cols-3">
			<x-survey.detail :$instrument />
			<div class="col-span-2 space-y-6">
				<x-main.card>
					<h5 class="mb-3 font-semibold">Laporan AMI</h5>
					<div class="space-x-3">
						<x-button href="#" color="success">
							Pratinjau
							<i class="fa-solid fa-eye ms-2"></i>
						</x-button>
						<x-button href="#" color="success">
							Unduh
							<i class="fa-solid fa-download ms-2"></i>
						</x-button>
					</div>
				</x-main.card>
				<x-main.card>
					<h5 class="mb-3 font-semibold">Berita Acara</h5>
					@if ($auditStatus->meeting_report_url)
						<iframe src="{{ $auditStatus->meeting_report_url }}" width="100%" height="600px">
							This browser does not support PDFs. Please download the PDF to view it:
							<a href="{{ $auditStatus->meeting_report_url }}">Download PDF</a>
						</iframe>
					@else
						<p>No meeting report available.</p>
					@endif
				</x-main.card>
				<x-main.card>
					<h5 class="mb-3 font-semibold">Dokumentasi Kegiatan</h5>
					<img src="{{ $auditStatus->activity_evidence_url }}" alt="Dokumentasi Kegiatan" class="w-full">
				</x-main.card>
			</div>
		</div>
	</section>
@endsection
