<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berita Acara - AMI UNG {{ $program->program_name }} Tahun {{ $periode->year }}</title>
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
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-surat img {
            width: 80px;
        }

        .kop-surat td {
            vertical-align: middle;
            text-align: center;
            border: 1px solid #000;
            padding: 10px;
        }

        .kop-header h4 {
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .kop-header h3 {
            margin: 0;
            padding: 0;
            font-size: 16px;
        }

        .kop-header p {
            margin: 0;
            font-size: 12px;
        }

        .kop-no-doc {
            text-align: right;
            font-size: 12px;
        }

        .heading-1 {
            text-align: center;
            font-size: 14px;
        }

        .audit-detail {
            width: 60%;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .audit-detail th,
        .audit-detail td {
            text-align: left;
            vertical-align: top;
        }

        .audit-detail th,
        .audit-detail td {
            text-align: left;
            vertical-align: top;
        }

        .audit-detail th {
            width: 90px;
        }

        .audit-detail th {
            padding-right: 20px;
        }

        .daftar-hadir th,
        .daftar-hadir td {
            /* vertical-align: middle;
    text-align: center; */
            border: 1px solid #000;
            padding: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <table class="kop-surat">
        <tr>
            <td style="width: 20%;">
                <img src="{{ public_path('images/ung.png') }}" alt="Logo">
            </td>
            <td class="kop-header" style="width: 60%;">
                <h4>KEMENTERIAN PENDIDIKAN KEBUDAYAAN RISET DAN TEKNOLOGI<br>UNIVERSITAS NEGERI GORONTALO</h4>
                <p>Jalan Jendral Sudirman No.6 Kota Gorontalo, Telp: 0435-821698</p>
            </td>
            <td class="kop-no-doc" style="width: 20%;">
                <strong>
                    NO. DOKUMEN: <br>
                    {{ $periode->code }}
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="kop-header">
                <h3>
                    BERITA ACARA PELAKSANAAN<br>
                    AUDIT LAPANGAN
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="kop-header" style="text-align: justify;">
                Pada hari ini {{ \Carbon\Carbon::parse($data['berita_acara_date'])->translatedFormat('l') }},
                {{ \Carbon\Carbon::parse($data['berita_acara_date'])->translatedFormat('d F Y') }}
                bertempat di Ruang Sidang Program Studi {{ $program->program_name }} telah dilaksanakan Audit Lapangan
                sebagai tahapan pelaksanaan Audit Mutu Internal (AMI) Periode Tahun Akademik
				{{ now()->subYear()->format('Y') }}/{{ now()->format('Y') }}, sebagai berikut:
            </td>

        </tr>
    </table>
    <h5 class="heading-1">
        DAFTAR HADIR <br>
        PELAKSANAAN AUDIT MUTU INTERNAL
    </h5>
    <table class="audit-detail">
        <tr>
            <th>Standar</th>
            <td>:</td>
            <td>
                {{ implode(', ', $instruments->pluck('name')->toArray()) }}
            </td>
        </tr>
        <tr>
            <th>Area Audit</th>
            <td>:</td>
            <td>
                {{ $instruments->flatMap(function ($instrument) {return $instrument->units->pluck('unit_name');})->unique()->implode(', ') }}
            </td>
        </tr>
        <tr>
            <th>Tanggal Audit</th>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($data['berita_acara_date'])->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <th>Tempat Audit</th>
            <td>:</td>
            <td>Kantor Ketua Program Studi {{ $program->program_name }}, Fakultas
                {{ $program->department->faculty->faculty_name }}, Universitas Negeri Gorontalo</td>
        </tr>
    </table>
    <table class="daftar-hadir">
        <thead>
            <tr>
                <th>Identitas</th>
                <th>Nama</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pelaksana Standar</td>
                <td>Koordinator Program Studi {{ $program->program_name }} / {{ $data['kaprodi_name'] }}</td>
                <td></td>
            </tr>

            @php
                $chiefs = $instruments
                    ->map(
                        fn($instrument) => $instrument->entityTeam(
                            $program->user->entityId(),
                            $program->user->entityType(),
                        )->chief->user ?? null,
                    )
                    ->unique();
                $members = $instruments
                    ->flatMap(
                        fn($instrument) => $instrument
                            ->entityTeam($program->user->entityId(), $program->user->entityType())
                            ->members->pluck('user'),
                    )
                    ->unique();
            @endphp

            @if ($chiefs->isNotEmpty())
                <tr>
                    <td rowspan="{{ $chiefs->count() }}">Ketua Tim Auditor</td>
                    @foreach ($chiefs as $index => $chief)
                        @if ($index == 0)
                            <td>{{ $chief->name ?? '-' }}</td>
                            <td></td>
                        @else
                </tr>
                <tr>
                    <td>{{ $chief->name ?? '-' }}</td>
                    <td></td>
            @endif
            @endforeach
            </tr>
            @endif

            @if ($members->isNotEmpty())
                <tr>
                    <td rowspan="{{ $members->count() }}">Anggota Tim Auditor</td>
                    @foreach ($members as $index => $member)
                        @if ($index == 0)
                            <td>{{ $member->name }}</td>
                            <td></td>
                        @else
                </tr>
                <tr>
                    <td>{{ $member->name }}</td>
                    <td></td>
            @endif
            @endforeach
            </tr>
        @else
            <tr>
                <td>Anggota Tim Auditor</td>
                <td>-</td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>

</html>
