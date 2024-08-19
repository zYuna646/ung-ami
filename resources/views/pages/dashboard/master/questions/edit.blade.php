@extends('layouts.app', [
    'title' => 'Edit Pertanyaan',
])
@section('content')
	<x-main.section>
		<div class="flex flex-col justify-between gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
			<div>
				<h1 class="text-lg font-bold">Edit Pertanyaan</h1>
				<x-main.breadcrumb :data="[
				    'Dasbor' => route('dashboard.index'),
				    'Master Survei' => route('dashboard.master.periodes.index'),
				    $question->indicator->instrument->periode->formatted_start_date . ' - ' . $question->indicator->instrument->periode->formatted_end_date => route('dashboard.master.periodes.show', $question->indicator->instrument->periode->uuid),
				    $question->indicator->instrument->name => route('dashboard.master.instruments.show', $question->indicator->instrument->uuid),
				    $question->indicator->name => route('dashboard.master.indicators.show', $question->indicator->uuid),
				    $question->code => null,
				    'Edit' => null,
				]" />
			</div>
		</div>
	</x-main.section>
	<x-main.section>
		<x-main.card>
      <form action="{{ route('dashboard.master.questions.update', $question->uuid) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')
        <x-form.input name="code" label="Kode" placeholder="Isi kode" :value="$question->code" />
        <x-form.input name="text" label="Pertanyaan" placeholder="Isi pertanyaan" :value="$question->text" />
        <x-form.choices name="units[]" label="Area Audit" placeholder="Pilih Area Audit" :multiple="true" :value="$question->units
            ->map(function ($unit) {
                return strval($unit->id);
            })
            ->toArray()" :options="$question->indicator->instrument->periode->units->map(function ($unit) {
            return (object) [
                'label' => $unit->unit_name,
                'value' => $unit->id,
            ];
        })" />
        <div>
          <x-button type="submit" color="info">
            Perbarui
          </x-button>
        </div>
      </form>
		</x-main.card>
	</x-main.section>
@endsection
