<div class="overflow-x-auto text-sm">
	<table id="questions-table" class="cell-border stripe">
		<thead>
			<tr>
				<th>Kode</th>
				<th>Pertanyaan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($questions as $question)
				<tr>
					<td>{{ $question->code }}</td>
					<td>{{ $question->question }}</td>
					<td>
						<div class="flex gap-2">
							<x-master.questions.edit :$question size="sm" />
							<x-master.questions.delete :$question size="sm" />
						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@push('scripts2')
	<script>
		new DataTable('#questions-table', {
			pageLength: -1,
			dom: 'frt',
			ordering: false
		});
	</script>
@endpush
