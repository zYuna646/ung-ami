@if (session('success'))
	<x-alerts.success />
@endif

@if ($errors->any())
	<x-alerts.error>
		@if (count($errors->all()) > 1)
			<ul class="mt-1.5 list-inside list-disc">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		@else
			<span class="mt-1.5 block">{{ $errors->first() }}</span>
		@endif
	</x-alerts.error>
@endif
