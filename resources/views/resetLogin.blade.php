<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gradient-to-r from-sky-500 to-slate-500 flex items-center justify-center">
    <div class="bg-white w-full max-w-2xl h-96 flex shadow-lg rounded-lg">
        <!-- Lado direito (formulário) -->
        <div class="w-full justify-center p-8 flex flex-col">
            @if (session('erro'))
                <div class="bg-red-300 text-white p-2 rounded mb-4">
                    {{ session('erro') }}
                </div>
            @endif

            <!-- Instrução de reset de senha -->
            <div class="text-center text-lg mb-4">Digite o e-mail que você utilizou no cadastro</div>
            <x-arrow-back href="{{ route('login') }}" />
            <!-- Formulário -->
            <form method="POST" action="{{ route('passwordReset') }}" class="mt-4 flex flex-col flex-grow">
                @csrf
                <x-input label="E-mail" type="email" name="email" placeholder="Digite seu e-mail" />

                <button type="submit"
                    class="bg-sky-600 text-white py-2 rounded-lg hover:bg-sky-700 transition duration-300 mt-4">
                    Enviar
                </button>
            </form>
        </div>
    </div>
</body>

</html>
