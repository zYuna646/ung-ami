@extends('layouts.app', [
    'title' => 'Edit Instrumen',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Instrumen</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Instrumen' => route('dashboard.master.instrumens.index'),
				    $instrumen->name => route('dashboard.master.instrumens.show', $instrumen->uuid),
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.instrumens.update', $instrumen->uuid) }}" method="POST" class="flex flex-col gap-5">
				@csrf
				@method('PUT')
				<x-form.input name="name" label="Instrumen" placeholder="Isi instrumen" :value="$instrumen->name" />
				<x-form.select name="standar_id" label="Standar" :value="$instrumen->standar_id" :options="$standars->map(function ($standar) {
				    return (object) [
				        'label' => $standar->name,
				        'value' => $standar->id,
				    ];
				})" />
				<x-form.input name="tipe" label="Tipe" placeholder="Isi tipe" :value="$instrumen->tipe" />
				<x-form.input name="periode" label="Periode" placeholder="Isi periode" type="number" min="1998" max="2099" :value="$instrumen->periode" />
				<x-form.select name="ketua_id" label="Ketua Auditor" :value="$instrumen->ketua_id" :options="$availableToBeLeader->map(function ($auditor) {
				    return (object) [
				        'label' => $auditor->user->name,
				        'value' => $auditor->id,
				    ];
				})" />
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
				<h5 class="text-lg font-bold">Daftar Anggota Auditor</h5>
				<div x-data="{ addAnggotaModal: false }">
					<x-button @click="addAnggotaModal = true" color="info" size="sm">
						Tambah Data
					</x-button>
					<div x-cloak x-show="addAnggotaModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
						<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
							<div class="flex items-center justify-between border-b pb-4">
								<h3 class="text-lg font-bold">Tambah Anggota Auditor</h3>
								<button type="button" @click="addAnggotaModal = false" class="text-gray-400 hover:text-gray-900">
									<i class="fas fa-times"></i>
								</button>
							</div>
							<div class="p-4">
								<form action="{{ route('dashboard.master.instrumens.add_member', $instrumen->uuid) }}" method="POST" class="flex flex-col gap-5">
									@csrf
									<x-form.select name="auditor_id" label="Anggota" :options="$availableToBeMember->map(function ($auditor) {
									    return (object) [
									        'label' => $auditor->user->name,
									        'value' => $auditor->id,
									    ];
									})" />
									<div class="flex justify-end gap-2">
										<x-button @click="addAnggotaModal = false" color="default">Batal</x-button>
										<x-button type="submit" color="info">Submit</x-button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="overflow-x-auto text-sm">
				<table id="member-table" class="cell-border stripe">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($instrumen->anggota as $anggota)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $anggota->user->name }}</td>
								<td>
									<div x-data="{ deleteMemberModal: false }">
										<x-button @click="deleteMemberModal = true" color="danger" size="sm">
											Hapus
										</x-button>
										<div x-cloak x-show="deleteMemberModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
											<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
												<div class="flex items-center justify-between border-b pb-4">
													<h3 class="text-lg font-bold">Hapus Anggota Auditor</h3>
													<button type="button" @click="deleteMemberModal = false" class="text-gray-400 hover:text-gray-900">
														<i class="fas fa-times"></i>
													</button>
												</div>
												<div class="p-4">
													<form action="{{ route('dashboard.master.instrumens.delete_member', ['instrumen' => $instrumen->uuid, 'auditor' => $anggota->user->auditor->uuid]) }}" method="POST" class="flex flex-col gap-5">
														@csrf
														@method('DELETE')
														<p>Data yang telah dihapus, tidak dapat dikembalikan.</p>
														<div class="flex justify-end gap-2">
															<x-button @click="deleteMemberModal = false" color="default">Batal</x-button>
															<x-button type="submit" color="danger">Hapus</x-button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</x-main.card>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<div class="mb-3 flex flex-col items-start gap-3 sm:flex-row sm:justify-between">
				<h5 class="text-lg font-bold">Daftar Indikator</h5>
				<div x-data="{ addIndicatorModal: false }">
					<x-button @click="addIndicatorModal = true" color="info" size="sm">
						Tambah Data
					</x-button>
					<div x-cloak x-show="addIndicatorModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
						<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
							<div class="flex items-center justify-between border-b pb-4">
								<h3 class="text-lg font-bold">Tambah Indikator</h3>
								<button type="button" @click="addIndicatorModal = false" class="text-gray-400 hover:text-gray-900">
									<i class="fas fa-times"></i>
								</button>
							</div>
							<div class="p-4">
								<form action="{{ route('dashboard.master.indikators.store', $instrumen->uuid) }}" method="POST" class="flex flex-col gap-5">
									@csrf
									<x-form.input name="name" label="Indikator" placeholder="Isi indikator" />
									<input type="hidden" name="instrumen_id" value="{{ $instrumen->id }}">
									<div class="flex justify-end gap-2">
										<x-button @click="addIndicatorModal = false" color="default">Batal</x-button>
										<x-button type="submit" color="info">Submit</x-button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="overflow-x-auto text-sm">
				<table id="indicator-table" class="cell-border stripe">
					<thead>
						<tr>
							<th>No.</th>
							<th>Indikator</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($instrumen->indikator as $indikator)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $indikator->name }}</td>
								<td>
									<x-button :href="route('dashboard.master.indikators.show', $indikator->uuid)" color="info" size="sm">
										Detail
									</x-button>
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
		new DataTable('#member-table');
		new DataTable('#indicator-table');
	</script>
@endpush
