@php
	use App\Constants\AuditStatus;
	use App\Helpers\ModelHelper;

	$area = request('area') ?? auth()->user()->entityId() . auth()->user()->entityType();
	$auditee = ModelHelper::getModelByArea($area);
@endphp
<x-main.card>
	<x-main.list :items="[
	    (object) [
	        'label' => 'Nama Periode',
	        'value' => $instrument->periode->periode_name . ' (' . $instrument->periode->year . ')',
	    ],
	    (object) [
	        'label' => 'Waktu',
	        'value' => $instrument->periode->formatted_start_date . ' - ' . $instrument->periode->formatted_end_date,
	    ],
	    (object) [
	        'label' => 'Standar',
	        'value' => $instrument->periode->standard->name,
	    ],
	    (object) [
	        'label' => 'Tipe',
	        'value' => $instrument->periode->tipe,
	    ],
	    (object) [
	        'label' => 'Auditi',
	        'value' => $auditee?->faculty_name ? 'Fakultas ' . $auditee?->faculty_name : ($auditee?->program_name ? 'Program ' . $auditee?->program_name : $auditee?->unit_name ?? '-'),
	    ],
	    (object) [
	        'label' => 'Status',
	        'value' => isset($auditee) ? $instrument->auditStatus($area) : '-',
	    ],
	]" />
</x-main.card>
