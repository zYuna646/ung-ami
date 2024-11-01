<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>BAB I - Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
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
			BAB I <br> <br>
			PENDAHULUAN
		</h5>
		<p class="paragraf">
			Dalam rangka meningkatkan pelaksanaan sistem penjaminan mutu pendidikan tinggi
			yang diselenggarakan oleh Universitas Negeri Gorontalo maka LPMPP melaksanakan Audit
			Mutu Internal (AMI) tahun {{ $periode->year }}. Hal ini perlu dilakukan agar penyelenggaraan pendidikan
			tinggi di UNG dapat terselenggara dengan perencanaan yang matang dan berkelanjutan.
			Kegiatan audit ini dilakukan untuk memotret sampai sejauh mana pelaksanaan sistem
			pejaminan mutu yang telah dilaksanakan oleh program studi, fakultas, lembaga maupun
			universitas agar mampu mengawal capaian VMTS UNG Unggul dan berdaya saing dan
			mampu mempertahankan peringkat akreditasi perguruan tinggi maksimal (Unggul).
		</p>
		<p class="paragraf">
			Audit Mutu Internal (AMI) pada tahun {{ $periode->year }} ini menggunakan instrumen revisi dari
			instrumen yang digunakan pada tahun {{ $periode->year - 1 }}, dimana pada instrument kali ini
			mengkombinasikan instrumen penilaian akreditasi yang digunakan pada BAN-PT, LAMDIK,
			LAMSAMA dan beberapa LAM lainnya. Adapun tujuan penggunaan instrument penilaian dari
			BAN-PT maupun beberapa LAM yang ada adalah untuk membiasakan prodi maupun fakultas
			dalam menjamin keberlangsungan sistem penjaminan mutu sekaligus menyiapkan diri untuk
			akreditasi
		</p>
		<p class="paragraf">
			AMI {{ $periode->year }} ini meliputi beberapa kriteria yang ada dalam instrumen akreditasi, antara
			lain kriteria visi misi tujuan dan strategi, kemahasiswaan, Sumber Daya Manusia, Pendidikan,
			Penelitian dan Pengabdian yang keseluruhan butir pertanyaanya bersumber pad matriks
			penilaian akreditasi.
		</p>
	</body>

</html>
