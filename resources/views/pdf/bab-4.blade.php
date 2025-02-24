<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>BAB IV - Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
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
		<h5 class="heading-1">
			BAB IV <br> <br>
			RENCANA TINDAK LANJUT
		</h5>

		{{-- PTK --}}
		<h6 class="heading-2">4.1. RENCANA PERBAIKAN</h6>
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
				PERMINTAAN TINDAKAN KOREKSI KATEGORI KTS (PTK)
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
						: Ketua: {{ $instrument->entityTeam($program->user->entityId(), $program->user->entityType())->chief->user->name ?? '-' }} <br>
						: Anggota: {{ optional($instrument->entityTeam($program->user->entityId(), $program->user->entityType()))->members?->pluck('user.name')->implode(', ') ?? '-' }}
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
					<th>AKAR PENYEBAB / FAKTOR PENGHAMBAT</th>
					<th>REKOMENDASI</th>
					<th>RENCANA PERBAIKAN</th>
					<th>JADWAL PENYELESAIAN</th>
					<th>MEKANISME MONITORING</th>
					<th>PIHAK YANG BERTANGGUNG JAWAB</th>
				</tr>
				@foreach ($instrument->questions as $question)
					@php
						$response = $program->PTKs->firstWhere('question_id', $question->id);
						$auditResult = $program->auditResults->firstWhere('question_id', $question->id);
						$noncomplianceResult = $program->noncomplianceResults->firstWhere('question_id', $question->id);
					@endphp
					@if ($auditResult?->compliance == 'Tidak Sesuai' && $noncomplianceResult?->category == 'KTS')
						<tr>
							<td style="text-align: center;">{{ $question->code }}</td>
							<td>{{ $auditResult->description ?? '-' }}</td>
							<td>{{ $noncomplianceResult->barriers ?? '-' }}</td>
							<td>{{ $response->recommendations ?? '-' }}</td>
							<td>{{ $response->improvement_plan ?? '-' }}</td>
							<td>{{ $response->completion_schedule ?? '-' }}</td>
							<td>{{ $response->monitoring_mechanism ?? '-' }}</td>
							<td>{{ $response->responsible_party ?? '-' }}</td>
						</tr>
					@endif
				@endforeach
			</table>
		@endforeach
		<table class="ttd">
			<tr>
				<td>
					<h5 style="margin: 0;">Auditee</h5>
					<table>
						<tr>
							<td style="text-align: left;">Tanggal</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align: left; padding: 20px 0;">Tanda Tangan</td>
							<td>:</td>
							<td></td>
						</tr>
					</table>
				</td>
				<td>
					<h5 style="margin: 0;">Auditor</h5>
					<table>
						<tr>
							<td style="text-align: left;">Tanggal</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align: left; padding: 20px 0;">Tanda Tangan</td>
							<td>:</td>
							<td></td>
						</tr>
					</table>
				</td>
				<td>
					<h5 style="margin: 0;">Divalidasi Penjamin Mutu</h5>
					<table>
						<tr>
							<td style="text-align: left;">Tanggal</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align: left; padding: 20px 0;">Tanda Tangan</td>
							<td>:</td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		{{-- PTP --}}
		<h6 class="heading-2">4.2. RENCANA TINDAKAN</h6>
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
				PERMINTAAN TINDAKAN PENINGKATAN (PTP)
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
						: Ketua: {{ $instrument->entityTeam($program->user->entityId(), $program->user->entityType())->chief->user->name ?? '-' }} <br>
						: Anggota: {{ optional($instrument->entityTeam($program->user->entityId(), $program->user->entityType()))->members?->pluck('user.name')->implode(', ') ?? '-' }}
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
					<th>DESKRIPSI TEMUAN AUDIT</th>
					<th>FAKTOR PENDUKUNG KEBERHASILAN</th>
					<th>REKOMENDASI</th>
					<th>RENCANA PENINGKATAN</th>
					<th>JADWAL PENYELESAIAN</th>
					<th>PIHAK BERTANGGUNG JAWAB</th>
				</tr>
				@foreach ($instrument->questions as $question)
					@php
						$response = $program->PTPs->firstWhere('question_id', $question->id);
						$auditResult = $program->auditResults->firstWhere('question_id', $question->id);
						$complianceResult = $program->complianceResults->firstWhere('question_id', $question->id);
					@endphp
					@if ($auditResult?->compliance == 'Sesuai')
						<tr>
							<td style="text-align: center;">{{ $question->code }}</td>
							<td>{{ $auditResult->description ?? '-' }}</td>
							<td>{{ $complianceResult->success_factors ?? '-' }}</td>
							<td>{{ $response->recommendations ?? '-' }}</td>
							<td>{{ $response->improvement_plan ?? '-' }}</td>
							<td>{{ $response->completion_schedule ?? '-' }}</td>
							<td>{{ $response->responsible_party ?? '-' }}</td>
						</tr>
					@endif
				@endforeach
			</table>
		@endforeach
		<table class="ttd">
			<tr>
				<td>
					<h5 style="margin: 0;">Auditee</h5>
					<table>
						<tr>
							<td style="text-align: left;">Tanggal</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align: left; padding: 20px 0;">Tanda Tangan</td>
							<td>:</td>
							<td></td>
						</tr>
					</table>
				</td>
				<td>
					<h5 style="margin: 0;">Auditor</h5>
					<table>
						<tr>
							<td style="text-align: left;">Tanggal</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align: left; padding: 20px 0;">Tanda Tangan</td>
							<td>:</td>
							<td></td>
						</tr>
					</table>
				</td>
				<td>
					<h5 style="margin: 0;">Divalidasi Penjamin Mutu</h5>
					<table>
						<tr>
							<td style="text-align: left;">Tanggal</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align: left; padding: 20px 0;">Tanda Tangan</td>
							<td>:</td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>

</html>
