@extends('layouts.app', [
    'title' => 'Detail Instrumen',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Detail Instrumen</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Instrumen' => route('dashboard.master.instrumens.index'),
				    $instrumen->name => null,
				]" />
			</div>
			<div class="flex gap-3">
				<x-button :href="route('dashboard.master.instrumens.edit', $instrumen->uuid)" color="success">
					Edit
				</x-button>
				<x-button color="danger">
					Hapus
				</x-button>
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<div class="overflow-x-auto text-sm">
				<table id="datatable" class="cell-border stripe">
					<thead>
						<td></td>
						<td></td>
					</thead>
					<tbody>
						<tr>
							<th>Instrumen</th>
							<td>{{ $instrumen->name }}</td>
						</tr>
						<tr>
							<th>Standar</th>
							<td>
								<a href="{{ route('dashboard.master.standars.edit', $instrumen->standar->uuid) }}" class="text-color-info-500 underline">{{ $instrumen->standar->name }}</a>
							</td>
						</tr>
						<tr>
							<th>Tipe</th>
							<td>{{ $instrumen->tipe }}</td>
						</tr>
						<tr>
							<th>Periode</th>
							<td>{{ $instrumen->periode }}</td>
						</tr>
						<tr>
							<th>Ketua Auditor</th>
							<td>{{ $instrumen->ketua->user->name }}</td>
						</tr>
						<tr>
							<th>Anggota Auditor</th>
							<td>
								<ul>
									@foreach ($instrumen->anggota as $anggota)
										<li>{{ $anggota->user->name }}</li>
									@endforeach
								</ul>
							</td>
						</tr>
					</tbody>
				</table>
		</x-main.card>
	</x-main.section>
@endsection
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
	<script>
		let table = new DataTable('#datatable', {
			searching: false,
			paging: false,
			ordering: false,
			info: false,
			header: false
		});
	</script>
@endpush
