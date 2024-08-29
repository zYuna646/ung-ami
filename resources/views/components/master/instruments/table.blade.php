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
					<td>{{ $instrument->instrument }}</td>
					<td>{{ $instrument->indicators->count() }}</td>
					<td>
						<div class="flex gap-2">
							<x-button :href="route('dashboard.master.instruments.show', $instrument->uuid)" color="info" size="sm">
								Detail
							</x-button>
							<x-master.instruments.edit :$instrument size="sm" />
							<x-master.instruments.delete :$instrument size="sm" />
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
