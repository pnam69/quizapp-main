<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quiz App')</title>
    @vite('resources/css/app.css') <!-- Tailwind if using -->
</head>

<body class="bg-gray-50 font-sans min-h-screen">
    <header class="bg-white shadow p-4">
        <h1 class="text-xl font-bold">@yield('header', 'Quiz Management')</h1>
    </header>

    <main class="p-6">
        @yield('content')
    </main>
</body>

</html>