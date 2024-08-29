@extends('layouts.app', [
    'title' => 'Edit Auditor',
])
@push('styles')
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
@endpush
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Auditor</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Survei' => route('dashboard.master.periodes.index'),
				    $periode->formatted_start_date . ' - ' . $periode->formatted_end_date => route('dashboard.master.periodes.show', $periode->uuid),
				    $auditor->user->name => null,
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.master.periodes.auditors.update', [$periode->uuid, $auditor->uuid]) }}" method="POST" class="flex flex-col gap-5">
				@csrf
				@method('PUT')
				<x-form.choices name="units[]" label="Area" placeholder="Pilih Area" :multiple="true" :options="$units->map(function ($unit) {
				    return (object) [
				        'label' => $unit->unit_name,
				        'value' => $unit->id,
				    ];
				})" />
				@if ($instrument->units->contains('unit_name', 'Fakultas'))
					<x-form.choices name="faculties[]" label="Fakultas" placeholder="Pilih Fakultas" :multiple="true" :value="$instrument->faculties
					    ->map(function ($faculty) {
					        return strval($faculty->id);
					    })
					    ->toArray()" :options="$faculties->map(function ($faculty) {
					    return (object) [
					        'label' => $faculty->faculty_name,
					        'value' => $faculty->id,
					    ];
					})" />
				@endif
				@if ($instrument->units->contains('unit_name', 'Jurusan'))
					<x-form.choices name="departments[]" label="Jurusan" placeholder="Pilih Jurusan" :multiple="true" :value="$instrument->departments
					    ->map(function ($department) {
					        return strval($department->id);
					    })
					    ->toArray()" :options="$departments->map(function ($department) {
					    return (object) [
					        'label' => $department->department_name,
					        'value' => $department->id,
					    ];
					})" />
				@endif
				@if ($instrument->units->contains('unit_name', 'Program Studi'))
					<x-form.choices name="programs[]" label="Program Studi" placeholder="Pilih Program Studi" :multiple="true" :value="$instrument->programs
					    ->map(function ($program) {
					        return strval($program->id);
					    })
					    ->toArray()" :options="$programs->map(function ($program) {
					    return (object) [
					        'label' => $program->program_name,
					        'value' => $program->id,
					    ];
					})" />
				@endif
				<div>
					<x-button type="submit" color="info">
						Perbarui
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
@endpush
