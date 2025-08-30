<!DOCTYPE html>
<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berita Acara - AMI UNG {{ $program->program_name }} Tahun {{ $periode->year }}</title>
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        /* Word-specific page setup */
        @page Section1 {
            size: 595.3pt 841.9pt; /* A4 */
            margin: 2cm 2cm 2cm 2cm;
            mso-page-orientation: portrait;
        }
        div.Section1 { page: Section1; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }

        * {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img { -ms-interpolation-mode: bicubic; }

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

        .signoff th,
        .signoff td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }

        .signature-box {
            height: 70px;
            border-bottom: 1px solid #000;
            margin: 16px 0 8px 0;
        }
    </style>
</head>

<body>
    <div class="Section1">
    <table class="kop-surat">
        <tr>
            <td style="width: 20%;">
                <img src="{{ asset('images/ung.png') }}" alt="Logo">
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
    <table class="audit-detail">
        <tr>
            <th>Area Audit</th>
            <td>:</td>
            <td>
                {{ $instruments->flatMap(function ($instrument) {return $instrument->units->pluck('unit_name');})->unique()->implode(', ') }}
            </td>
        </tr>
        <tr>
            <th>Auditee</th>
            <td>:</td>
            <td>Pelaksana Standar</td>
        </tr>
        <tr>
            <th>Auditor</th>
            <td>:</td>
            <td>Ketua Tim Auditor; Anggota Tim Auditor</td>
        </tr>
        <tr>
            <th>Lingkup Audit</th>
            <td>:</td>
            <td>{{ implode(', ', $instruments->pluck('name')->toArray()) }}</td>
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
    <p style="text-align: justify; margin-top: 16px;">
        Dari hasil pelaksanaan Audit lapangan atas pelaksanaan standar
        <strong>{{ implode(', ', $instruments->pluck('name')->toArray()) }}</strong>,
        diperoleh hasil sebagai berikut:
    </p>
    <ol>
        <li>Kesesuaian (petunjuk penulisan dijelaskan apa saja temuan hasil AMI Kesesuaian)</li>
        <li>Observasi ditemukan (petunjuk penulisan dijelaskan apa saja temuan hasil AMI Observasi)</li>
        <li>KTS Minor ditemukan (petunjuk penulisan dijelaskan apa saja temuan hasil AMI KTS Minor)</li>
        <li>KTS Mayor ditemukan (petunjuk penulisan dijelaskan apa saja temuan hasil AMI KTS Mayor)</li>
    </ol>

    <p style="text-align: justify;">
        Dari hasil temuan AMI telah disampaikan rekomendasi perbaikan/koreksi untuk temuan yang bersifat Observasi dan KTS Minor sebagai berikut:
    </p>
    <ol>
        <li>Rekomendasi untuk temuan Observasi</li>
        <li>Rekomendasi untuk temuan KTS Minor</li>
    </ol>

    <p style="text-align: justify;">
        (Jika ada temuan Observasi yang telah ditindaklanjuti) Dalam pelaksanaan Audit Lapangan temuan Observasi yang telah ditindaklanjuti sebagai berikut:
    </p>
    <ol>
        <li>(tuliskan RTL yang telah direalisasikan)</li>
        <li>(tuliskan RTL yang telah direalisasikan)</li>
    </ol>

    <p style="text-align: justify;">
        (Jika ada temuan KTS Minor yang telah ditindaklanjuti) Dalam pelaksanaan Audit Lapangan temuan KTS Minor yang telah ditindaklanjuti sebagai berikut:
    </p>
    <ol>
        <li>(tuliskan RTL yang telah direalisasikan)</li>
        <li>(tuliskan RTL yang telah direalisasikan)</li>
    </ol>

    <p style="text-align: justify;">
        Demikian berita acara pelaksanaan Audit Lapangan ini dibuat dengan sebenarnya setelah dibaca dan diketahui oleh auditor dan auditee.
    </p>

    <br>
    <table class="signoff">
        <thead>
            <tr>
                <th>Disusun</th>
                <th>Disetujui</th>
                <th>Validasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Tanda tangan
                    <div class="signature-box"></div>
                    Tanggal: ______________________
                </td>
                <td>
                    Tanda tangan
                    <div class="signature-box"></div>
                    Tanggal: ______________________
                </td>
                <td>
                    Tanda tangan
                    <div class="signature-box"></div>
                    Tanggal: ______________________
                </td>
            </tr>
        </tbody>
    </table>
    </div>

    </body>
    </html>
