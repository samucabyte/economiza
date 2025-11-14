<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="max-w-5xl mx-auto">

        <!-- Navbar -->
        <nav class="bg-white shadow-md rounded-lg mb-6 mt-6">
            <div class="max-w-5xl mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                        QueroEconomiza
                    </a>

                    <!-- Links Desktop -->
                    <div class="hidden md:flex gap-6 items-center">
                        @auth
                            <a href="{{ route('profile') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                                {{ Auth::user()->name }}
                            </a>
                        @endauth
                        <a href="{{ route('logout') }}" class="text-gray-700 hover:text-blue-600 font-medium">Sair
                        </a>

                        @guest
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Login</a>
                        @endguest


                    </div>

                    <!-- Botão Mobile -->
                    <div class="md:hidden">
                        <button id="menu-toggle"
                            class="text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-600 p-2 rounded-lg">
                            ☰
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div id="mobile-menu" class="hidden md:hidden px-4 pb-4">
                <a href="{{ route('categories') }}" class="block py-2 text-gray-700 hover:text-blue-600">Sair</a>

                @guest
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-blue-600">Login</a>
                @endguest

                @auth
                    <a href="{{ route('profile') }}" class="block py-2 text-gray-700 hover:text-blue-600">
                        {{ Auth::user()->name }}
                    </a>
                @endauth
            </div>
        </nav>

        <!-- Conteúdo principal -->
        <main class="p-6">
            @yield('content')
        </main>
    </div>

    <footer class="mt-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} QueroEconomiza - Todos os direitos reservados.
    </footer>
    @yield('scripts')
    <script>
        // Toggle menu mobile
        document.getElementById('menu-toggle').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden')
        })
    </script>
</body>

</html>
