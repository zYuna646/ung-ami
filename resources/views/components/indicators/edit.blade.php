<div id="edit-indicator" x-data="{ editIndicatorModal: false }">
	<x-button @click="editIndicatorModal = true" color="success" size="{{ $size ?? 'md' }}">
		Edit
	</x-button>
	<div x-cloak x-show="editIndicatorModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Edit Indikator</h3>
				<button type="button" @click="editIndicatorModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('dashboard.master.periodes.instruments.indicators.update', [$periode->uuid, $instrument->uuid, $indicator->uuid]) }}" method="POST" class="flex flex-col gap-5">
					@csrf
					@method('PUT')
					<x-form.input name="name" label="Indikator" placeholder="Isi indikator" :value="$indicator->name" />
					<div>
						<x-button type="submit" color="info">
							Perbarui
						</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
