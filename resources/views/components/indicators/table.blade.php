<div class="overflow-x-auto text-sm">
	<table id="indicators-table" class="cell-border stripe">
		<thead>
			<tr>
				<th>No.</th>
				<th>Indikator</th>
				<th>Jumlah Pertanyaan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($indicators as $indicator)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $indicator->name }}</td>
					<td>
						{{ $indicator->questions->count() }}
					</td>
					<td>
						<div class="flex flex-col gap-2 sm:flex-row">
							<x-indicators.edit :$periode :$instrument :$indicator size="sm" />
							<x-button.delete :action="route('dashboard.master.periodes.instruments.indicators.destroy', [$periode->uuid, $instrument->uuid, $indicator->uuid])" color="danger" size="sm">
								<p>Anda akan menghapus data berikut: </p>
								<dl class="max-w-md divide-y divide-gray-200 text-gray-900">
									<div class="flex flex-col pb-3">
										<dt class="mb-1 text-gray-500">ID</dt>
										<dd class="font-semibold">{{ $indicator->uuid }}</dd>
									</div>
									<div class="flex flex-col pt-3">
										<dt class="mb-1 text-gray-500">Indikator</dt>
										<dd class="font-semibold">{{ $indicator->name }}</dd>
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
		new DataTable('#indicators-table', {
			pageLength: -1,
			dom: 'frt',
			ordering: false
		});
	</script>
@endpush
