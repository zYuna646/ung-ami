<div class="overflow-x-auto text-sm">
	<table id="questions-table" class="cell-border stripe">
		<thead>
			<tr>
				<th>Kode</th>
				<th>Pertanyaan</th>
				<th>Area Audit</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($questions as $question)
				<tr>
					<td>{{ $question->code }}</td>
					<td>{{ $question->text }}</td>
					<td>{{ $question->units->isNotEmpty() ? $question->units->pluck('unit_name')->implode(', ') : '-' }}</td>
					<td>
						<div class="flex flex-col gap-2 sm:flex-row">
							<x-button :href="route('dashboard.master.periodes.instruments.indicators.questions.edit', [$periode->uuid, $instrument->uuid, $indicator->uuid, $question->uuid])" color="success" size="sm">
								Edit
							</x-button>
							<x-button.delete :action="route('dashboard.master.periodes.instruments.indicators.questions.destroy', [$periode->uuid, $instrument->uuid, $indicator->uuid, $question->uuid])" color="danger" size="sm">
								<p>Anda akan menghapus data berikut: </p>
								<dl class="max-w-md divide-y divide-gray-200 text-gray-900">
									<div class="flex flex-col pb-3">
										<dt class="mb-1 text-gray-500">ID</dt>
										<dd class="font-semibold">{{ $question->uuid }}</dd>
									</div>
									<div class="flex flex-col py-3">
										<dt class="mb-1 text-gray-500">Kode</dt>
										<dd class="font-semibold">{{ $question->code }}</dd>
									</div>
									<div class="flex flex-col pt-3">
										<dt class="mb-1 text-gray-500">Pertanyaan</dt>
										<dd class="font-semibold">{{ $question->text }}</dd>
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
		new DataTable('#questions-table', {
			pageLength: -1,
			dom: 'frt',
			ordering: false
		});
	</script>
@endpush
