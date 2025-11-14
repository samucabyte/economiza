<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gradient-to-r from-sky-500 to-slate-500 flex items-center justify-center">
    <div class="bg-white w-full max-w-2xl h-96 flex shadow-lg rounded-lg">
        <!-- Lado esquerdo -->
        <div class="w-1/2 bg-gradient-to-b from-sky-600 to-slate-600 p-8 flex flex-col justify-between rounded-l-lg">
            <h1 class="text-white text-3xl font-semibold">Cadastre-se</h1>
            <div class="flex items-center justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-slate-600 rounded-full w-10 h-10 flex items-center justify-center shadow-lg">
                    ➔
                </a>
            </div>
        </div>

        <!-- Lado direito (formulário) -->
        <div class="w-1/2 p-8 flex flex-col">
            @if (session('erro'))
                <div class="bg-red-300 text-white p-2 rounded mb-4">
                    {{ session('erro') }}
                </div>
            @endif
            <!-- Formulário -->
            <form method="POST" action="{{ route('loginAction') }}" class="mt-4 flex flex-col flex-grow">
                @csrf
                <x-input label="E-mail" type="email" name="email" placeholder="Digite seu e-mail" />
                <x-input label="Senha" type="password" name="password" placeholder="Digite sua senha" />
                <p class="mb-6">Esqueceu a senha? <a href="{{ route('loginReset') }}"
                        class="text-sky-500 text-sm">Clique aqui</a>
                </p>

                <button type="submit"
                    class="bg-sky-600 text-white py-2 rounded-lg hover:bg-sky-700 transition duration-300">
                    ENTRAR
                </button>
            </form>
        </div>
    </div>
</body>

</html>
