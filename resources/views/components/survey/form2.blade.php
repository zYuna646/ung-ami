<form action="{{ route('survey.audit_results.store', $instrument->uuid) }}" method="POST">
	@csrf
	<x-main.card class="mb-5">
		<x-survey.select-auditee :$instrument />
	</x-main.card>
	<div class="space-y-5">
		@if ($showInstrument)
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

								{{-- Deskripsi Hasil Audit --}}
								<x-form.textarea name="description[{{ $question->id }}]" placeholder="Deskripsi Hasil Audit" :inputClass="$errors->has($descriptionFieldName) ? 'border-red-700' : ''" :value="old($descriptionFieldName) ?? $question->response->description" />
								@error($descriptionFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror

								<div class="grid grid-cols-3 gap-3">
									<div>
										{{-- Jumlah Target --}}
										<x-form.input name="amount_target[{{ $question->id }}]" placeholder="Jumlah Target" :inputClass="$errors->has($amountTargetFieldName) ? 'border-red-700' : ''" :value="old($amountTargetFieldName) ?? $question->response->amount_target" />
										@error($amountTargetFieldName)
											<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
										@enderror
									</div>
									<div>
										{{-- Keberadaan --}}
										<x-form.select name="existence[{{ $question->id }}]" placeholder="Pilih Keberadaan" :value="old($existenceFieldName) ?? $question->response->existence" :options="[
										    (object) [
										        'label' => 'Ada',
										        'value' => 'Ada',
										    ],
										    (object) [
										        'label' => 'Tidak Ada',
										        'value' => 'Tidak Ada',
										    ],
										]" :inputClass="$errors->has($existenceFieldName) ? 'border-red-700' : ''" />
										@error($existenceFieldName)
											<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
										@enderror
									</div>
									<div>
										{{-- Kesesuaian Standar --}}
										<x-form.select name="compliance[{{ $question->id }}]" placeholder="Pilih Kesesuaian Standar" :value="old($complianceFieldName) ?? $question->response->compliance" :options="[
										    (object) [
										        'label' => 'Sesuai',
										        'value' => 'Sesuai',
										    ],
										    (object) [
										        'label' => 'Tidak Sesuai',
										        'value' => 'Tidak Sesuai',
										    ],
										]" :inputClass="$errors->has($complianceFieldName) ? 'border-red-700' : ''" />
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
		@else
			<x-main.card>
				<div class="col-span-12 py-8 text-center">
					<p class="text-slate-600">No indicators or questions available.</p>
				</div>
			</x-main.card>
		@endif
		<div class="flex justify-end gap-3">
			@can('submitAuditResults', $instrument)
				<x-button type="submit" color="info">
					Simpan
					<i class="fa-solid fa-floppy-disk ms-2"></i>
				</x-button>
			@endcan
		</div>
	</div>
</form>
