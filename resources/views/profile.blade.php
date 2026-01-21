<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-sky-700 via-blue-800 to-slate-900 flex items-center justify-center p-6">

    <div
        class="backdrop-blur-xl bg-white/10 border border-white/10 shadow-[0_8px_40px_rgba(0,0,0,0.4)]
                w-full max-w-3xl rounded-3xl p-10 text-white animate-[fadeIn_0.5s_ease_forwards]">

        <!-- Botão voltar -->
        <div class="mb-6">
            <x-arrow-back :href="route('home')" />
        </div>

        <!-- Cabeçalho -->
        <div class="mb-8">
            <h1 class="text-4xl font-semibold tracking-wide">Meu Perfil</h1>
            <p class="text-white/70 mt-2">Gerencie suas informações pessoais e categorias financeiras.</p>
        </div>

        <!-- Formulário -->
        <form method="POST" action="{{ route('profileAction') }}" class="space-y-6">
            @csrf

            <!-- Nome (mantido igual!) -->
            <div class="text-black">
                <x-input label="Nome" type="text" name="name" :value="$user->name ?? ''" error="errorName" />
            </div>

            <!-- CATEGORIAS DINÂMICAS -->
            <div class="text-white">
                <div class="flex items-center">
                    <label class="font-semibold block mb-2">Categorias</label>
                    <div id="btMuv" class="ml-2  cursor-pointer p-1 border rounded-md border-green-400 text-xl">
                        <span id="btnSt">↓</span>
                    </div>
                </div>


                <div id="categories-wrapper"
                    class="overflow-hidden transition-all duration-500 ease-in-out
            max-h-0 opacity-0 translate-y-[-10px] space-y-4 text-black ">

                    <!-- Categorias existentes -->
                    @if (!empty($categories))
                        @foreach ($categories as $cat)
                            <div class="flex mt-8 items-center gap-3 category-item">
                                <input type="text" name="categories[]" value="{{ $cat->name }}"
                                    class="w-full  p-3 rounded-lg" placeholder="Digite uma categoria">
                                <button type="button"
                                    class="remove-category bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition">
                                    -
                                </button>
                            </div>
                        @endforeach
                    @else
                        <!-- Caso não exista nenhuma categoria -->
                        <div class="flex items-center gap-3 category-item">
                            <input type="text" name="categories[]" class="w-full p-3 rounded-lg"
                                placeholder="Digite uma categoria">
                            <button type="button"
                                class="remove-category bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition">
                                -
                            </button>
                        </div>
                    @endif
                    <!-- Botão adicionar categoria -->

                    <button type="button" id="add-category"
                        class="mt-3 bg-green-500 hover:bg-green-600 px-4 py-2 rounded-xl font-semibold text-white transition">
                        + Adicionar Categoria
                    </button>
                </div>


            </div>

            <!-- Botão Salvar -->
            <button type="submit"
                class="w-full bg-sky-500 hover:bg-sky-600 active:bg-sky-800 
                       py-3 rounded-2xl text-white font-semibold text-lg 
                       transition-all shadow-lg hover:shadow-sky-500/40 duration-300">
                Salvar
            </button>
        </form>
        <hr class="mt-8">
        </hr>
        <form method="POST" action="{{ route('profilePasswordAction') }}" class="space-y-6">
            @csrf
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <label class="font-semibold block mt-2 text-2xl text-center">Trocar a senha</label>
            <div class="flex flex-col items-center gap-3 ">
                <input type="password" name="currentPassword" required class="w-full text-black mt-2 p-3 rounded-lg"
                    placeholder="Digite a sua senha atual">
                <input type="password" name="newPassword" required class="w-full text-black p-3 rounded-lg"
                    placeholder="Digite a sua nova senha">
                <input type="password" name="newPassword_confirmation" required class="w-full text-black p-3 rounded-lg"
                    placeholder="Digite novamente a sua nova senha">
                <button type="submit"
                    class=" w-full bg-green-500 text-white px-3 py-2 rounded-lg hover:bg-green-600 transition">
                    Atualizar
                </button>
            </div>
        </form>

    </div>

    <!-- Script das categorias dinâmicas -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('categories-wrapper');
            const addBtn = document.getElementById('add-category');
            const btnCatg = document.getElementById('btMuv');
            const btnSt = document.getElementById("btnSt");

            // Adicionar categoria
            addBtn.addEventListener('click', () => {
                const div = document.createElement('div');
                div.className = "flex items-center gap-3 category-item";

                div.innerHTML = `
                    <input 
                        type="text"
                        name="categories[]"
                        class="w-full p-3 rounded-lg mt-2"
                        placeholder="Digite uma categoria"
                    >
                    <button type="button"
                        class="remove-category bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition">
                        -
                    </button>
                `;

                // wrapper.appendChild(div);
                wrapper.insertBefore(div, addBtn);


            });

            // Remover categoria
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-category')) {
                    e.target.parentElement.remove();
                }
            });
            btnCatg.addEventListener('click', function() {


                wrapper.classList.toggle('max-h-0');
                wrapper.classList.toggle('opacity-0');
                wrapper.classList.toggle('translate-y-[-10px]');
                wrapper.classList.toggle('max-h-scren');
                wrapper.classList.toggle('opacity-100');
                wrapper.classList.toggle('translate-y-0');
                btnSt.innerHTML =
                    btnSt.innerHTML === '↑' ? '↓' : '↑';
            });
        });
    </script>

</body>

</html>
