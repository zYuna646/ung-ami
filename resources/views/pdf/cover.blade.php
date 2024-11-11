<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Cover - Laporan AMI {{ $program->program_name }} Tahun {{ $periode->year }}</title>
		<style>
			@page {
				margin: 2cm;
			}

			body {
				font-family: 'Helvetica', sans-serif;
				color: #333;
				margin: 0;
				padding: 0;
				text-align: center;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
				height: 100vh;
			}

			.container {
				text-align: center;
			}

			.container img {
				width: 150px;
				margin: 6rem 0;
			}

			.title {
				font-size: 24px;
				font-weight: 700;
				color: #333;
			}

			.subtitle {
				font-size: 24px;
				font-weight: 700;
				color: #333;
			}
		</style>
	</head>

	<body>
		<div class="container">
			<div class="title">Laporan Audit Mutu Internal</div>
			<img src="{{ public_path('images/ung.png') }}" alt="Logo Universitas">
			<div class="subtitle">
				Fakultas {{ $program->department->faculty->faculty_name }}
			</div>
			<div class="subtitle">
				Program Studi {{ $program->program_name }}
			</div>
			<div class="subtitle">
				Tahun {{ $periode->year }}
			</div>
		</div>
	</body>

</html>
