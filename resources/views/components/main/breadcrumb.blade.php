<nav class="{{ $class ?? '' }} flex justify-between text-sm text-slate-500" aria-label="Breadcrumb">
	<ol class="inline-flex items-center space-x-2">
		@foreach ($data as $name => $url)
			<li class="inline-flex items-center">
				@if ($url)
					<a href="{{ $url }}" class="text-sm text-color-info-500 underline">{{ $name }}</a>
				@else
					<span class="text-sm text-slate-700" aria-current="page">{{ $name }}</span>
				@endif
			</li>
			@if (!$loop->last)
				<li><span class="text-gray-400">/</span></li>
			@endif
		@endforeach
	</ol>
</nav>
