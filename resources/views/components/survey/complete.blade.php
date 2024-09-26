<div id="complete-instrument" x-data="{ completeInstrumentModal: false }">
	<x-button @click="completeInstrumentModal = true" color="success">
		Konfirmasi
		<i class="fa-solid fa-check ms-2"></i>
	</x-button>
	<div x-cloak x-show="completeInstrumentModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Konfirmasi</h3>
				<button type="button" @click="completeInstrumentModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('survey.complete', $instrument->uuid) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
					@csrf
					<input type="hidden" name="area" value="{{ auth()->user()->entityId() . auth()->user()->entityType() }}">
					<p>Konfirmasi Survei</p>
					{{-- <x-form.input type="file" name="meeting_report" label="Unggah Berita Acara" />
					<x-form.input type="file" name="activity_evidence" label="Unggah Bukti Kegiatan" /> --}}
					<div class="flex justify-end gap-2">
						<x-button @click="completeInstrumentModal = false" color="default">Batal</x-button>
						<x-button type="submit" color="success">Konfirmasi</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
