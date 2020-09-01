<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Laracasts Video Games</title>
		<link href="{{ mix("/css/main.css") }}" rel="stylesheet">
		@include("layouts.favicon")
	</head>
	<body class="flex flex-col min-h-screen bg-gray-900 text-white">
		<header class="border-b border-gray-800">
			<nav class="container mx-auto flex flex-col lg:flex-row items-center justify-between px-4 py-6">
				<div class="flex flex-col lg:flex-row items-center">
					<a href="/">
						<img src="/img/negative-logo.svg" alt="laracasts" class="w-32 flex-none"/>
					</a>
					<ul class="flex ml-0 lg:ml-16 mt-6 lg:mt-0 space-x-8">
						<li><a href="#" class="hover:text-gray-400">Games</a></li>
						<li><a href="#" class="hover:text-gray-400">Reviews</a></li>
						<li><a href="#" class="hover:text-gray-400">Coming Soon</a></li>
					</ul>
				</div>
        <div class="flex items-center mt-6 lg:mt-0">
          <div class="relative">
            <input class="bg-gray-800 text-sm rounded-full w-64 pl-8 pr-3 py-1 focus:outline-none focus:shadow-outline" type="text" placeholder="Search...">
            <div class="absolute top-0 flex items-center h-full ml-2">
              <svg viewBox="0 0 20 20" class="fill-current text-gray-400 w-4 h-4">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </div>
          </div>
          <div class="ml-6">
            <a href="#" target="_blank">
              <img src="/img/avatar.png" alt="avatar" class="rounded-full w-8"/>
            </a>
          </div>
        </div>
			</nav>
		</header>
    <main class="flex-grow py-8">
      @yield("content")
    </main>
    <footer class="border-t border-gray-800">
      <div class="container mx-auto px-4 py-6">
        Powered by <a class="underline hover:text-gray-400" href="https://www.igdb.com/api" target="_blank">IGDB API</a>
      </div>
    </footer>
    <livewire:scripts>
	</body>
</html>
