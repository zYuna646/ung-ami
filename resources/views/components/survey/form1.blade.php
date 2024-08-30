<form action="{{ route('survey.store', $instrument->uuid) }}" method="POST">
	@csrf
	@if (auth()->user()->isAuditor())
		<x-main.card class="mb-5">
			<x-survey.select-auditee :$instrument />
		</x-main.card>
	@endif
	<div class="space-y-5">
		@foreach ($instrument->indicators as $key => $indicator)
			<div class="rounded-lg border border-slate-100 bg-white shadow-sm">
				<div class="border-b border-gray-300 p-6">
					<h2 class="font-semibold">{{ $loop->iteration }}. {{ $indicator->name }}</h2>
				</div>
				<div class="space-y-5 p-6">
					@foreach ($indicator->questions as $question)
						@can('view', $question)
							<div class="space-y-3">
								<div>
									<h3 class="font-semibold">Butir Pertanyaan</h3>
									<p class="mb-1 text-lg">{{ $question->text }}</p>
									<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
								</div>

								@php
									$availabilityFieldName = "availability.{$question->id}";
									$notesFieldName = "notes.{$question->id}";
								@endphp

								<x-form.select name="availability[{{ $question->id }}]" placeholder="Pilih Ketersediaan Dokumen" :value="old($availabilityFieldName) ?? $question->response->availability" :disabled="auth()->user()->isAuditor()" :options="[
								    (object) [
								        'label' => 'Tersedia',
								        'value' => 'Tersedia',
								    ],
								    (object) [
								        'label' => 'Tidak Tersedia',
								        'value' => 'Tidak Tersedia',
								    ],
								]" :inputClass="$errors->has($availabilityFieldName) ? 'border-red-700' : ''" />
								@error($availabilityFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror

								<x-form.textarea name="notes[{{ $question->id }}]" placeholder="Catatan" :inputClass="$errors->has($notesFieldName) ? 'border-red-700' : ''" :value="old($notesFieldName) ?? $question->response->notes" :disabled="auth()->user()->isAuditor()" />
								@if (filter_var($question->response->notes, FILTER_VALIDATE_URL))
									<a class="mt-2 text-xs text-blue-500 underline" href="{{ $question->response->notes }}" target="_blank">TAUTAN</a>
								@endif
								@error($notesFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror

								<p class="text-right text-sm text-gray-600">{{ $question->code }}</p>
							</div>
						@endcan
					@endforeach
				</div>
			</div>
		@endforeach
		<div class="flex justify-end gap-3">
			@if (auth()->user()->isAuditee())
				<x-button type="submit" color="info">
					Simpan Penilaian
					<i class="fa-solid fa-floppy-disk ms-2"></i>
				</x-button>
			@endif
		</div>
	</div>
</form>
