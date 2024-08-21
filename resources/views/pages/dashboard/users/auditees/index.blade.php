@extends('layouts.app', [
    'title' => 'Auditi',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Auditi</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Auditi' => null,
				]" />
			</div>
			<div class="flex gap-3">
				<x-form.select name="type" :value="request('type')" x-data="{ type: '{{ request('type') }}' }" x-on:change="window.location.href = '{{ route('dashboard.users.auditees.index') }}' + '?type=' + $event.target.value" :options="[
				    (object) [
				        'label' => 'Badan & UPT',
				        'value' => 'unit',
				    ],
				    (object) [
				        'label' => 'Fakultas',
				        'value' => 'faculty',
				    ],
				    (object) [
				        'label' => 'Jurusan',
				        'value' => 'department',
				    ],
				    (object) [
				        'label' => 'Program Studi',
				        'value' => 'program',
				    ],
				]" />
				<x-button :href="route('dashboard.users.auditees.create')" color="info">
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
							<th>Email</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>
									<div class="inline-flex gap-x-2">
										<x-button :href="route('dashboard.users.auditees.edit', $user->email)" color="success" size="sm">
											Edit
										</x-button>
										{{-- @can('delete', $user)
											<x-button.delete :action="route('dashboard.users.auditees.destroy', $user->uuid)" size="sm">
												<p>Anda akan menghapus data berikut: </p>
												<dl class="max-w-md divide-y divide-gray-200 text-gray-900">
													<div class="flex flex-col pb-3">
														<dt class="mb-1 text-gray-500">ID</dt>
														<dd class="font-semibold">{{ $user->uuid }}</dd>
													</div>
													<div class="flex flex-col py-3">
														<dt class="mb-1 text-gray-500">Nama</dt>
														<dd class="font-semibold">{{ $user->user->name }}</dd>
													</div>
													<div class="flex flex-col pt-3">
														<dt class="mb-1 text-gray-500">Email</dt>
														<dd class="font-semibold">{{ $user->user->email }}</dd>
													</div>
												</dl>
											</x-button.delete>
										@endcan --}}
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
