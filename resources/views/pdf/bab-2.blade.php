<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>BAB II - Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
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

			.list {
				list-style-type: decimal;
				margin-left: 25px;
				padding: 0px;
				line-height: 2em;
			}

			.list li {
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
			BAB II <br> <br>
			METODE PELAKSANAAN AMI
		</h5>

		<h6 class="heading-2">2.1. TUJUAN AUDIT</h6>
		<p class="paragraf">
			Audit internal ini dilakukan dalam rangka memotret apakah:
		</p>
		<ol class="list" style="list-style-type: lower-alpha">
			<li>Memastikan apakah temuan/rencana tindakan koreksi pada Siklus Audit tahun sebelumnya telah ditindaklanjuti.</li>
			<li>Memastikan kesesuaian arah dan pelaksanaan penjaminan mutu Fakultas {{ $program->department->faculty->faculty_name }} terhadap Dokumen Akademik Universitas, Dokumen Akademik Pascasarjana dan Dokumen Mutu Fakultas {{ $program->department->faculty->faculty_name }}</li>
			<li>Memetakan kesiapan Fakultas {{ $program->department->faculty->faculty_name }} dalam melaksanakan program Akreditasi/sertifikasi</li>
			<li>Memastikan kelancaran pelaksanaan pengelolaan Fakultas {{ $program->department->faculty->faculty_name }}</li>
			<li>Memetakan peluang peningkatan mutu Fakultas {{ $program->department->faculty->faculty_name }}</li>
		</ol>

		<h6 class="heading-2">2.2. LINGKUP AUDIT</h6>
		<ol class="list">
			<li>Visi, Misi, Tujuan dan Strategi Program Studi</li>
			<li>Mahasiswa</li>
			<li>Sumber daya manusia</li>
			<li>Pendidikan</li>
			<li>Penelitian</li>
			<li>Pengabdian kepada masyarakat</li>
			<li>Luaran dan capaian Tri Dharma</li>
		</ol>

		<h6 class="heading-2">2.3. AREA AUDIT</h6>
		<p class="paragraf">
			Area Audit Mutu Internal tahun {{ $periode->year }} adalah UPPS dan Program Studi.
		</p>

		<h6 class="heading-2">2.4. JADWAL PELAKSANAAN AUDIT</h6>
		<p class="paragraf">
			Pelaksanaan dilakukan dari tanggal {{ $periode->formatted_start_date }} sampai {{ $periode->formatted_end_date }}.
		</p>
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Kegiatan</th>
					<th>Pihak Yang Terlibat</th>
					<th>Waktu Pelaksanaan</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>Sosialisasi Instrumen</td>
					<td>LPMPP</td>
					<td></td>
				</tr>
				<tr>
					<td>2</td>
					<td>Pengajuan Laporan Kinerja Prodi (Prodi Mengisi Instrumen AMI Secara Digital)</td>
					<td>Prodi</td>
					<td></td>
				</tr>
				<tr>
					<td>3</td>
					<td>Audit Dokumen</td>
					<td>Auditor</td>
					<td>{{ $periode->formatted_start_date }} - {{ $periode->formatted_end_date }}</td>
				</tr>
				<tr>
					<td>4</td>
					<td>Audit Lapangan</td>
					<td>Auditor, Auditie</td>
					<td>{{ $periode->formatted_start_date }} - {{ $periode->formatted_end_date }}</td>
				</tr>
				<tr>
					<td>5</td>
					<td>Menyusun Laporan Audit</td>
					<td>Auditor</td>
					<td></td>
				</tr>
				<tr>
					<td>6</td>
					<td>Rapat Tinjauan Manajemen (RTM)</td>
					<td>Pimpinan, Penjamin Mutu, UPPS, Prodi</td>
					<td></td>
				</tr>
				<tr>
					<td>7</td>
					<td>Menyusun Rencana Tindak Lanjut</td>
					<td>UPPS, Prodi, Penjamin Mutu Fakultas dan Prodi</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</body>

</html>
