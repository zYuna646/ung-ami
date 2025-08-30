@extends('layouts.app', [
    'title' => 'Detail Survei',
])
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
    <x-main.section>
        <div
            class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <h1 class="text-lg font-bold">Detail Survei</h1>
                <x-main.breadcrumb :data="[
                    'Dasbor' => route('dashboard.index'),
                    'Master Survei' => route('dashboard.master.periodes.index'),
                    $periode->periode_name => null,
                ]" />
            </div>
            <div class="flex gap-3">
                <x-button :href="route('dashboard.master.periodes.edit', $periode->uuid)" color="success">
                    Edit
                </x-button>
                <x-button.delete :action="route('dashboard.master.periodes.destroy', $periode->uuid)">
                    <p>Anda akan menghapus data berikut:</p>
                    <x-main.list :items="[
                        (object) [
                            'label' => 'ID',
                            'value' => $periode->uuid,
                        ],
                        (object) [
                            'label' => 'Periode',
                            'value' => $periode->formatted_start_date . ' - ' . $periode->formatted_end_date,
                        ],
                    ]" />
                </x-button.delete>
            </div>
        </div>
    </x-main.section>
    <x-main.section class="grid grid-cols-1 items-start gap-6 sm:grid-cols-3">
        <x-main.card>
            <x-main.list :items="[
                (object) [
                    'label' => 'Nama',
                    'value' => $periode->periode_name,
                ],
                (object) [
                    'label' => 'Tahun',
                    'value' => $periode->year,
                ],
                (object) [
                    'label' => 'Periode',
                    'value' => $periode->formatted_start_date . ' - ' . $periode->formatted_end_date,
                ],
                (object) [
                    'label' => 'Tipe',
                    'value' => $periode->tipe,
                ],
            ]" />
        </x-main.card>
        <div class="col-span-2 grid gap-6">
            <x-main.card>
                <div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
                    <h5 class="text-lg font-bold">Daftar Instrumen</h5>
                    <x-instruments.add :$periode :$units :$masterInstruments />
                </div>

                <x-instruments.table :$periode />
            </x-main.card>

            <x-main.card>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('dashboard.master.periode.export.rangking', $periode) }}"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        <i class="fa-solid fa-file-excel mr-2"></i> Unduh Excel
                    </a>
                    <!-- Tombol Trigger Modal -->
                    <!-- Tombol Trigger Modal -->
                    <button type="button" onclick="openModal()"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500">
                        <i class="fa-solid fa-file-excel mr-2"></i> Export RTM
                    </button>

                    <!-- Modal -->
                    <div id="exportRTMModal"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden"
                        aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg mx-4">
                            <!-- Modal Header -->
                            <div class="px-6 py-4 border-b">
                                <h2 id="modal-title" class="text-xl font-semibold text-gray-800">Export RTM</h2>
                            </div>
                            <!-- Modal Body -->
                            <div class="px-6 py-4">
                                <form action="{{ route('dashboard.master.periode.export.rtm', $periode) }}" method="GET">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <!-- Select Fakultas -->
                                        <div>
                                            <label for="fakultas"
                                                class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                                            <select name="fakultas" id="fakultas"
                                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                                                <option value="">-- Pilih Fakultas --</option>
                                                @foreach ($fakultas as $f)
                                                    <option value="{{ $f->id }}">{{ $f->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Select Prodi -->
                                        {{-- <div>
                                            <label for="prodi"
                                                class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                            <select name="prodi" id="prodi"
                                                class="block w-full rounded-md border border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                                                <option value="">-- Pilih Program Studi --</option>
                                                @foreach ($prodi as $p)
                                                    <!-- Pastikan setiap prodi memiliki field department_id -->
                                                    <option value="{{ $p->id }}"
                                                        data-department_id="{{ $p->department_id }}">{{ $p->program_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                    </div>
                                    <!-- Modal Footer / Aksi -->
                                    <div class="mt-8 flex justify-end space-x-4">
                                        <button type="button" onclick="closeModal()"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <i class="fa-solid fa-file-excel mr-2"></i> Unduh RTM
                                        </button>
                                    </div>
                                </form>

                             

                            </div>
                        </div>
                    </div>

                    <!-- Script untuk membuka/tutup modal -->

                    <!-- Script untuk membuka/tutup modal -->

                </div>
                <div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
                    <h5 class="text-lg font-bold">Daftar Laporan</h5>
                    {{-- <x-instruments.add :$periode :$units :$masterInstruments /> --}}
                </div>
                <x-survey.report :$data :$periode :$total />
            </x-main.card>
        </div>


    </x-main.section>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script>
        function openModal() {
            document.getElementById('exportRTMModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('exportRTMModal').classList.add('hidden');
        }
    </script>
       <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fakultasSelect = document.getElementById('fakultas');
            var prodiSelect = document.getElementById('prodi');

            fakultasSelect.addEventListener('change', function() {
                var selectedFakultas = this.value;

                // Tampilkan/hide opsi prodi berdasarkan data-department_id
                Array.from(prodiSelect.options).forEach(function(option) {
                    // Tampilkan opsi default selalu
                    if (option.value === '') {
                        option.style.display = 'block';
                        return;
                    }
                    if (selectedFakultas === '' || option.getAttribute('data-department_id') ===
                        selectedFakultas) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Reset pilihan prodi
                prodiSelect.value = '';
            });
        });
    </script>

@endpush
