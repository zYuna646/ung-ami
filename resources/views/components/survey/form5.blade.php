<form action="{{ route('survey.ptk.store', $instrument->uuid) }}" method="POST">
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
							$recommendationsFieldName = "recommendations.{$question->id}";
							$improvementPlanFieldName = "improvement_plan.{$question->id}";
							$completionScheduleFieldName = "completion_schedule.{$question->id}";
							$monitoringMechanismFieldName = "monitoring_mechanism.{$question->id}";
							$responsiblePartyFieldName = "responsible_party.{$question->id}";
						@endphp

						<div class="grid grid-cols-3 gap-3">
							<div>
								{{-- Rekomendasi --}}
								<x-form.textarea name="recommendations[{{ $question->id }}]" placeholder="Rekomendasi" :inputClass="$errors->has($recommendationsFieldName) ? 'border-red-700' : ''" :value="old($recommendationsFieldName) ?? $question->response->recommendations" />
								@error($recommendationsFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</div>
							<div>
								{{-- Rencana Perbaikan --}}
								<x-form.textarea name="improvement_plan[{{ $question->id }}]" placeholder="Rencana Perbaikan" :inputClass="$errors->has($improvementPlanFieldName) ? 'border-red-700' : ''" :value="old($improvementPlanFieldName) ?? $question->response->improvement_plan" />
								@error($improvementPlanFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</div>
							<div>
								{{-- Jadwal Penyelesaian --}}
								<x-form.textarea name="completion_schedule[{{ $question->id }}]" placeholder="Jadwal Penyelesaian" :inputClass="$errors->has($completionScheduleFieldName) ? 'border-red-700' : ''" :value="old($completionScheduleFieldName) ?? $question->response->completion_schedule" />
								@error($completionScheduleFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</div>
						</div>
						<div class="grid grid-cols-2 gap-3">
							<div>
								{{-- Mekanisme Monitoring --}}
								<x-form.textarea name="monitoring_mechanism[{{ $question->id }}]" placeholder="Mekanisme Monitoring" :inputClass="$errors->has($monitoringMechanismFieldName) ? 'border-red-700' : ''" :value="old($monitoringMechanismFieldName) ?? $question->response->monitoring_mechanism" />
								@error($monitoringMechanismFieldName)
									<p class="mt-2 text-xs text-red-600">{{ $message }}</p>
								@enderror
							</div>
							<div>
								{{-- Pihak yang Bertanggungjawab --}}
								<x-form.textarea name="responsible_party[{{ $question->id }}]" placeholder="Pihak yang Bertanggungjawab" :inputClass="$errors->has($responsiblePartyFieldName) ? 'border-red-700' : ''" :value="old($responsiblePartyFieldName) ?? $question->response->responsible_party" />
								@error($responsiblePartyFieldName)
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
			@can('submitPTK', $instrument)
				<x-button type="submit" color="info">
					Simpan
					<i class="fa-solid fa-floppy-disk ms-2"></i>
				</x-button>
			@endcan
		</div>
	</div>
</form>
