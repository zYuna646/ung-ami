@props([
	'class' => '',
	'name',
	'label' => null,
	'placeholder' => '',
	'inputClass' => '',
	'value' => old($name),
])
<div class="{{ $class }}">
	@if ($label)
		<label for="{{ $name }}" class="mb-2 block text-sm font-medium text-gray-900">
			{{ $label }}
		</label>
	@endif
	<textarea
		id="{{ $name }}"
		name="{{ $name }}"
		placeholder="{{ $placeholder }}"
		{{ $attributes->class(["bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5", $inputClass, 'border-red-700' => $errors->get($name)]) }}
	>{{ $value }}</textarea>
	@error($name)
		<p class="mt-2 text-xs text-red-600">
			{{ $message }}
		</p>
	@enderror
</div>
