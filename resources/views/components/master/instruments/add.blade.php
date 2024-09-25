<div id="add-instrument" x-data="{ addInstrumentModal: false }">
	<x-button @click="addInstrumentModal = true" color="info">
		Tambah Instrumen
	</x-button>
	<div x-cloak x-show="addInstrumentModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Tambah Instrumen</h3>
				<button type="button" @click="addInstrumentModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('dashboard.master.instruments.store') }}" method="POST" class="flex flex-col gap-5">
					@csrf
					<x-form.select name="instrument" label="Instrumen" :options="$standards->map(function ($standard) {
					    return (object) [
					        'label' => $standard->name,
					        'value' => $standard->name,
					    ];
					})" />
					{{-- <x-form.input name="instrument" label="Instrumen" placeholder="Isi instrumen" /> --}}
					<div class="flex justify-end gap-2">
						<x-button @click="addInstrumentModal = false" color="default">Batal</x-button>
						<x-button type="submit" color="info">Submit</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
