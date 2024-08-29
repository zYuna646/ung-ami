<div x-data="{ selectedUnit: '{{ request('unit') }}' }" class="space-y-5">
	<x-form.select name="unit" label="Auditi" placeholder="Pilih Auditi" :value="request('unit')" :options="$instrument->units->map(function ($unit) {
	    return (object) [
	        'label' => $unit->unit_name,
	        'value' => $unit->unit_name,
	    ];
	})" @change="selectedUnit = $event.target.value; window.location.href = '{{ url()->current() }}?unit=' + selectedUnit" />

	@if (request('unit') == 'Fakultas')
		<x-form.select name="faculty" label="Fakultas" placeholder="Pilih Fakultas" :value="request('faculty')" :options="$instrument->faculties->map(function ($faculty) {
		    return (object) [
		        'label' => $faculty->faculty_name,
		        'value' => $faculty->faculty_name,
		    ];
		})" @change="window.location.href = '{{ url()->current() }}?unit=' + selectedUnit + '&faculty=' + $event.target.value" />
	@endif

	@if (request('unit') == 'Jurusan')
		<x-form.select name="department" label="Jurusan" placeholder="Pilih Jurusan" :value="request('department')" :options="$instrument->departments->map(function ($department) {
		    return (object) [
		        'label' => $department->department_name,
		        'value' => $department->department_name,
		    ];
		})" @change="window.location.href = '{{ url()->current() }}?unit=' + selectedUnit + '&department=' + $event.target.value" />
	@endif

	@if (request('unit') == 'Program Studi')
		<x-form.select name="program" label="Program Studi" placeholder="Pilih Program Studi" :value="request('program')" :options="$instrument->programs->map(function ($program) {
		    return (object) [
		        'label' => $program->program_name,
		        'value' => $program->program_name,
		    ];
		})" @change="window.location.href = '{{ url()->current() }}?unit=' + selectedUnit + '&program=' + $event.target.value" />
	@endif
</div>
