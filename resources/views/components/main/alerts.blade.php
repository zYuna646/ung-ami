@if (session('success'))
	<div 
		id="success-alert" 
		x-data="{ show: true }" 
		x-init="setTimeout(() => show = false, 5000)" 
		x-show="show" 
		x-transition:enter="transition-opacity ease-out duration-500" 
		x-transition:enter-start="opacity-0" 
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-in duration-500" 
		x-transition:leave-start="opacity-100" 
		x-transition:leave-end="opacity-0"
		class="alert-container w-full max-w-screen-xl mx-auto mt-5 flex items-center rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-800" 
		role="alert"
	>
		<svg class="me-3 inline h-4 w-4 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
			<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
		</svg>
		<span class="sr-only">Info</span>
		<div>
			{{ session('success') }}
		</div>
		<button 
			type="button" 
			@click="show = false" 
			class="close-alert-button ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" 
			aria-label="Close"
		>
			<span class="sr-only">Close</span>
			<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
			</svg>
		</button>
	</div>
@endif

@if ($errors->any())
	<div 
		id="error-alert" 
		x-data="{ show: true }" 
		x-init="setTimeout(() => show = false, 5000)" 
		x-show="show" 
		x-transition:enter="transition-opacity ease-out duration-500" 
		x-transition:enter-start="opacity-0" 
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-in duration-500" 
		x-transition:leave-start="opacity-100" 
		x-transition:leave-end="opacity-0"
		class="alert-container w-full max-w-screen-xl mx-auto mt-5 flex rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-800" 
		role="alert"
	>
		<svg class="me-3 mt-[2px] inline h-4 w-4 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
			<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
		</svg>
		<span class="sr-only">Danger</span>
		<div>
			<span class="font-medium">Proses Gagal</span>
      @if (count($errors->all()) > 1)
        <ul class="mt-1.5 list-inside list-disc">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      @else
        <span class="mt-1.5 block">{{ $errors->first() }}</span>
      @endif
		</div>
		<button 
			type="button" 
			@click="show = false" 
			class="close-alert-button ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" 
			aria-label="Close"
		>
			<span class="sr-only">Close</span>
			<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
			</svg>
		</button>
	</div>
@endif