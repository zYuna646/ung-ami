<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>BAB V - Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
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
		<h5 class="heading-1">
			BAB V <br> <br>
			KESIMUPULAN DAN SARAN
		</h5>

		<h6 class="heading-2">5.1. KESIMPULAN</h6>
		<p class="paragraf">
			Berdasarkan data yang diperoleh saat melakukan audit, pada umumnya semua
			kriteria pada prodi {{ $program->program_name }} sudah memperoleh skor persentase rata-rata sebesar {{ $averageCompliance }}%
			atau berada pada kriteia yang {{ $averageCompliance > 50 ? 'sangat memuaskan' : 'perlu ditingkatkan' }}. Dengan persentase terendah yaitu kriteria {{ $lowestCompliance['name'] }} sebesar {{ $lowestCompliance['compliance_percentage'] }}%.
			Selain itu, Berdasarkan jenis ketidaksesuaian, 
			@foreach ($kriteria as $item)
				<span>{{ $item['name'] }} memiliki ketidaksesuaian dengan kategori OBS sebanyak {{ $item['count']['obs'] }} dan kategori KTS sebanyak {{ $item['count']['kts'] }}.</span> 
			@endforeach
		</p>

		<h6 class="heading-2">5.2. SARAN</h6>
		@php
			$auditReport = $program
					->auditReports()
					->where('periode_id', $periode->id)
					->get()
					->last();
		@endphp
		<div class="paragraf">
			{!! $auditReport?->pivot?->saran !!}
		</div>
		{{-- <p class="paragraf">
			Melalui kesempatan ini, tim auditor menyarankan beberapa masukan, antara lain:
		</p>
		<ol class="number-list">
			<li>Setiap Kebijakan dilakukan evaluasi keterlaksanaannya dan lakukan tindak lanjutnya dari hasil evaluasi</li>
			<li>Ketercapaian yang sudah diraih harap lebih ditingkatkan lagi pada tahun-tahun berikutnya</li>
			<li>Ketersedian dana penunjang kegiatan, kiranya dapat ditingkatkan dengan melakukan kerjasama dengan instansi/lembaga yang ada baik local, nasional maupun ineternasional</li>
			<li>Mendorong DTPS untuk membuat RPS, agar semua matakuliah memiliki RPS sebagai pedoman dalam melaksanakan perkuliahan.</li>
		</ol> --}}

	</body>

</html>
