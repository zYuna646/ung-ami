<ul class="flex flex-wrap">
	@php
		$queryParams = ['area' => request('area')];
		// if (request('faculty')) {
		//     $queryParams['faculty'] = request('faculty');
		// } elseif (request('department')) {
		//     $queryParams['department'] = request('department');
		// } elseif (request('program')) {
		//     $queryParams['program'] = request('program');
		// }
	@endphp

	<li class="me-2">
		<a href="{{ route('survey.show', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.show') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
			Survei Auditi
		</a>
	</li>
	<li class="me-2">
		<a href="{{ route('survey.audit_results', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.audit_results') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
			Hasil Audit Lapangan
		</a>
	</li>
	<li class="me-2">
		<a href="{{ route('survey.compliance_results', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.compliance_results') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4" aria-current="page">
			Hasil Audit Lapangan Kesesuaian
		</a>
	</li>
	<li class="me-2">
		<a href="{{ route('survey.noncompliance_results', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.noncompliance_results') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
			Hasil Audit Lapangan Ketidaksesuaian
		</a>
	</li>
	<li class="me-2">
		<a href="{{ route('survey.ptk', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.ptk') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
			PTK
		</a>
	</li>
	<li class="me-2">
		<a href="{{ route('survey.ptp', [$instrument->uuid] + $queryParams) }}" class="{{ request()->routeIs('survey.ptp') ? 'border-b-2 border-color-primary-500 text-color-primary-500' : 'hover:border-gray-300 hover:text-gray-600' }} inline-block rounded-t-lg p-4">
			PTP
		</a>
	</li>
</ul>
