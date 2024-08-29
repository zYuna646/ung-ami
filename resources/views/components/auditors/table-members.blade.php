<div class="overflow-x-auto text-sm">
	<table id="auditor-member-table" class="cell-border stripe">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($auditors as $auditor)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>
						<a class="text-blue-500 underline" href="{{ route('dashboard.users.auditors.edit', $auditor->uuid) }}">
							{{ $auditor->user->name }}
						</a>
						@if ($auditor->id == $periode->chief_auditor_id)
							<span class="ms-2">(Ketua)</span>
						@endif
					</td>
					<td>
						<div class="flex gap-2">
							@if ($auditor->id != $periode->chief_auditor_id)
								<x-button.delete :action="route('dashboard.master.periodes.delete_member', ['periode' => $periode->uuid, 'auditor' => $auditor->user->auditor->uuid])" size="sm">
									<p>Anda akan menghapus data berikut: </p>
									<dl class="max-w-md divide-y divide-gray-200 text-gray-900">
										<div class="flex flex-col pb-3">
											<dt class="mb-1 text-gray-500">ID</dt>
											<dd class="font-semibold">{{ $auditor->uuid }}</dd>
										</div>
										<div class="flex flex-col py-3">
											<dt class="mb-1 text-gray-500">Nama</dt>
											<dd class="font-semibold">{{ $auditor->user->name }}</dd>
										</div>
										<div class="flex flex-col pt-3">
											<dt class="mb-1 text-gray-500">Email</dt>
											<dd class="font-semibold">{{ $auditor->user->email }}</dd>
										</div>
									</dl>
								</x-button.delete>
							@endif
						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@push('scripts2')
	<script>
		new DataTable('#auditor-member-table');
	</script>
@endpush
