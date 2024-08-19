@php
	$id = isset($multiple) && $multiple ? str_replace('[]', '', $name) : $name;
@endphp
@props([
    'class' => '',
    'name',
    'label' => null,
    'value' => old($id),
    'options',
    'multiple' => false,
    'placeholder' => '',
    'itemSelectText' => 'Press to select',
    'search' => true,
])
@pushOnce('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
	<style>
    .choices {
      margin-bottom: 0px;
    }

		.choices__inner {
			border-radius: 0.5rem;
		}
	</style>
@endPushOnce
<div class="{{ $class }}">
	@if ($label)
		<label for="{{ $name }}" class="text-sm">{{ $label }}</label>
	@endif
	<select name="{{ $name }}" id="{{ $id }}" class="@error($id) is-invalid @enderror" {{ $multiple ? 'multiple' : '' }}>
		@if ($placeholder != '' && !$multiple)
			<option value="">{{ $placeholder }}</option>
		@endif
	</select>
	@error($id)
		<p class="mt-2 text-xs text-red-600">
			{{ $message }}
		</p>
	@enderror
</div>
@pushOnce('scripts')
	<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endPushOnce
@push('scripts2')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const id = @json($id);
			const options = @json($options);
			const placeholder = @json($placeholder);
			const value = @json($value);
			const element = document.querySelector(`#${id}`);
			const isMultiple = @json($multiple);
			const itemSelectText = @json($itemSelectText);
			const search = @json($search);

			const choices = options.map((option) => {
				let selected = false

				if (value) {
					if (isMultiple) {
						selected = value.includes(`${option.value}`)
					} else {
						selected = value == option.value ? true : false
					}
				}

				return {
					value: option.value,
					label: option.label,
					selected
				}
			})

			new Choices(element, {
				removeItemButton: isMultiple,
				choices,
				placeholder: true,
				placeholderValue: placeholder,
				itemSelectText,
				searchEnabled: search
			});

			const choicesInner = element.closest('.choices').querySelector('.choices__inner');
			const invalidFeedback = element.closest('.choices').nextElementSibling;

			if (element.classList.contains('is-invalid')) {
				choicesInner.style.border = '1px solid #ea868f';
				invalidFeedback.style.display = 'block';
			}
		})
	</script>
@endpush
