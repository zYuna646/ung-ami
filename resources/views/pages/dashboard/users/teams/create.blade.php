@extends('layouts.app', [
    'title' => 'Tambah Tim Auditor',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Tambah Tim Auditor</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Tim Auditor' => route('dashboard.users.teams.index'),
				    'Tambah Data' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
			<form action="{{ route('dashboard.users.teams.store') }}" method="POST" class="flex flex-col gap-5">
				@csrf
				<div x-data>
					<x-form.select name="chief_auditor_id" label="Ketua" :value="request('auditor')" :options="$auditors->map(function ($auditor) {
					    return (object) [
					        'label' => $auditor->user->name,
					        'value' => $auditor->id,
					    ];
					})" @change="window.location.href = '{{ url()->current() }}?auditor=' + $event.target.value" />
				</div>
				@if ($availableToBeMember)
					<x-form.choices name="members[]" label="Anggota" placeholder="Pilih Anggota" :multiple="true" :options="$availableToBeMember->map(function ($member) {
					    return (object) [
					        'label' => $member->user->name,
					        'value' => $member->id,
					    ];
					})" />
				@endif
				<div>
					<x-button type="submit" color="info">
						Submit
					</x-button>
				</div>
			</form>
		</x-main.card>
	</x-main.section>
@endsection
