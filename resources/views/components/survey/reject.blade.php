<div id="reject-instrument" x-data="{ rejectInstrumentModal: false }">
	<x-button @click="rejectInstrumentModal = true" color="danger">
		Tolak
		<i class="fa-solid fa-cancel ms-2"></i>
	</x-button>
	<div x-cloak x-show="rejectInstrumentModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Konfirmasi</h3>
				<button type="button" @click="rejectInstrumentModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('survey.reject', $instrument->uuid) }}" method="POST" class="flex flex-col gap-5">
					@csrf
					<input type="hidden" name="area" value="{{ auth()->user()->entityId() . auth()->user()->entityType() }}">
					<p class="mb-3">Anda akan menolak survei ini.</p>
					<div class="flex justify-end gap-2">
						<x-button @click="rejectInstrumentModal = false" color="default">Batal</x-button>
						<x-button type="submit" color="danger">Tolak</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
