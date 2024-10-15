<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="{{ asset('images/ung.png') }}" type="image/x-icon">
		<title>{{ config('app.name') }}{{ isset($title) ? " | $title" : '' }}</title>
		<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<script src="{{ asset('js/app.js') }}" defer></script>

		@stack('styles')
		<style>
			[x-cloak] {
				display: none !important;
			}
		</style>
	</head>

	<body>
		@include('components.main.navbar')
		<main class="{{ $mainClass ?? '' }} min-h-screen bg-[#f9fafc] py-[74px]">
			@if (!isset($showAlert) || $showAlert)
				@include('components.main.alerts')
			@endif
			@yield('content')
		</main>
		@stack('scripts')
		@stack('scripts2')
	</body>

</html>
