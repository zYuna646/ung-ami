<div id="add-indicator" x-data="{ addIndicatorModal: false }">
	<x-button @click="addIndicatorModal = true" color="info" size="{{ $size ?? 'md' }}">
		Tambah Indikator
	</x-button>
	<div x-cloak x-show="addIndicatorModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Tambah Indikator</h3>
				<button type="button" @click="addIndicatorModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('dashboard.master.periodes.instruments.indicators.store', [$periode->uuid, $instrument->uuid]) }}" method="POST" class="flex flex-col gap-5">
					@csrf
					<x-form.input name="name" label="Indikator" placeholder="Indikator" />
					<input type="hidden" name="instrument_id" value="{{ $instrument->id }}">
					<div class="flex justify-end gap-2">
						<x-button @click="addIndicatorModal = false" color="default">Batal</x-button>
						<x-button type="submit" color="info">Submit</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
