<dl class="divide-y divide-gray-200 text-gray-900">
	@foreach ($items as $item)
		<div class="{{ $loop->first ? 'pb-2' : ($loop->last ? 'pt-2' : 'py-2') }} flex flex-col">
			<dt class="font-medium text-gray-700">{{ $item->label }}</dt>
			@if (isset($item->values) && is_iterable($item->values))
				@foreach ($item->values as $value)
					@if (isset($value->file) && $value->file)
						<dd class="text-blue-700"><a href="{{ $value->value }}" target="_blank" class="underline">{{ $value->filename ?? 'View File' }}</a></dd>
					@else
						<dd class="text-gray-500">{{ $value->value }}</dd>
					@endif
				@endforeach
			@else
				@if (isset($item->file) && $item->file)
					<dd class="text-blue-700"><a href="{{ $item->value }}" target="_blank" class="underline">{{ $item->filename ?? 'View File' }}</a></dd>
				@else
					<dd class="text-gray-500">
						@if (isset($item->literal) && $item->literal)
							{!! $item->value !!}
						@else
							{{ $item->value }}
						@endif
					</dd>
				@endif
			@endif
		</div>
	@endforeach
</dl>
