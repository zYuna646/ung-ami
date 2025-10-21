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
                                <th class="border px-4 py-2">Kategori KTS (Minor/Major)</th>
								<th class="border px-4 py-2">Akar Penyebab / Faktor Penghambat</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($questions as $question)
								<tr>
									<td class="border px-4 py-2 text-center">{{ $question->code }}</td>
									<td class="border px-4 py-2">{{ $question->response->description ?? '' }}</td>
                                    <td class="border px-4 py-2">{{ $question->response->category ?? '' }}</td>
                                    <td class="border px-4 py-2">{{ $question->response->kts_category ?? '' }}</td>
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
								@if($question->desc)
									<p class="mb-2 text-md italic">Indikator: {{ $question->desc }}</p>
								@endif
								<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
							</div>

                            @php
                                $descriptionFieldName = "description.{$question->id}";
                                $categoryFieldName = "category.{$question->id}";
                                $ktsCategoryFieldName = "kts_category.{$question->id}";
                                $barriersFieldName = "barriers.{$question->id}";
                            @endphp

							<div class="grid grid-cols-2 gap-3">
								<div>
									<label for="description_{{ $question->id }}" class="block mb-1 font-medium text-gray-700">Deskripsi Hasil Audit</label>
									<x-form.textarea
										id="description_{{ $question->id }}"
										name="description[{{ $question->id }}]"
										placeholder="Masukkan deskripsi hasil audit"
										:inputClass="$errors->has($descriptionFieldName) ? 'border-red-700' : ''"
										:value="old($descriptionFieldName) ?? $question->response->description"
										required
									/>
									@error($descriptionFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
								<div>
									<label for="barriers_{{ $question->id }}" class="block mb-1 font-medium text-gray-700">Akar Penyebab / Faktor Penghambat</label>
									<x-form.textarea
										id="barriers_{{ $question->id }}"
										name="barriers[{{ $question->id }}]"
										placeholder="Masukkan akar penyebab atau faktor penghambat"
										:inputClass="$errors->has($barriersFieldName) ? 'border-red-700' : ''"
										:value="old($barriersFieldName) ?? $question->response->barriers"
										required
									/>
									@error($barriersFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
							</div>
                            <div x-data="{ selected: '{{ old($categoryFieldName) ?? ($question->response->category ?? '') }}' }">
                                <div class="mb-3">
                                    <label for="category_{{ $question->id }}" class="block mb-1 font-medium text-gray-700">Kategori Temuan Audit</label>
                                    <x-form.select
                                        id="category_{{ $question->id }}"
                                        x-model="selected"
                                        name="category[{{ $question->id }}]"
                                        placeholder="Pilih Kategori Temuan Audit (OBS/KTS)"
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

                                <div x-show="selected === 'KTS'" class="mt-3">
                                    <label for="kts_category_{{ $question->id }}" class="block mb-1 font-medium text-gray-700">Kategori KTS</label>
                                    <x-form.select
                                        id="kts_category_{{ $question->id }}"
                                        name="kts_category[{{ $question->id }}]"
                                        placeholder="Pilih Kategori KTS (Minor/Mayor)"
                                        :value="old($ktsCategoryFieldName) ?? $question->response->kts_category"
                                        :options="[
                                            (object) [
                                                'label' => 'KTS MINOR',
                                                'value' => 'MINOR',
                                            ],
                                            (object) [
                                                'label' => 'KTS MAYOR',
                                                'value' => 'MAYOR',
                                            ],
                                        ]"
                                        :inputClass="$errors->has($ktsCategoryFieldName) ? 'border-red-700' : ''"
                                    />
                                    @error($ktsCategoryFieldName)
                                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
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
