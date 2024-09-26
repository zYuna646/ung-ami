<form action="{{ route('survey.audit_results.store', $instrument->uuid) }}" method="POST">
	@csrf
	<x-main.card class="mb-5">
		<x-survey.select-auditee :$instrument />
	</x-main.card>

	@if ($showInstrument)
		<div x-data="{ tab: 'table' }" class="space-y-5">
			<x-main.card class="mb-5">
				<ul class="flex flex-wrap">
					<li class="me-2">
						<a href="#" @click.prevent="tab = 'table'" :class="tab === 'table' ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600'" class="inline-block rounded-t-lg p-4 pt-0">
							Tabel
						</a>
					</li>
					<li class="me-2">
						<a href="#" @click.prevent="tab = 'form'" :class="tab === 'form' ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600'" class="inline-block rounded-t-lg p-4 pt-0">
							Form
						</a>
					</li>
				</ul>
				<div x-show="tab === 'table'" class="mt-5">
					<table class="w-full table-auto border-collapse text-xs">
						<thead>
							<tr class="bg-gray-100">
								<th class="border px-4 py-2">Check List</th>
								<th class="border px-4 py-2">Butir Pertanyaan</th>
								<th class="border px-4 py-2">Deskripsi Hasil Audit</th>
								<th class="border px-4 py-2">Jumlah Target</th>
								<th class="border px-4 py-2">Keberadaan</th>
								<th class="border px-4 py-2">Kesesuaian Standar</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($instrument->indicators as $key => $indicator)
								@foreach ($indicator->questions as $question)
									<tr>
										<td class="border px-4 py-2 text-center">{{ $question->code }}</td>
										<td class="border px-4 py-2">{{ $question->text }}</td>
										<td class="border px-4 py-2">{{ $question->response->description ?? '' }}</td>
										<td class="border px-4 py-2">{{ $question->response->amount_target ?? '' }}</td>
										<td class="border px-4 py-2">{{ $question->response->existence ?? '' }}</td>
										<td class="border px-4 py-2">{{ $question->response->compliance ?? '' }}</td>
									</tr>
								@endforeach
							@endforeach
						</tbody>
					</table>
				</div>
			</x-main.card>
			<div x-show="tab === 'form'" class="space-y-5">
				@foreach ($instrument->indicators as $key => $indicator)
					<div class="rounded-lg border border-slate-100 bg-white shadow-sm">
						<div class="border-b border-gray-300 p-6">
							<h2 class="font-semibold">{{ $loop->iteration }}. {{ $indicator->name }}</h2>
						</div>
						<div class="space-y-5 p-6">
							@foreach ($indicator->questions as $question)
								<div class="space-y-3">
									<div>
										<h3 class="font-semibold">Butir Pertanyaan</h3>
										<p class="mb-1 text-lg">{{ $question->text }}</p>
										<p class="text-sm text-gray-600">{{ $question->units->pluck('unit_name')->implode(', ') }}</p>
									</div>

									@php
										$descriptionFieldName = "description.{$question->id}";
										$amountTargetFieldName = "amount_target.{$question->id}";
										$existenceFieldName = "existence.{$question->id}";
										$complianceFieldName = "compliance.{$question->id}";
									@endphp

									<x-form.textarea name="description[{{ $question->id }}]" placeholder="Deskripsi Hasil Audit" :inputClass="$errors->has($descriptionFieldName) ? 'border-red-700' : ''" :value="old($descriptionFieldName) ?? $question->response->description" />
									@error($descriptionFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror

									<div class="grid grid-cols-3 gap-3">
										<div>
											<x-form.input name="amount_target[{{ $question->id }}]" placeholder="Jumlah Target" :inputClass="$errors->has($amountTargetFieldName) ? 'border-red-700' : ''" :value="old($amountTargetFieldName) ?? $question->response->amount_target" />
											@error($amountTargetFieldName)
												<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
											@enderror
										</div>
										<div>
											<x-form.select name="existence[{{ $question->id }}]" placeholder="Pilih Keberadaan" :value="old($existenceFieldName) ?? $question->response->existence" :options="[(object) ['label' => 'Ada', 'value' => 'Ada'], (object) ['label' => 'Tidak Ada', 'value' => 'Tidak Ada']]" :inputClass="$errors->has($existenceFieldName) ? 'border-red-700' : ''" />
											@error($existenceFieldName)
												<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
											@enderror
										</div>
										<div>
											<x-form.select name="compliance[{{ $question->id }}]" placeholder="Pilih Kesesuaian Standar" :value="old($complianceFieldName) ?? $question->response->compliance" :options="[(object) ['label' => 'Sesuai', 'value' => 'Sesuai'], (object) ['label' => 'Tidak Sesuai', 'value' => 'Tidak Sesuai']]" :inputClass="$errors->has($complianceFieldName) ? 'border-red-700' : ''" />
											@error($complianceFieldName)
												<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
											@enderror
										</div>
									</div>

									<p class="text-right text-sm text-gray-600">{{ $question->code }}</p>
								</div>
							@endforeach
						</div>
					</div>
				@endforeach
				<div class="flex justify-end gap-3">
					@can('submitAuditResults', $instrument)
						<x-button type="submit" color="info">
							Simpan
							<i class="fa-solid fa-floppy-disk ms-2"></i>
						</x-button>
					@endcan
				</div>
			</div>
		</div>
	@endif
</form>
