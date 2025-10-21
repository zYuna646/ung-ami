<form action="{{ route('survey.compliance_results.store', $instrument->uuid) }}" method="POST">
	@csrf
	<x-main.card class="mb-5">
		<x-survey.select-auditee :$instrument />
	</x-main.card>

	@if ($showInstrument)
		<div x-data="{ tab: 'table' }" class="space-y-5">
			<x-main.card class="mb-5">
				<ul class="flex flex-wrap">
					<li class="me-2">
						<a
							href="#"
							@click.prevent="tab = 'table'"
							:class="tab === 'table' ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600'"
							class="inline-block rounded-t-lg p-4 pt-0"
						>
							Tabel
						</a>
					</li>
					@if (auth()->user()->isAuditor())
						<li class="me-2">
							<a
								href="#"
								@click.prevent="tab = 'form'"
								:class="tab === 'form' ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600'"
								class="inline-block rounded-t-lg p-4 pt-0"
							>
								Form
							</a>
						</li>
					@endif
				</ul>
				<div x-show="tab === 'table'" class="mt-5">
					<table class="w-full table-auto border-collapse text-xs">
						<thead>
							<tr class="bg-gray-100">
								<th class="border px-4 py-2">Check List</th>
								<th class="border px-4 py-2">Butir Pertanyaan</th>
								<th class="border px-4 py-2">Indikator</th>
								<th class="border px-4 py-2">Deskripsi Hasil Audit</th>
								<th class="border px-4 py-2">Faktor Pendukung Keberhasilan</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($questions as $question)
								<tr>
									<td class="border px-4 py-2 text-center">{{ $question->code }}</td>
									<td class="border px-4 py-2">{{ $question->text }}</td>
									<td class="border px-4 py-2">{{ $question->desc }}</td>
									<td class="border px-4 py-2">{{ $question->response->description ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->success_factors ?? '' }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</x-main.card>
			<div x-show="tab === 'form'" class="space-y-5">
				<x-main.card>
					@foreach ($questions as $question)
						<div class="space-y-3">
							<div>
								<h3 class="font-semibold">Butir Pertanyaan</h3>
								<p class="mb-1 text-lg">{{ $question->text }}</p>
								@if($question->desc)
									<h4 class="font-medium text-sm mb-1">Indikator</h4>
									<p class="mb-3 text-sm">{{ $question->desc }}</p>
								@endif
								<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
							</div>

							@php
								$descriptionFieldName = "description.{$question->id}";
								$successFactorsFieldName = "success_factors.{$question->id}";
							@endphp

							<div class="grid grid-cols-2 gap-3">
								<div>
									<label for="description_{{ $question->id }}" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Hasil Audit</label>
									<x-form.textarea
										id="description_{{ $question->id }}"
										name="description[{{ $question->id }}]"
										placeholder="Deskripsi Hasil Audit"
										:inputClass="$errors->has($descriptionFieldName) ? 'border-red-700' : ''"
										:value="old($descriptionFieldName) ?? $question->response->description"
										required
									/>
									@error($descriptionFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
								<div>
									<label for="success_factors_{{ $question->id }}" class="block text-sm font-medium text-gray-700 mb-1">Faktor Pendukung Keberhasilan</label>
									<x-form.textarea
										id="success_factors_{{ $question->id }}"
										name="success_factors[{{ $question->id }}]"
										placeholder="Faktor Pendukung Keberhasilan"
										:inputClass="$errors->has($successFactorsFieldName) ? 'border-red-700' : ''"
										:value="old($successFactorsFieldName) ?? $question->response->success_factors"
										required
									/>
									@error($successFactorsFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<p class="text-right text-sm text-gray-600">{{ $question->code }}</p>
						</div>
					@endforeach
				</x-main.card>
				<div class="flex justify-end gap-3">
					@can('submitComplianceResults', $instrument)
						<x-button type="submit" color="info">
							Simpan
							<i class="fa-solid fa-floppy-disk ms-2"></i>
						</x-button>
					@endcan
				</div>
			</div>
		</div>
	@else
		<x-main.card>
			<div class="col-span-12 py-8 text-center">
				<p class="text-slate-600">No indicators or questions available.</p>
			</div>
		</x-main.card>
	@endif
</form>
