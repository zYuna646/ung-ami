<div id="edit-area" x-data="{ editAreaModal: false }">
	<x-button @click="editAreaModal = true" color="success" size="sm">
		Edit
	</x-button>
	<div x-cloak x-show="editAreaModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Edit Tim Pelaksana</h3>
				<button type="button" @click="editAreaModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('dashboard.master.periodes.instruments.update.area', [$instrument->periode->uuid, $instrument->uuid]) }}" method="POST" class="flex flex-col gap-5">
					@csrf
					@method('PUT')
          <input type="hidden" name="model_type" value="{{ $area->model_type }}">
          <input type="hidden" name="id" value="{{ $area->id }}">
					<x-form.select name="team_id" label="Tim Pelaksana" :options="$teams->map(function ($team) {
					    return (object) [
					        'label' => $team->chief->user->name . ' (Ketua)',
					        'value' => $team->id,
					    ];
					})" />
					<div class="flex justify-end gap-2">
						<x-button @click="editAreaModal = false" color="default">Batal</x-button>
						<x-button type="submit" color="info">Perbarui</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
