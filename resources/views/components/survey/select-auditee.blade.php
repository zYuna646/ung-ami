@if (auth()->user()->isAuditor())
	@php
		$auditor = auth()->user()->auditor;

		// Get the auditor's teams as both member and chief
$auditorTeams = $auditor->member_teams->merge($auditor->chief_teams); // Combine member and chief teams

// Filter areas based on whether the auditor is a team member or chief
$filteredAreas = $instrument->areas()->filter(function ($area) use ($auditorTeams, $instrument) {
    // Find the team for the specific area (unit, faculty, or program)
    $data = $instrument
        ->entityTeams()
        ->where('entity_id', $area->id)
        ->where('entity_type', class_basename($area))
		        ->first();

		    // Check if the auditor is either a member or the chief of the team for this area
		    if ($data && $auditorTeams->contains($data->team)) {
		        return true;
		    }
		    return false;
		});
	@endphp

	<div x-data="{ selectedArea: '{{ request('area') }}' }" class="space-y-5">
		<x-form.select
			name="area"
			label="Auditi"
			placeholder="Pilih Auditi"
			:value="request('area')"
			:options="$filteredAreas->map(function ($area) {
			    return (object) [
			        'label' => $area->unit_name ?? ($area->faculty_name ?? $area->program_name),
			        'value' => $area->id . $area->model_type,
			    ];
			})"
			@change="
            selectedArea = $event.target.value; 
            window.location.href = '{{ url()->current() }}?area=' + selectedArea;
        "
		/>
	</div>
@endif
