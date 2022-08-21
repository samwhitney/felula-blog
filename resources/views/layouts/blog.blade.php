<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
		<link href="https://fonts.googleapis.com/css2?family=Playfair Display:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
		@livewireStyles
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">

            <!-- Page Heading -->
            <header class="bg-slate-700 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
					<a href="/">
						<h2 class="font-bold font-playfair text-4xl text-orange-200 uppercase tracking-wide">
							{{ __('Felula') }}
						</h2>
					</a>
 					@if (Route::has('login'))
						<div class="font-bold text-slate-300 tracking-wide uppercase">
							@auth
								<a href="{{ url('/admin/posts') }}">Dashboard</a>
							@else
								<a href="{{ route('login') }}">Log in</a>

								@if (Route::has('register'))
									<a href="{{ route('register') }}" class="ml-4">Register</a>
								@endif
							@endauth
						</div>
					@endif
                </div>
            </header>

            <!-- Page Content -->
            <main>
				<div class="py-12">
					<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              		 	 {{ $slot }}
					</div>
				</div>
            </main>
        </div>
        @livewireScripts
    </body>
</html>