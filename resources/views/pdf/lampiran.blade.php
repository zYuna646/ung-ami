<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Lampiran - Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
		<style>
			@page {
				margin-top: 2cm;
				margin-bottom: 2cm;
				margin-left: 2cm;
				margin-right: 2cm;
			}

			body {
				font-family: 'Helvetica', sans-serif;
				margin: 0;
			}

			* {
				font-size: 12;
			}

			.heading-1 {
				text-align: center;
			}

			.heading-2 {
				margin-bottom: 0;
			}

			.kop {
				border-bottom: 1px solid black;
			}

			.audit-detail {
				margin: 0 auto;
				margin-bottom: 20px;
			}

			.audit-detail th,
			.audit-detail td {
				text-align: left;
				vertical-align: top;
			}

			.audit-detail th {
				padding-right: 20px;
			}

			.table {
				width: 100%;
				border-collapse: collapse;
				margin-bottom: 20px;
			}

			.table th,
			.table td {
				border: 1px solid #000;
				padding: 8px;
			}

			.table th {
				text-align: center;
				vertical-align: middle;
			}

			.table td {
				text-align: left;
				vertical-align: top;
			}

			.paragraf {
				text-align: justify;
				text-indent: 25px;
				line-height: 2em;
			}

			.number-list {
				list-style-type: decimal;
				margin-left: 25px;
				padding: 0px;
				line-height: 2em;
			}

			.number-list li {
				text-align: justify;
			}

			.ttd {
				width: 100%;
			}

			.ttd td {
				width: 33.33%;
				text-align: center;
			}
		</style>
	</head>

	<body>
		@php
			$auditReport = $program
			    ->auditReports()
			    ->where('periode_id', $periode->id)
			    ->get()
			    ->last();

			$evidences = json_decode($auditReport?->pivot?->activity_evidences);
		@endphp
		<div style="page-break-inside: avoid;">
			<h5 class="heading-1" style="margin-bottom: 0;">LAMPIRAN</h5>
			@isset($auditReport->pivot->meeting_report)
				<p class="heading-2" style="text-align: center; margin-bottom: 20px;">BERITA ACARA</p>
				<img style="width: 100%; height: auto; max-height: 88%; max-width: 100%;" src="{{ public_path('storage/audits/' . $auditReport->pivot->meeting_report) }}" />
			@else
				<p style="color: red;">Berita acara belum diunggah.</p>
			@endisset
		</div>

		<div>
			@if (isset($evidences) && count($evidences) > 0)
				<p class="heading-2" style="text-align: center; margin-bottom: 20px;">DOKUMENTASI KEGIATAN</p>
				@foreach ($evidences as $evidence)
					<img style="width: 100%; height: auto;" src="{{ public_path('storage/audits/' . $evidence) }}" />
				@endforeach
			@else
				<p style="color: red;">Bukti kegiatan belum diunggah.</p>
			@endif
		</div>
	</body>

</html>
