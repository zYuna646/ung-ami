<x-button.delete :action="route('dashboard.master.indicators.destroy', $indicator->uuid)" color="danger" size="{{ $size ?? 'md' }}">
  <p>Anda akan menghapus data berikut: </p>
  <dl class="max-w-md divide-y divide-gray-200 text-gray-900">
    <div class="flex flex-col pb-3">
      <dt class="mb-1 text-gray-500">ID</dt>
      <dd class="font-semibold">{{ $indicator->uuid }}</dd>
    </div>
    <div class="flex flex-col pt-3">
      <dt class="mb-1 text-gray-500">Indikator</dt>
      <dd class="font-semibold">{{ $indicator->indicator }}</dd>
    </div>
  </dl>
</x-button.delete>