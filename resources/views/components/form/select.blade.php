@props([
    'class' => '',
    'name',
    'label' => null,
    'inputClass' => '',
    'value' => old($name),
    'options',
    'placeholder' => null,
    'required' => false,
])
<div class="{{ $class }}">
	@if ($label)
		<label for="{{ $name }}" class="mb-2 block text-sm font-medium text-gray-900">
			{{ $label }}
		</label>
	@endif
	<select
		id="{{ $name }}"
		name="{{ $name }}"
		{{ $attributes->class(['bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-gray-500 block w-full p-2.5', $inputClass, 'border-red-700' => $errors->get($name)]) }}
		{{ $required ? 'required' : '' }}
	>
		<option value="" hidden>
			@if ($placeholder)
				{{ $placeholder }}
			@else
				Pilih {{ $label }}
			@endif
		</option>
		@foreach ($options as $option)
			<option value="{{ $option->value }}" {{ $option->value == $value ? 'selected' : '' }}>{{ $option->label }}</option>
		@endforeach
	</select>
	@error($name)
		<p class="mt-2 text-xs text-red-600">
			{{ $message }}
		</p>
	@enderror
</div>
