@extends('layouts.app', [
    'title' => 'Master Survei',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Master Survei</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Survei' => null,
				]" />
			</div>
			<div>
				<x-button :href="route('dashboard.master.periodes.create')" color="info">
					Tambah Data
				</x-button>
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<div class="overflow-x-auto text-sm">
				<table id="datatable" class="cell-border stripe">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Periode</th>
							<th>Tahun</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($periodes as $periode)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $periode->periode_name }}</td>
								<td>{{ $periode->formatted_start_date }} - {{ $periode->formatted_end_date }}</td>
								<td>{{ $periode->year }}</td>
								<td>
									<div class="inline-flex gap-x-2">
										<x-button :href="route('dashboard.master.periodes.show', $periode->uuid)" color="info" size="sm">
											Detail
										</x-button>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</x-main.card>
	</x-main.section>
@endsection
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
	<script>
		let table = new DataTable('#datatable');
	</script>
@endpush
