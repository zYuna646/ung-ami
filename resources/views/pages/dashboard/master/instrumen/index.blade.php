@extends('layouts.app', [
    'title' => 'Master Instrumen',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Master Instrumen</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Instrumen' => null,
				]" />
			</div>
			<div>
				<x-button :href="route('dashboard.master.instrumens.create')" color="info">
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
							<th>Instrumen</th>
							<th>Ketua</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($instrumens as $instrumen)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $instrumen->name }}</td>
								<td>{{ $instrumen->ketua->user->name }}</td>
								<td>
									<div class="inline-flex gap-x-2">
										<x-button :href="route('dashboard.master.instrumens.show', $instrumen->uuid)" color="info" size="sm">
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
