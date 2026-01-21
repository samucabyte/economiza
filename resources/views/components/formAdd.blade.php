<div class="bg-gradient-to-r from-rose-50 to-red-100 shadow-xl rounded-2xl p-8 mb-10">
    <!-- Título -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        ➕ Adicionar Transação
    </h2>
    @if (count($categories) === 0)
        <div class="bg-red-200 text-red-700 p-3 mb-2 rounded-md">
            <ul>
                <li>Vá nas <a class="text-blue-500" href="{{ route('profile') }}">Configurações</a> para adicionar novas
                    categorias</li>
            </ul>
        </div>
    @endif
    <!-- Form -->
    <form action="{{ route('transactions.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-6">
        @csrf

        {{-- Valor --}}
        <div class="col-span-1">
            <label for="amount" class="block text-sm font-semibold text-gray-700">💵 Valor</label>
            <input type="number" step="0.01" name="amount" id="amount" required
                class="mt-2 p-3 block w-full rounded-lg border border-gray-300 bg-gray-50
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" />
        </div>

        {{-- Categoria --}}
        <div class="col-span-1">
            <label for="category_id" class="block text-sm font-semibold text-gray-700">📂 Categoria</label>
            <select name="category_id" id="category_id" required
                class="mt-2 block w-full rounded-lg border p-3 border-gray-300 bg-gray-50
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                <option value="">Selecione...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tipo --}}
        <div class="col-span-1 flex flex-col justify-center gap-3">
            <label class="block text-sm font-semibold text-gray-700">📊 Tipo</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="type" value="revenue" class="text-green-600 focus:ring-green-500">
                    <span class="text-gray-700">Receita</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="type" value="expense" class="text-red-600 focus:ring-red-500">
                    <span class="text-gray-700">Despesa</span>
                </label>
            </div>
        </div>

        {{-- Descrição --}}
        <div class="md:col-span-2">
            <label for="description" class="block text-sm font-semibold text-gray-700">📝 Descrição</label>
            <input type="text" name="description" id="description"
                class="mt-2 block w-full rounded-lg p-3 border border-gray-300 bg-gray-50
                       focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" />
        </div>

        {{-- Botão --}}
        <div class="md:col-span-5 text-right">
            <button type="submit"
                class="px-6 py-3 bg-red-600 text-white rounded-lg shadow-lg hover:bg-red-700
                       focus:ring-2 focus:ring-red-400 transition transform hover:scale-105">
                💾 Adicionar
            </button>
        </div>

    </form>


</div>
