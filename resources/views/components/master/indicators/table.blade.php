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
					<td>{{ $indicator->indicator }}</td>
					<td>{{ $indicator->questions->count() }}</td>
					<td>
						<div class="flex gap-2">
							<x-master.indicators.edit :$indicator size="sm" />
							<x-master.indicators.delete :$indicator size="sm" />
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
