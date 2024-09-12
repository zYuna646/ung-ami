<x-main.card>
	<div class="flex flex-col gap-y-2">
		<div class="inline-flex items-center gap-x-2">
			<span>
				<i class="fas fa-book"></i>
			</span>
			<p><span class="font-semibold">Standar:</span> {{ $instrument->periode->standard->name }}</p>
		</div>
		<div class="inline-flex items-center gap-x-2">
			<span>
				<i class="fas fa-clipboard-list"></i>
			</span>
			<p><span class="font-semibold">Tipe Audit:</span> {{ $instrument->periode->tipe }}</p>
		</div>
		<div class="inline-flex items-center gap-x-2">
			<span>
				<i class="fas fa-clipboard-list"></i>
			</span>
			<p><span class="font-semibold">Periode:</span> {{ $instrument->periode->formatted_start_date . ' - ' . $instrument->periode->formatted_end_date }}</p>
		</div>
		{{-- <div class="inline-flex items-center gap-x-2">
			<span>
				<i class="fas fa-user-tie"></i>
			</span>
			<p><span class="font-semibold">Auditor:</span></p>
		</div>
		<ul class="space-y-2">
			@php
				$data = $instrument
				    ->entityTeams()
				    ->where('entity_id', auth()->user()->entityId())
				    ->where('entity_type', auth()->user()->entityType())
				    ->first();
			@endphp
			<li><span class="font-semibold">Ketua:</span> {{ $data->team->chief->user->name }}</li>
			<li><span class="font-semibold">Anggota:</span> {{ $data->team->members->pluck('user.name')->implode(' - ') }}</li>
		</ul> --}}
	</div>
</x-main.card>
