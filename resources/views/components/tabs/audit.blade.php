<ul class="flex flex-wrap">
	@php
		$queryParams = ['area' => request('area')];
	@endphp
	@can('viewSurvey', $instrument)
		<li class="me-2">
			<a href="{{ route('survey.show', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.show') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
				{{ auth()->user()->isAuditor() ? 'Survei Auditi' : 'Survei' }}
			</a>
		</li>
	@endcan
	@can('showAuditResults', $instrument)
		<li class="me-2">
			<a href="{{ route('survey.audit_results', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.audit_results') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
				Hasil Audit Lapangan
			</a>
		</li>
	@endcan
	@can('showComplianceResults', $instrument)
		<li class="me-2">
			<a href="{{ route('survey.compliance_results', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.compliance_results') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4" aria-current="page">
				Hasil Audit Lapangan Kesesuaian
			</a>
		</li>
	@endcan
	@can('showNoncomplianceResults', $instrument)
		<li class="me-2">
			<a href="{{ route('survey.noncompliance_results', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.noncompliance_results') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
				Hasil Audit Lapangan Ketidaksesuaian
			</a>
		</li>
	@endcan
	@can('showPTK', $instrument)
		<li class="me-2">
			<a href="{{ route('survey.ptk', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.ptk') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
				PTK
			</a>
		</li>
	@endcan
	@can('showPTP', $instrument)
		<li class="me-2">
			<a href="{{ route('survey.ptp', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.ptp') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
				PTP
			</a>
		</li>
	@endcan
	@can('showReport', $instrument)
		<li class="me-2">
			<a href="{{ route('survey.report', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.report') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
				Laporan
			</a>
		</li>
	@endcan
</ul>
