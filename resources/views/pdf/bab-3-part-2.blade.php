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
			<img src="{{ public_path('images/report-3-1.png') }}" alt="Gambar" style="width: 250px">
			<div>
				<b>Gambar 1. Ketercapain Kriteria</b>
			</div>
		</div>
		<p class="paragraf">
			Berdasarkan gambar di atas, terlihat bahwa kriteria visi misi dan mahasiswa
			memiliki persentase terendah yakni sebesar 75%, walaupun demikian, pada umumnya
			semua kriteria sebesar sudah berada pada skor yang sangat memuaskan dengan
			persentase rata-rata sebesar 91,17%
		</p>
		<p class="paragraf">
			Berdasarkan jenis ketidak sesuaian pada gambar 2 di bawah, kita dapat ketahui
			bahwa ketidak sesuaian yang bersifat obeservasi (OBS) sebanya 2 pada kriteria visi misi
			dan kemahasiswaan. Sedangkan kriteria ketidaksesuaian (KTS) ada 1 yaitu pada kriteria
			pendidikan.
		</p>
		<div style="text-align: center;">
			<img src="{{ public_path('images/report-3-2.png') }}" alt="Gambar" style="width: 250px">
			<div>
				<b>Gambar 2. Jenis Ketidaksesuaian</b>
			</div>
		</div>
	</body>

</html>
