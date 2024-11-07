<form action="{{ route('survey.noncompliance_results.store', $instrument->uuid) }}" method="POST">
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
								<th class="border px-4 py-2">Deskripsi Hasil Audit</th>
								<th class="border px-4 py-2">Kategori Temuan Audit (OBS / KTS)</th>
								<th class="border px-4 py-2">Akar Penyebab / Faktor Penghambat</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($questions as $question)
								<tr>
									<td class="border px-4 py-2 text-center">{{ $question->code }}</td>
									<td class="border px-4 py-2">{{ $question->response->description ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->category ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->barriers ?? '' }}</td>
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
								<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
							</div>

							@php
								$descriptionFieldName = "description.{$question->id}";
								$categoryFieldName = "category.{$question->id}";
								$barriersFieldName = "barriers.{$question->id}";
							@endphp

							<div class="grid grid-cols-2 gap-3">
								<div>
									{{-- Deskripsi Hasil Audit --}}
									<x-form.textarea
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
									{{-- Faktor Penghambat --}}
									<x-form.textarea
										name="barriers[{{ $question->id }}]"
										placeholder="Faktor Penghambat"
										:inputClass="$errors->has($barriersFieldName) ? 'border-red-700' : ''"
										:value="old($barriersFieldName) ?? $question->response->barriers"
										required
									/>
									@error($barriersFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div>
								{{-- Keberadaan --}}
								<x-form.select
									name="category[{{ $question->id }}]"
									placeholder="Pilih Kategori"
									:value="old($categoryFieldName) ?? $question->response->category"
									:options="[
									    (object) [
									        'label' => 'OBS',
									        'value' => 'OBS',
									    ],
									    (object) [
									        'label' => 'KTS',
									        'value' => 'KTS',
									    ],
									]"
									:inputClass="$errors->has($categoryFieldName) ? 'border-red-700' : ''"
									required
								/>
								@error($categoryFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</div>
							<p class="text-right text-sm text-gray-600">{{ $question->code }}</p>
						</div>
					@endforeach
				</x-main.card>
				<div class="flex justify-end gap-3">
					@can('submitNoncomplianceResults', $instrument)
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
