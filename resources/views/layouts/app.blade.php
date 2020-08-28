<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Laracasts Video Games</title>
		<link href="{{ mix("/css/main.css") }}" rel="stylesheet">
		@include("layouts.favicon")
	</head>
	<body class="bg-gray-900 text-white">
		<header class="border-b border-gray-800">
			<nav class="container mx-auto flex items-center justify-between px-4 py-6">
				<div class="w-full flex items-center justify-between">
					<a href="/">
						<img src="/img/negative-logo.svg" alt="laracasts" class="w-32 flex-none"/>
					</a>
					<ul class="flex space-x-8">
						<li><a href="#" class="hover:text-gray-400">Games</a></li>
						<li><a href="#" class="hover:text-gray-400">Reviews</a></li>
						<li><a href="#" class="hover:text-gray-400">Coming Soon</a></li>
					</ul>
				</div>
			</nav>
		</header>
	</body>
</html>
