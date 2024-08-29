<x-button.delete :action="route('dashboard.master.questions.destroy', $question->uuid)" color="danger" size="{{ $size ?? 'md' }}">
  <p>Anda akan menghapus data berikut: </p>
  <dl class="max-w-md divide-y divide-gray-200 text-gray-900">
    <div class="flex flex-col pb-3">
      <dt class="mb-1 text-gray-500">ID</dt>
      <dd class="font-semibold">{{ $question->uuid }}</dd>
    </div>
    <div class="flex flex-col py-3">
      <dt class="mb-1 text-gray-500">Kode</dt>
      <dd class="font-semibold">{{ $question->code }}</dd>
    </div>
    <div class="flex flex-col pt-3">
      <dt class="mb-1 text-gray-500">Pertanyaan</dt>
      <dd class="font-semibold">{{ $question->question }}</dd>
    </div>
  </dl>
</x-button.delete>