<div class="overflow-x-auto text-sm">
	<table id="areas-table" class="cell-border stripe">
		<thead>
			<tr>
				<th>Area</th>
				<th>Tim Pelaksana</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($areas as $area)
				<tr>
					<td>
						@if ($area->faculty_name)
							Fakultas {{ $area->faculty_name }}
						@elseif($area->program_name)
							Program Studi {{ $area->program_name }}
						@else
							{{ $area->unit_name }}
						@endif
					</td>
					<td>
						@php
							$data = $instrument
							    ->entityTeams()
							    ->where('entity_id', $area->id)
							    ->where('entity_type', class_basename($area))
							    ->first();
						@endphp
						@if ($data?->team)
							<p><b>Ketua:</b> {{ $data->team->chief->user->name }}</p>
							<p><b>Anggota:</b></p>
							@foreach ($data->team->members as $member)
								<p>{{ $member->user->name }}</p>
							@endforeach
						@else
							No Team Assigned
						@endif
					</td>
					<td>
						<div class="flex gap-2">
							<x-areas.edit :$instrument :$teams :$area />
						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@push('scripts2')
	<script>
		new DataTable('#areas-table', {
			pageLength: -1,
			dom: 'frt',
			ordering: false
		});
	</script>
@endpush
