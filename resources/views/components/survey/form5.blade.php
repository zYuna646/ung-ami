<form action="{{ route('survey.ptk.store', $instrument->uuid) }}" method="POST">
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
								<th class="border px-4 py-2">Akar Penyebab / Faktor Penghambat</th>
								<th class="border px-4 py-2">Rekomendasi</th>
								<th class="border px-4 py-2">Rencana Perbaikan</th>
								<th class="border px-4 py-2">Jadwal Penyelesaian</th>
								<th class="border px-4 py-2">Mekanisme Monitoring</th>
								<th class="border px-4 py-2">Pihak Yang Bertanggung Jawab</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($questions as $question)
								<tr>
									<td class="border px-4 py-2 text-center">{{ $question->code }}</td>
									<td class="border px-4 py-2">{{ $question->response->description ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->barriers ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->recommendations ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->improvement_plan ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->completion_schedule ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->monitoring_mechanism ?? '' }}</td>
									<td class="border px-4 py-2">{{ $question->response->responsible_party ?? '' }}</td>
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
								$recommendationsFieldName = "recommendations.{$question->id}";
								$improvementPlanFieldName = "improvement_plan.{$question->id}";
								$completionScheduleFieldName = "completion_schedule.{$question->id}";
								$monitoringMechanismFieldName = "monitoring_mechanism.{$question->id}";
								$responsiblePartyFieldName = "responsible_party.{$question->id}";
							@endphp

							<div class="grid grid-cols-3 gap-3">
								<div>
									{{-- Rekomendasi --}}
									<x-form.textarea
										required
										name="recommendations[{{ $question->id }}]"
										placeholder="Rekomendasi"
										:inputClass="$errors->has($recommendationsFieldName) ? 'border-red-700' : ''"
										:value="old($recommendationsFieldName) ?? $question->response->recommendations"
									/>
									@error($recommendationsFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
								<div>
									{{-- Rencana Perbaikan --}}
									<x-form.textarea
										required
										name="improvement_plan[{{ $question->id }}]"
										placeholder="Rencana Perbaikan"
										:inputClass="$errors->has($improvementPlanFieldName) ? 'border-red-700' : ''"
										:value="old($improvementPlanFieldName) ?? $question->response->improvement_plan"
									/>
									@error($improvementPlanFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
								<div>
									{{-- Jadwal Penyelesaian --}}
									<x-form.textarea
										required
										name="completion_schedule[{{ $question->id }}]"
										placeholder="Jadwal Penyelesaian"
										:inputClass="$errors->has($completionScheduleFieldName) ? 'border-red-700' : ''"
										:value="old($completionScheduleFieldName) ?? $question->response->completion_schedule"
									/>
									@error($completionScheduleFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<div class="grid grid-cols-2 gap-3">
								<div>
									{{-- Mekanisme Monitoring --}}
									<x-form.textarea
										required
										name="monitoring_mechanism[{{ $question->id }}]"
										placeholder="Mekanisme Monitoring"
										:inputClass="$errors->has($monitoringMechanismFieldName) ? 'border-red-700' : ''"
										:value="old($monitoringMechanismFieldName) ?? $question->response->monitoring_mechanism"
									/>
									@error($monitoringMechanismFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
								<div>
									{{-- Pihak yang Bertanggungjawab --}}
									<x-form.textarea
										required
										name="responsible_party[{{ $question->id }}]"
										placeholder="Pihak yang Bertanggungjawab"
										:inputClass="$errors->has($responsiblePartyFieldName) ? 'border-red-700' : ''"
										:value="old($responsiblePartyFieldName) ?? $question->response->responsible_party"
									/>
									@error($responsiblePartyFieldName)
										<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
									@enderror
								</div>
							</div>
							<p class="text-right text-sm text-gray-600">{{ $question->code }}</p>
						</div>
					@endforeach
				</x-main.card>
				<div class="flex justify-end gap-3">
					@can('submitPTK', $instrument)
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
