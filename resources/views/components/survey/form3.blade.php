<form action="{{ route('survey.compliance_results.store', $instrument->uuid) }}" method="POST">
	@csrf
	<x-main.card class="mb-5">
		<x-survey.select-auditee :$instrument />
	</x-main.card>
	<div class="space-y-5">
		@if ($showInstrument)
			<x-main.card>
				@foreach ($questions as $question)
					<div class="space-y-3">
						<div>
							<h3 class="font-semibold">Butir Pertanyaan</h3>
							<p class="mb-1 text-lg">{{ $question->text }}</p>
							<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
						</div>

						@php
							$descriptionFieldName = "description.{$question->id}";
							$successFactorsFieldName = "success_factors.{$question->id}";
						@endphp

						<div class="grid grid-cols-2 gap-3">
							<div>
								{{-- Deskripsi Hasil Audit --}}
								<x-form.textarea name="description[{{ $question->id }}]" placeholder="Deskripsi Hasil Audit" :inputClass="$errors->has($descriptionFieldName) ? 'border-red-700' : ''" :value="old($descriptionFieldName) ?? $question->response->description" />
								@error($descriptionFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</div>
							<div>
								{{-- Faktor Pendukung Keberhasilan --}}
								<x-form.textarea name="success_factors[{{ $question->id }}]" placeholder="Faktor Pendukung Keberhasilan" :inputClass="$errors->has($descriptionFieldName) ? 'border-red-700' : ''" :value="old($successFactorsFieldName) ?? $question->response->success_factors" />
								@error($successFactorsFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<p class="text-right text-sm text-gray-600">{{ $question->code }}</p>
					</div>
				@endforeach
			</x-main.card>
		@else
			<x-main.card>
				<div class="col-span-12 py-8 text-center">
					<p class="text-slate-600">No indicators or questions available.</p>
				</div>
			</x-main.card>
		@endif
		<div class="flex justify-end gap-3">
			<x-button type="submit" color="info">
				Simpan
				<i class="fa-solid fa-floppy-disk ms-2"></i>
			</x-button>
		</div>
	</div>
</form>
