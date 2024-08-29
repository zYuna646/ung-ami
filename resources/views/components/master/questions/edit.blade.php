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
					<x-form.input name="code" label="Kode" placeholder="Isi Kode" :value="$question->code" />
					<x-form.input name="question" label="Pertanyaan" placeholder="Isi Indikator" :value="$question->question" />
					<div class="flex justify-end gap-2">
						<x-button @click="editQuestionModal = false" color="default">Batal</x-button>
						<x-button type="submit" color="success">Perbarui</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
