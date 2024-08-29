@php
	$menus = [
	    (object) [
	        'label' => auth()->check() ? 'Dasbor' : 'Home',
	        'route' => auth()->check() ? route('dashboard.index') : route('home.index'),
	    ],
	    (object) [
					'show' => auth()->check() && (auth()->user()->isAuditee() || auth()->user()->isAuditor()),
	        'label' => 'Survei',
	        'route' => route('survey.index'),
	    ],
	    (object) [
	        'show' => auth()->check() && auth()->user()->isAdmin(),
	        'label' => 'Master',
	        'subMenu' => [
	            (object) [
	                'label' => 'Badan & UPT',
	                'route' => route('dashboard.master.units.index'),
	            ],
	            (object) [
	                'label' => 'Fakultas',
	                'route' => route('dashboard.master.faculties.index'),
	            ],
	            (object) [
	                'label' => 'Jurusan',
	                'route' => route('dashboard.master.departments.index'),
	            ],
	            (object) [
	                'label' => 'Prodi',
	                'route' => route('dashboard.master.programs.index'),
	            ],
	            (object) [
	                'label' => 'Dokumen Mutu',
	                'route' => route('dashboard.master.standards.index'),
	            ],
							(object) [
	                'label' => 'Instrumen',
	                'route' => route('dashboard.master.instruments.index'),
	            ],
	            (object) [
	                'label' => 'Survei',
	                'route' => route('dashboard.master.periodes.index'),
	            ],
	        ],
	    ],
	    (object) [
	        'show' => auth()->check() && auth()->user()->isAdmin(),
	        'label' => 'Pengguna',
	        'subMenu' => [
	            (object) [
	                'label' => 'Auditor',
	                'route' => route('dashboard.users.auditors.index'),
	            ],
	            (object) [
	                'label' => 'Auditi',
	                'route' => route('dashboard.users.auditees.index'),
	            ],
	        ],
	    ],
	];
@endphp

<header class="fixed z-50 w-full border-b-2 border-color-primary-500 bg-white" x-data="{ isOpen: false }">
	{{-- Backdrop --}}
	<div x-cloak x-show="isOpen" @click="isOpen = false" class="fixed inset-0 z-10 bg-black bg-opacity-50"></div>

	{{-- Offcanvas Sidebar --}}
	<div x-cloak x-show="isOpen" x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed left-0 top-0 z-10 h-screen w-[80%] bg-white p-4 shadow-md">
		<div class="inline-flex w-full items-center justify-between p-2">
			<div class="w-10">
				<img src="{{ asset('images/ung.png') }}" alt="Logo UNG" class="w-full">
			</div>
			<div>
				<button @click="isOpen = false" class="rounded-md p-4 px-4 py-2.5 hover:bg-neutral-100">
					<i class="fas fa-times text-neutral-500"></i>
				</button>
			</div>
		</div>
		<div class="mt-4 w-full font-semibold">
			<ul class="flex w-full flex-col gap-y-1">
				@foreach ($menus as $menu)
					@if (isset($menu->subMenu))
						<li class="w-full" x-data="{ subMenuOpen: false }">
							<a @click="subMenuOpen = !subMenuOpen" :class="subMenuOpen ? 'bg-neutral-100' : ''" href="#" class="inline-flex w-full items-center justify-between px-4 py-2">
								{{ $menu->label }}
								<span>
									<i :class="subMenuOpen ? 'rotate-180' : ''" class="fas fa-chevron-down text-xs transition-transform"></i>
								</span>
							</a>
							<div x-show="subMenuOpen" @click.outside="subMenuOpen = false" x-transition class="mt-3 flex w-full flex-col gap-y-1 px-4 text-sm">
								@foreach ($menu->subMenu as $subMenu)
									<a href="{{ $subMenu->route }}" class="rounded-md px-3 py-2">
										{{ $subMenu->label }}
									</a>
									<hr>
								@endforeach
							</div>
						</li>
					@else
						<li class="w-full">
							<a href="{{ $menu->route }}" class="inline-flex w-full items-center justify-between px-4 py-2 hover:bg-neutral-100">
								{{ $menu->label }}
							</a>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>

	{{-- Navbar --}}
	<nav class="mx-auto flex max-w-screen-xl items-center justify-between px-4 py-3.5">
		<div class="flex items-center gap-x-4">
			<div class="inline-flex items-center lg:hidden">
				<button @click="isOpen = !isOpen" class="rounded-lg border px-4 py-2.5 hover:bg-neutral-100">
					<i class="fas fa-bars text-color-primary-500"></i>
				</button>
			</div>
			<img src="{{ asset('images/ung.png') }}" alt="Logo UNG" class="hidden w-10 lg:block">
			<ul class="hidden flex-shrink flex-grow items-center gap-x-1 lg:flex">
				@foreach ($menus as $menu)
					@if (!isset($menu->show) || (isset($menu->show) && $menu->show))
						@if (isset($menu->subMenu))
							<li class="relative" x-data="{ subMenuOpen: false }">
								<div @click="subMenuOpen = !subMenuOpen" :class="subMenuOpen ? 'bg-neutral-100' : ''" class="inline-flex cursor-pointer select-none items-center gap-x-2 rounded-md px-4 py-2.5 text-sm font-semibold text-neutral-700 hover:bg-neutral-100">
									{{ $menu->label }}
									<span>
										<i :class="subMenuOpen ? 'rotate-180' : ''" class="fas fa-chevron-down h-4 w-4 text-xs transition-transform"></i>
									</span>
								</div>
								<div x-show="subMenuOpen" @click.outside="subMenuOpen = false" x-cloak x-transition class="absolute z-10 mt-2 w-56 rounded-md border border-neutral-200 bg-white py-2 text-neutral-700 shadow-md">
									<div class="flex w-full flex-col gap-y-1 text-sm font-semibold">
										@foreach ($menu->subMenu as $subMenu)
											<a href="{{ $subMenu->route }}" class="w-full px-4 py-2.5 hover:bg-neutral-100">
												{{ $subMenu->label }}
											</a>
										@endforeach
									</div>
								</div>
							</li>
						@else
							<li>
								<a href="{{ $menu->route }}" class="rounded-md px-4 py-3 text-sm font-semibold text-neutral-700 hover:bg-neutral-100">
									{{ $menu->label }}
								</a>
							</li>
						@endif
					@endif
				@endforeach
			</ul>
		</div>
		<div>
			@guest
				<x-button color="primary" size="md" outlined="true" onclick="window.location.href='{{ route('auth.login') }}'">
					Masuk
				</x-button>
			@endguest
			@auth
				<div class="relative h-12 w-12 rounded-full" x-data="{ profileMenuOpen: false }">
					<img src="{{ auth()->user()->avatar_url }}" alt="" class="w-full rounded-full border-2 p-1 hover:cursor-pointer" @click="profileMenuOpen = !profileMenuOpen">
					<div x-cloak x-show="profileMenuOpen" @click.outside="profileMenuOpen = false" x-transition class="absolute -left-24 z-10 mt-2 w-36 rounded-md border border-neutral-200 bg-white py-2 text-neutral-700 shadow-md">
						<div class="flex w-full flex-col gap-y-1 text-sm font-semibold">
							<p class="w-full px-4 py-2.5">{{ auth()->user()->name }}</p>
							<form method="POST" action="{{ route('dashboard.logout') }}">
								@csrf
								<button type="submit" class="w-full px-4 py-2.5 text-left text-red-500 hover:cursor-pointer hover:bg-neutral-100">
									Logout
								</button>
							</form>
						</div>
					</div>
				</div>
			@endauth
		</div>
	</nav>
</header>
