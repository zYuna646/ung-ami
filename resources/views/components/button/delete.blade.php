<div x-data="{ isOpen: false }">
	<x-button @click="isOpen = true" color="danger" size="{{ $size ?? 'md' }}">
		Hapus
	</x-button>
	<div x-cloak x-show="isOpen" class="fixed left-0 right-0 top-0 z-50 flex h-full w-full items-center justify-center bg-black/50">
		<div class="relative w-full max-w-2xl rounded-lg bg-white p-6 shadow-lg">
			<div class="flex items-center justify-between border-b pb-4">
				<h3 class="text-lg font-bold">Hapus Data</h3>
				<button type="button" @click="isOpen = false" class="text-gray-400 hover:text-gray-900">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="p-4">
				<form action="{{ $action }}" method="POST" class="flex flex-col gap-5">
					@csrf
					@method('DELETE')
          {{ $slot }}
					<p class="text-color-danger-500">Mohon diperhatikan bahwa aksi ini dapat menghapus data lainnya yang terkait. Data yang telah dihapus, tidak dapat dikembalikan.</p>
					<div class="flex justify-end gap-2">
						<x-button @click="isOpen = false" color="default">Batal</x-button>
						<x-button type="submit" color="danger">Hapus</x-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
