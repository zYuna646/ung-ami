<div class="overflow-x-auto text-sm">
	<table id="instruments-table" class="cell-border stripe">
		<thead>
			<tr>
				<th>Instrumen</th>
				<th>Area</th>
				<th>Jumlah Indikator</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($periode->instruments as $instrument)
				<tr>
					<td>{{ $instrument->name }}</td>
					<td>{{ $instrument->units->pluck('unit_name')->implode(', ') }}</td>
					<td>{{ $instrument->indicators->count() }}</td>
					<td>
						<div class="flex gap-2">
							<x-button :href="route('dashboard.master.periodes.instruments.show', [$periode->uuid, $instrument->uuid])" color="info" size="sm">
								Detail
							</x-button>
							<x-button :href="route('dashboard.master.periodes.instruments.edit', [$periode->uuid, $instrument->uuid])" color="success" size="sm">
								Edit
							</x-button>
							<x-instruments.delete :$periode :$instrument size="sm" />
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
