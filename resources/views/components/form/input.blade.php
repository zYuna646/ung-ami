@props([
	'class' => '',
	'name',
	'label' => null,
	'inputClass' => '',
	'type' => 'text',
	'placeholder' => '',
	'maxlength' => '',
	'value' => ''
])

<div class="{{ $class }}">
	@if ($label)
		<label for="{{ $name }}" class="mb-2 block text-sm font-medium text-gray-900">
			{{ $label }}
		</label>
	@endif
	<input
		type="{{ $type }}"
		id="{{ $name }}"
		name="{{ $name }}"
		{{ $attributes->class(["block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500", $inputClass, 'border-red-700' => $errors->get(str_replace('[]', '', $name))]) }}
		placeholder="{{ $placeholder }}"
		maxlength="{{ $maxlength }}"
		value="{{ old($name) ?? $value }}"
	/>
	@error(str_replace('[]', '', $name))
		<p class="mt-2 text-xs text-red-600">
			{{ $message }}
		</p>
	@enderror
</div>
