<div class="overflow-x-auto text-sm">


    <table id="programs-table" class="cell-border stripe">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Program</th>
                <th>Sesuai</th>
                <th>Tidak Sesuai</th>
                <th>Total</th>
                <th>Capaian Kinerja</th>
                <th>Berita Acara</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $program)
                @php
                    $auditReport = $program['program']
                        ->auditReports()
                        ->where('periode_id', $periode->id)
                        ->get()
                        ->last();
                    $evidences = json_decode($auditReport?->pivot?->activity_evidences);
                    $PTPs = $program['sesuai'];
                    $PTKs = $program['ptk'];
                    $KTS = $program['kts'];
                    $OBS = $program['obs'];
                    $tidak_sesuai = $program['tidak_sesuai'];
                    $sesuai = $program['sesuai'];
                    // $OBS = abs($program['obs']->count() - $KTS);
                    $total_sum = $PTPs + $PTKs + $OBS;
                    $selisih = abs($total_sum - $total);
                    $OBS = $OBS - $selisih;
                    if ($OBS < 0) {
                        $PTKs = $PTKs + $OBS;
                        $PTKs = $PTKs < 0 ? 0 : $PTKs;
                        $OBS = 0;
                    }

                    if ($OBS + $PTKs < $tidak_sesuai) {
                        $PTKs = ($tidak_sesuai - ($OBS + $PTKs));
                    }

                    $total_sum = $PTPs + $PTKs + $OBS;
                    $score = $total > 0 ? number_format(($sesuai / $total) * 100, 2) : 0;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $program['program']->program_name }}</td>
                    <td>{{ $sesuai }}</td>
                    <td>{{ $tidak_sesuai }}</td>
                    <td>{{ $total_sum }}</td>
                    <td>{{ $score }}%</td>
                    <td>
                        @isset($auditReport->pivot->meeting_report)
                            <p style="color: green;">Berita acara sudah diunggah.</p>
                        @else
                            <p style="color: red;">Berita acara belum diunggah.</p>
                        @endisset
                    </td>
                    <td>
                        @if (isset($evidences) && count($evidences) > 0)
                            <p style="color: green;">Bukti kegiatan sudah diunggah.</p>
                        @else
                            <p style="color: red;">Bukti kegiatan belum diunggah.</p>
                        @endif
                    </td>
                    <td>
                        <div x-data="{ open: false }" class="relative">
                            <x-button @click="open = !open" color="info" size="sm">
                                Unduh
                                <i class="fa-solid fa-chevron-down ms-2"></i>
                            </x-button>

                            <div x-cloak x-show="open" @click.away="open = false"
                                class="absolute right-0 z-10 mt-2 w-32 rounded-md bg-white shadow-lg">
                                <ul class="py-1">
                                    <li>
                                        <a href="{{ route('report.cover', [$periode->uuid, $program['program']->uuid]) }}"
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            COVER
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.bab1', [$periode->uuid, $program['program']->uuid]) }}"
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            BAB I
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.bab2', [$periode->uuid, $program['program']->uuid]) }}"
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            BAB II
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.bab3', [$periode->uuid, $program['program']->uuid]) }}"
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            BAB III
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.bab4', [$periode->uuid, $program['program']->uuid]) }}"
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            BAB IV
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.bab5', [$periode->uuid, $program['program']->uuid]) }}"
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            BAB V
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.lampiran', [$periode->uuid, $program['program']->uuid]) }}"
                                            target="_blank"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            LAMPIRAN
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('report.full', [$periode->uuid, $program['program']->uuid]) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            FULL
                                            <i class="fa-solid fa-download float-end ms-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

@push('scripts2')
    <script>
        new DataTable('#programs-table', {
            pageLength: -1,
            dom: 'frt',
            ordering: false
        });
    </script>
@endpush
