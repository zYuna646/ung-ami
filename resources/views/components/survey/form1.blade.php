@php
	use App\Constants\AuditStatus;
@endphp
@if (auth()->user()->isAuditor())
	<x-main.card class="mb-5">
		<x-survey.select-auditee :$instrument />
	</x-main.card>
@endif

<div x-data="{ tab: 'table' }">
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
			@if (auth()->user()->isAuditee())
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

		<div x-show="tab === 'table'" class="mt-5 overflow-x-auto">
			<table class="w-full table-auto border-collapse text-xs">
				<thead>
					<tr class="bg-gray-100">
						<th class="border px-4 py-2">No.</th>
						<th class="border px-4 py-2">Indikator</th>
						<th class="border px-4 py-2" colspan="3">Butir Pertanyaan</th>
						<th class="border px-4 py-2">Ketersediaan Dokumen</th>
						<th class="border px-4 py-2">Faktor Penghambat / Faktor Pendukung</th>
						<th class="border px-4 py-2">Bukti</th>
					</tr>
					<tr class="bg-gray-50">
						<th class="border px-4 py-2" colspan="2"></th>
						<th class="border px-4 py-2">Kode</th>
						<th class="border px-4 py-2">Pertanyaan</th>
						<th class="border px-4 py-2">Indikator</th>
						<th class="border px-4 py-2" colspan="3"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($instrument->indicators as $indicatorKey => $indicator)
						@php
							$questionsCount = $indicator->questions->count();
						@endphp

						@foreach ($indicator->questions as $questionKey => $question)
							@can('view', $question)
								<tr>
									@if ($questionKey == 0)
										<td class="border px-4 py-2 text-center align-top" rowspan="{{ $questionsCount }}">{{ $indicatorKey + 1 }}</td>
										<td class="border px-4 py-2 align-top" rowspan="{{ $questionsCount }}">{{ $indicator->name }}</td>
										
									@endif

									<td class="border px-4 py-2 align-top">{{ $question->code }}</td>
									<td class="border px-4 py-2 align-top">{{ $question->text }}</td>
									<td class="border px-4 py-2 align-top">{{ $question->desc ?? '' }}</td>
									<td class="border px-4 py-2 align-top">
										{{ $question->response->availability ?? 'Belum Diisi' }}
									</td>
									<td class="border px-4 py-2 align-top">
										@if (filter_var($question->response->notes, FILTER_VALIDATE_URL))
											<a
												class="text-blue-500 underline"
												href="{{ $question->response->notes }}"
												target="_blank"
											>Tautan</a>
										@else
											{{ $question->response->notes ?? '-' }}
										@endif
									</td>
									<td class="border px-4 py-2 align-top">
										@if (filter_var($question->response->evidence, FILTER_VALIDATE_URL))
											<a
												class="text-blue-500 underline"
												href="{{ $question->response->evidence }}"
												target="_blank"
											>Tautan</a>
										@else
											-
										@endif
									</td>
								</tr>
							@endcan
						@endforeach
					@endforeach
				</tbody>
			</table>
		</div>
	</x-main.card>

	@if (auth()->user()->isAuditee())
		<div x-show="tab === 'form'" class="space-y-5">
			<form
				action="{{ route('survey.store', $instrument->uuid) }}"
				method="POST"
				enctype="multipart/form-data"
			>
				@csrf
				@foreach ($instrument->indicators as $key => $indicator)
					<div class="rounded-lg border border-slate-100 bg-white shadow-sm">
						<div class="border-b border-gray-300 p-6">
							<h2 class="font-semibold">{{ $loop->iteration }}. {{ $indicator->name }}</h2>
						</div>
						<div class="space-y-5 p-6">
							@foreach ($indicator->questions as $question)
								@can('view', $question)
									<div class="space-y-3" x-data="{ availability: '{{ old("availability.$question->id") ?? $question->response->availability }}' }">
										<div>
											<h3 class="font-semibold">Butir Pertanyaan</h3>
											<p class="mb-1 text-lg">{{ $question->text }}</p>
											@if($question->desc)
											<div class="mb-2">
												<h4 class="font-medium text-sm">Indikator:</h4>
												<p class="text-sm text-gray-700">{{ $question->desc }}</p>
											</div>
											@endif
											<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
										</div>

										@php
											$availabilityFieldName = "availability.{$question->id}";
											$notesFieldName = "notes.{$question->id}";
											$evidenceFieldName = "evidence.{$question->id}";
										@endphp

										<div class="mb-3">
											<label for="availability-{{ $question->id }}" class="block mb-1 font-medium text-sm">Ketersediaan Dokumen:</label>
											<x-form.select
												x-model="availability"
												name="availability[{{ $question->id }}]"
												id="availability-{{ $question->id }}"
												placeholder="Pilih Ketersediaan Dokumen"
												:value="old($availabilityFieldName) ?? $question->response->availability"
												:disabled="auth()->user()->isAuditor()"
												:options="[
												    (object) [
												        'label' => 'Tersedia',
												        'value' => 'Tersedia',
												    ],
												    (object) [
												        'label' => 'Tidak Tersedia',
												        'value' => 'Tidak Tersedia',
												    ],
												]"
												:inputClass="$errors->has($availabilityFieldName) ? 'border-red-700' : ''"
											/>
										</div>
										@error($availabilityFieldName)
											<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
										@enderror

										<div x-show="availability === 'Tersedia'" class="mt-3">
											<label for="evidence-{{ $question->id }}" class="block mb-1 font-medium text-sm">Bukti:</label>
											<x-form.input
												name="evidence[{{ $question->id }}]"
												id="evidence-{{ $question->id }}"
												placeholder="https//"
												:inputClass="$errors->has($evidenceFieldName) ? 'border-red-700' : ''"
												:value="old($evidenceFieldName) ?? $question->response->evidence"
												:disabled="auth()->user()->isAuditor()"
											/>
											@error($evidenceFieldName)
												<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
											@enderror
										</div>

										<div class="mb-2">
											<label for="notes-{{ $question->id }}" class="block mb-1 font-medium text-sm">Faktor Penghambat / Faktor Pendukung:</label>
											<x-form.textarea
												name="notes[{{ $question->id }}]"
												id="notes-{{ $question->id }}"
												placeholder="Catatan"
												:inputClass="$errors->has($notesFieldName) ? 'border-red-700' : ''"
												:value="old($notesFieldName) ?? $question->response->notes"
												:disabled="auth()->user()->isAuditor()"
											/>
										</div>
										@if (filter_var($question->response->notes, FILTER_VALIDATE_URL))
											<a
												class="mt-2 text-xs text-blue-500 underline"
												href="{{ $question->response->notes }}"
												target="_blank"
											>TAUTAN</a>
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
					@can('submitSurvey', $instrument)
						<x-button type="submit" color="info">
							Simpan Penilaian
							<i class="fa-solid fa-floppy-disk ms-2"></i>
						</x-button>
					@endcan
				</div>
			</form>
		</div>
	@endif
</div>
