<div id="edit-question" x-data="{ editQuestionModal: false }">
	<x-button @click="editQuestionModal = true" color="success" size="{{ $size ?? 'md' }}">
		Edit
	</x-button>
	<div x-cloak x-show="editQuestionModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Edit Pertanyaan</h3>
				<button type="button" @click="editQuestionModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('dashboard.master.questions.update', $question->uuid) }}" method="POST" class="flex flex-col gap-5">
					@csrf
					@method('PUT')
					<x-form.input name="code" label="Kode" placeholder="Isi kode" :value="$question->code" />
					<x-form.input name="text" label="Pertanyaan" placeholder="Isi pertanyaan" :value="$question->text" />
					<x-form.textarea name="desc" label="Indikator" placeholder="Isi deskripsi indikator" :value="$question->desc" />
					<x-form.choices name="units[]" label="Area Audit" placeholder="Pilih Area Audit" :multiple="true" :value="$question->units
					    ->map(function ($unit) {
					        return strval($unit->id);
					    })
					    ->toArray()" :options="$question->indicator->instrument->periode->units->map(function ($unit) {
					    return (object) [
					        'label' => $unit->unit_name,
					        'value' => $unit->id,
					    ];
					})" />
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
