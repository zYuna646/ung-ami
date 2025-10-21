<div id="add-question" x-data="{ addQuestionModal: false }">
	<x-button @click="addQuestionModal = true" color="info" size="{{ $size ?? 'md' }}">
		Tambah Pertanyaan
	</x-button>
	<div x-cloak x-show="addQuestionModal" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Tambah Pertanyaan</h3>
				<button type="button" @click="addQuestionModal = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ route('dashboard.master.questions.store') }}" method="POST" class="flex flex-col gap-5">
					@csrf
					<input type="hidden" name="master_indicator_id" value="{{ $indicatorId }}" />
					<x-form.input name="code" label="Kode" placeholder="Isi Kode" />
					<x-form.input name="question" label="Pertanyaan" placeholder="Isi Pertanyaan" />
					<x-form.textarea name="desc" label="Indikator" placeholder="Isi deskripsi indikator" />
					<div class="flex justify-end gap-2">
						<x-button @click="addQuestionModal = false" color="default">Batal</x-button>
						<x-button type="submit" color="info">Submit</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
