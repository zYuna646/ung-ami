<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportRTM implements FromCollection, WithEvents
{
    protected $rtm;

    /**
     * Konstruktor untuk menerima data RTM
     *
     * @param array $rtm
     */
    public function __construct(array $rtm)
    {
        $this->rtm = $rtm;
    }

    /**
     * Return collection untuk diexport ke Excel
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $rows = [];

        // Header global (opsional)
        $rows[] = [
            'No.',
            'Standar',
            'Sesuai',
            'Tidak Sesuai',
            'Capaian Kinerja',
            'Analisis Masalah Dan Pemecahannya',
            'Target Penyelesaian'
        ];

        $no = 1;
        // Looping setiap instrument (grup)tapi
        foreach ($this->rtm as $instrumentKey => $rtmRows) {
            // Sisipkan baris header grup untuk instrument
            $rows[] = [
                $instrumentKey, // bisa berupa id atau nama instrument
                '', '', '', '', '', '', '', ''
            ];

            // Looping setiap data pertanyaan dalam instrument tersebut
            foreach ($rtmRows as $row) {
                $rows[] = [
                    $row['code'],   // Standar: misalnya kode standar
                    $row['desc'],   // Deskripsi RTM
                    $row['ptp'] === 0 ? '0' : $row['ptp'], // PTP (pastikan 0 tampil sebagai "0")
                    $row['kts'] === 0 ? '0' : $row['kts'], // KTS
                    $row['score'] . '%'   // Capaian (Score)
                ];
            }
        }

        return new Collection($rows);
    }

    /**
     * Register events untuk mengatur styling sheet agar tampil lebih rapi.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Atur lebar kolom agar tampilan lebih rapi
                $sheet->getColumnDimension('A')->setWidth(8);   // No.
                $sheet->getColumnDimension('B')->setWidth(40);  // Standar
                $sheet->getColumnDimension('C')->setWidth(10);  // PTP
                $sheet->getColumnDimension('D')->setWidth(10);  // KTS
                $sheet->getColumnDimension('E')->setWidth(10);  // OBS
                $sheet->getColumnDimension('F')->setWidth(18);  // Capaian Kinerja
                $sheet->getColumnDimension('G')->setWidth(25);  // Rencana Tindak Lanjut
                // $sheet->getColumnDimension('H')->setWidth(20);  // Target Penyelesaian

                // Terapkan border ke seluruh sel agar tampilan rapi
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Style header global (baris pertama)
                $sheet->getStyle('A1:G1')->getFont()->setBold(true);
                $sheet->getStyle('A1:G1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFB6C1'); // Warna header (light pink)

                // Style untuk baris grup instrument
                // Asumsi: baris grup instrument memiliki kolom B yang kosong
                for ($row = 2; $row <= $highestRow; $row++) {
                    if (trim($sheet->getCell("B{$row}")->getValue()) === '') {
                        // Merge seluruh kolom pada baris grup
                        $sheet->mergeCells("A{$row}:G{$row}");
                        $sheet->getStyle("A{$row}")->getFont()->setBold(true);
                        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle("A{$row}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFEFD5'); // Warna latar belakang group header (light)
                    }
                }
            },
        ];
    }
}
