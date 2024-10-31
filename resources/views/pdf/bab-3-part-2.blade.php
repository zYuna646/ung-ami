<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
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
				text-indent: 25px;
				line-height: 2em;
			}
		</style>
	</head>

	<body>
		<h6 class="heading-2" style="margin-bottom: 0;">3.2. ANALISIS PENCAPAIAN STANDAR</h6>
		<p class="paragraf">
			Berdasarkan data yang diperoleh saat wawancara dengan auditi, selanjutnya data tersebut
			diolah dan dianalisis dengan menggunakan statistika sederhana sebagaimana gambar di
			bawah ini
		</p>
		<div style="text-align: center;">
			@php
				// Calculate the percentage for Kesesuaian and Ketidaksesuaian
				$kesesuaianData = array_map(fn($item) => $item['count']['totalAuditResult'] > 0 ? number_format(($item['count']['kesesuaian'] / $item['count']['totalAuditResult']) * 100, 1) : 0, $kriteria);

				$ketidaksesuaianData = array_map(fn($item) => $item['count']['totalAuditResult'] > 0 ? number_format(($item['count']['ketidaksesuaian'] / $item['count']['totalAuditResult']) * 100, 1) : 0, $kriteria);

				$chartData = [
				    'type' => 'bar',
				    'data' => [
				        'labels' => array_column($kriteria, 'name'),
				        'datasets' => [
				            [
				                'label' => 'Kesesuaian (%)',
				                'data' => $kesesuaianData,
				                'backgroundColor' => 'blue',
				            ],
				            [
				                'label' => 'Ketidaksesuaian (%)',
				                'data' => $ketidaksesuaianData,
				                'backgroundColor' => 'red',
				            ],
				        ],
				    ],
				    'options' => [
				        'scales' => [
				            'yAxes' => [['ticks' => ['beginAtZero' => true, 'max' => 100]]],
				        ],
				    ],
				];

				$chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartData));

				// Fetch the chart image and convert to Base64
				$imageData = file_get_contents($chartUrl);
				$base64 = base64_encode($imageData);
				$src = 'data:image/png;base64,' . $base64; // Set the data type
			@endphp
			<img
				src="{{ $src }}"
				alt="{{ $chartUrl }}"
				style="max-width: 50%; margin: 0 auto; display: block;"
			>
			<div>
				<b>Gambar 1. Ketercapain Kriteria</b>
			</div>
		</div>
		<p class="paragraf">
			Berdasarkan gambar di atas, terlihat bahwa kriteria <b>{{ $lowestCompliance['name'] }}</b>
			memiliki persentase terendah yakni sebesar {{ $lowestCompliance['compliance_percentage'] }}%.
			{!! $averageCompliance > 50
			    ? 'Walaupun demikian, pada umumnya
															semua kriteria sudah berada pada skor yang <b>sangat memuaskan</b>'
			    : 'Selain itu, semua kriteria berada pada skor yang <b>perlu ditingkatkan</b>, ' !!}
			dengan persentase rata-rata sebesar {{ $averageCompliance }}%
		</p>
		<p class="paragraf">
			Berdasarkan jenis ketidaksesuaian pada gambar 2 di bawah, kita dapat mengetahui
			bahwa
			@foreach ($kriteria as $item)
				<span><b>{{ $item['name'] }}</b> memiliki ketidaksesuaian dengan kategori OBS sebanyak {{ $item['count']['obs'] }} dan kategori KTS sebanyak {{ $item['count']['kts'] }}.</span> 
			@endforeach
		</p>
		<div style="text-align: center;">
			@php
				$chartData2 = [
				    'type' => 'bar',
				    'data' => [
				        'labels' => array_column($kriteria, 'name'),
				        'datasets' => [
				            [
				                'label' => 'OBS',
				                'data' => array_map(fn($item) => $item['count']['obs'], $kriteria),
				                'backgroundColor' => 'yellow',
				            ],
				            [
				                'label' => 'KTS',
				                'data' => array_map(fn($item) => $item['count']['kts'], $kriteria),
				                'backgroundColor' => 'purple',
				            ],
				        ],
				    ],
				];

				$chartUrl2 = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartData2));

				// Fetch the chart image and convert to Base64
				$imageData = file_get_contents($chartUrl2);
				$base64 = base64_encode($imageData);
				$src2 = 'data:image/png;base64,' . $base64; // Set the data type
			@endphp
			<img
				src="{{ $src2 }}"
				alt="{{ $chartUrl2 }}"
				style="max-width: 50%; margin: 0 auto; display: block;"
			>
			<div>
				<b>Gambar 2. Jenis Ketidaksesuaian</b>
			</div>
		</div>
	</body>

</html>
