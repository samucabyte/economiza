<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-gradient-to-r from-sky-500 to-slate-500 flex items-center justify-center">
    <div class="bg-white w-full max-w-4xl flex shadow-lg rounded-lg">
        <!-- Lado direito (formulário) -->
        <div class="w-full p-8 flex flex-col">
            <x-arrow-back :href="route('login')" />
            <!-- Formulário -->
            <form method="POST" action="{{ route('registerAction') }}" class="flex flex-col flex-grow">
                @csrf
                <x-input label="nome" type="text" name="name" placeholder="Digite seu Nome" error="name" />

                <x-input label="E-mail" type="email" name="email" placeholder="Digite seu e-mail" error="email" />

                <x-input label="Senha" type="password" name="password" placeholder="Digite sua senha"
                    error="password" />

                <button type="submit"
                    class="bg-sky-600 text-white py-2 rounded-lg hover:bg-sky-700 transition duration-300">
                    Cadastrar
                </button>
            </form>
        </div>
    </div>
</body>

</html>
