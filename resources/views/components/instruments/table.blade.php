<div class="overflow-x-auto text-sm">
	<table id="instruments-table" class="cell-border stripe">
		<thead>
			<tr>
				<th>No.</th>
				<th>Instrumen</th>
				<th>Jumlah Indikator</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($instruments as $instrument)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $instrument->name }}</td>
					<td>{{ $instrument->indicators->count() }}</td>
					<td>
						<div class="flex gap-2">
							<x-button :href="route('dashboard.master.instruments.show', $instrument->uuid)" color="info" size="sm">
								Detail
							</x-button>
							<x-button.delete :action="route('dashboard.master.instruments.destroy', $instrument->uuid)" color="danger" size="sm">
								<p>Anda akan menghapus data berikut: </p>
								<dl class="max-w-md divide-y divide-gray-200 text-gray-900">
									<div class="flex flex-col pb-3">
										<dt class="mb-1 text-gray-500">ID</dt>
										<dd class="font-semibold">{{ $instrument->uuid }}</dd>
									</div>
									<div class="flex flex-col pt-3">
										<dt class="mb-1 text-gray-500">Instrumen</dt>
										<dd class="font-semibold">{{ $instrument->name }}</dd>
									</div>
								</dl>
							</x-button.delete>
						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@push('scripts2')
	<script>
		new DataTable('#instruments-table', {
			pageLength: -1,
			dom: 'frt',
			ordering: false
		});
	</script>
@endpush
