<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>BAB III - Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
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
				/* text-align: center; */
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
			}
		</style>
	</head>

	<body>
		<h5 class="heading-1">
			BAB III <br> <br>
			HASIL DAN ANALISIS AUDIT MUTU INTERNAL
		</h5>

		{{-- Kesesuaian --}}
		<h6 class="heading-2">
			3.1. HASIL PENCAPAIAN PELAKSANAAN STANDAR <br> <br>
			3.1.1. KESESUAIAN KRITERIA
		</h6>
		@foreach ($instruments as $instrument)
			<div class="kop">
				<h5 class="heading-1">
					PUSAT PENGEMBANGAN STANDAR, AMI DAN MANAJEMEN RESIKO<br>
					LEMBAGA PENJAMIN MUTU DAN PENGEMBANGAN PEMBELAJARAN <br>
					UNIVERSITAS NEGERI GORONTALO <br>
					Jln. Jend. Sudirman No. 6 Kota Gorontalo <br>
					<a href="#">penjamu@ung.ac.id</a>
				</h5>
			</div>
			<h5 class="heading-1">
				AUDIT LAPANGAN <br>
				HASIL AUDIT LAPANGAN KESESUAIAN
			</h5>
			<table class="audit-detail">
				<tr>
					<th>Standar</th>
					<td>: {{ $instrument->name }}</td>
				</tr>
				<tr>
					<th>Area Audit</th>
					<td>: {{ $instrument->units->pluck('unit_name')->implode(', ') }}</td>
				</tr>
				<tr>
					<th>Auditee</th>
					<td>: {{ $instrument->auditees()->implode(', ') }}</td>
				</tr>
				<tr>
					<th>Tipe Audit</th>
					<td>: {{ $periode->tipe }}</td>
				</tr>
				<tr>
					<th>Periode Audit</th>
					<td>: Tahun {{ $periode->year }}</td>
				</tr>
				<tr>
					<th>Auditor</th>
					<td>
						: Ketua: {{ $instrument->entityTeam($model->user->entityId(), $model->user->entityType())->chief->user->name ?? '-' }} <br>
						: Anggota: {{ optional($instrument->entityTeam($model->user->entityId(), $model->user->entityType()))->members?->pluck('user.name')->implode(', ') ?? '-' }}
					</td>
				</tr>
				<tr>
					<th>Kode Dokumen</th>
					<td>: {{ $periode->code }}</td>
				</tr>
			</table>
			<table class="table">
				<tr>
					<th>CHECK LIST</th>
					<th>DAFTAR PERTANYAAN</th>
					<th>DESKRIPSI HASIL AUDIT</th>
					<th>FAKTOR PENDUKUNG KEBERHASILAN</th>
				</tr>
				@foreach ($instrument->questions as $question)
					@php
						$response = $model->complianceResults->firstWhere('question_id', $question->id);
						$auditResult = $model->auditResults->firstWhere('question_id', $question->id);
					@endphp
					@if ($auditResult?->compliance == 'Sesuai')
						<tr>
							<td style="text-align: center;">{{ $question->code }}</td>
							<td>{{ $question->text }}</td>
							<td>{{ $response->description ?? '-' }}</td>
							<td>{{ $response->success_factors ?? '-' }}</td>
						</tr>
					@endif
				@endforeach
			</table>
		@endforeach

		{{-- Ketidaksesuaian Kriteria --}}
		<h6 class="heading-2">3.1.2. KETIDAKSESUAIAN KRITERIA</h6>
		@foreach ($instruments as $instrument)
			<div class="kop">
				<h5 class="heading-1">
					PUSAT PENGEMBANGAN STANDAR, AMI DAN MANAJEMEN RESIKO<br>
					LEMBAGA PENJAMIN MUTU DAN PENGEMBANGAN PEMBELAJARAN <br>
					UNIVERSITAS NEGERI GORONTALO <br>
					Jln. Jend. Sudirman No. 6 Kota Gorontalo <br>
					<a href="#">penjamu@ung.ac.id</a>
				</h5>
			</div>
			<h5 class="heading-1">
				AUDIT LAPANGAN <br>
				HASIL AUDIT LAPANGAN KETIDAKSESUAIAN
			</h5>
			<table class="audit-detail">
				<tr>
					<th>Standar</th>
					<td>: {{ $instrument->name }}</td>
				</tr>
				<tr>
					<th>Area Audit</th>
					<td>: {{ $instrument->units->pluck('unit_name')->implode(', ') }}</td>
				</tr>
				<tr>
					<th>Auditee</th>
					<td>: {{ $instrument->auditees()->implode(', ') }}</td>
				</tr>
				<tr>
					<th>Tipe Audit</th>
					<td>: {{ $periode->tipe }}</td>
				</tr>
				<tr>
					<th>Periode Audit</th>
					<td>: Tahun {{ $periode->year }}</td>
				</tr>
				<tr>
					<th>Auditor</th>
					<td>
						: Ketua: {{ $instrument->entityTeam($model->user->entityId(), $model->user->entityType())->chief->user->name ?? '-' }} <br>
						: Anggota: {{ optional($instrument->entityTeam($model->user->entityId(), $model->user->entityType()))->members?->pluck('user.name')->implode(', ') ?? '-' }}
					</td>
				</tr>
				<tr>
					<th>Kode Dokumen</th>
					<td>: {{ $periode->code }}</td>
				</tr>
			</table>
			<table class="table">
				<tr>
					<th>CHECK LIST</th>
					<th>DESKRIPSI HASIL AUDIT</th>
					<th>KATEGORI TEMUAN AUDIT (OBS / KTS)</th>
					<th>AKAR PENYEBAB / FAKTOR PENGHAMBAT</th>
				</tr>
				@foreach ($instrument->questions as $question)
					@php
						$response = $model->noncomplianceResults->firstWhere('question_id', $question->id);
						$auditResult = $model->auditResults->firstWhere('question_id', $question->id);
					@endphp
					@if ($auditResult?->compliance == 'Tidak Sesuai')
						<tr>
							<td style="text-align: center;">{{ $question->code }}</td>
							<td>{{ $response->description ?? '-' }}</td>
							<td style="text-align: center;">{{ $response->category ?? '-' }}</td>
							<td>{{ $response->barriers ?? '-' }}</td>
						</tr>
					@endif
				@endforeach
			</table>
		@endforeach
	</body>

</html>
