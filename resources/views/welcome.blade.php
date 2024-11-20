<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Custom</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900 text-gray-200">
    <div class="bg-gray-900 text-gray-200 min-h-screen flex flex-col items-center justify-center">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px] opacity-50" src="https://laravel.com/assets/img/welcome/background.svg" alt="Laravel background" />

        <header class="py-8">
            <h1 class="text-4xl font-bold text-teal-400">Welcome to My Custom Laravel Page</h1>
            <p class="mt-2 text-teal-200">Explore the power of Laravel with a touch of style</p>
        </header>

        <main class="mt-10 px-4 grid gap-6 lg:grid-cols-3">
            <!-- Card 1 -->
            <a href="https://laravel.com/docs" class="p-6 rounded-lg bg-teal-800 shadow-lg transition duration-300 hover:bg-teal-700 hover:text-white focus:ring-2 focus:ring-teal-400">
                <h2 class="text-2xl font-semibold text-white">Documentation</h2>
                <p class="mt-2">Discover comprehensive guides for every aspect of Laravel. Perfect for beginners and experts alike.</p>
            </a>

            <!-- Card 2 -->
            <a href="https://laracasts.com" class="p-6 rounded-lg bg-indigo-800 shadow-lg transition duration-300 hover:bg-indigo-700 hover:text-white focus:ring-2 focus:ring-indigo-400">
                <h2 class="text-2xl font-semibold text-white">Laracasts</h2>
                <p class="mt-2">Access thousands of video tutorials on Laravel, PHP, and JavaScript to level up your skills.</p>
            </a>

            <!-- Card 3 -->
            <a href="https://laravel-news.com" class="p-6 rounded-lg bg-purple-800 shadow-lg transition duration-300 hover:bg-purple-700 hover:text-white focus:ring-2 focus:ring-purple-400">
                <h2 class="text-2xl font-semibold text-white">Laravel News</h2>
                <p class="mt-2">Stay updated with the latest in the Laravel ecosystem, from news to tutorials.</p>
            </a>

            <!-- Card 4 -->
            <div class="p-6 rounded-lg bg-pink-800 shadow-lg text-white">
                <h2 class="text-2xl font-semibold">Vibrant Ecosystem</h2>
                <p class="mt-2">Explore tools like <a href="https://forge.laravel.com" class="underline hover:text-pink-300">Forge</a>, <a href="https://nova.laravel.com" class="underline hover:text-pink-300">Nova</a>, and more to extend Laravel.</p>
            </div>
        </main>

        <footer class="py-6 mt-10 text-center text-gray-500">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
</body>
</html>