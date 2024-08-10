@extends('layouts.app', [
  'mainClass' => 'bg-transparent pt-0'
])
@push('styles')
	<style>
		.bg-brightness {
			position: relative;
			width: 100%;
			height: 100vh;
		}

		.bg-brightness::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-image: url('{{ asset('images/rektorat2.jpg') }}');
			background-size: cover;
			background-position: center;
			filter: brightness(0.2);
			z-index: -1;
		}

		.content {
			position: relative;
			z-index: 1;
		}
	</style>
@endpush
@section('content')
	<section class="bg-brightness h-screen w-full">
		<div class="content mx-auto flex h-full w-full max-w-screen-xl flex-col items-center justify-center px-8 py-24 pt-28 lg:flex-row lg:justify-between">
			<div class="flex w-full max-w-lg flex-col justify-center gap-y-1">
				<h1 class="text-2xl font-black text-white lg:text-5xl">AMI <span class="text-color-primary-500">UNG</span></h1>
				<p class="text-lg font-bold text-white lg:mt-4 lg:text-2xl">Universitas Negeri Gorontalo</p>
				<p class="text-xs text-white lg:text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro
					dolore consequuntur iste hic voluptate sequi saepe a laboriosam magni. Corporis?</p>
				{{-- <x-button class="mt-4 w-fit" onclick="window.location.href='{{ route('list_survei') }}'">
        Lihat Survei
      </x-button> --}}
			</div>
			<div class="flex justify-center">
				<div class="w-auto p-4">
					<img src="{{ asset('images/hero.png') }}" alt="" class="w-full">
				</div>
			</div>
		</div>
	</section>
	<section class="w-full">
		<div class="">

		</div>
	</section>
@endsection
