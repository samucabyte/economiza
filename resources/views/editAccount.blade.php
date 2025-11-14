@extends('layout.app')

@section('content')
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center px-4">
        <div class="bg-white w-full max-w-2xl p-8 rounded-2xl shadow-2xl relative">

            <!-- Botão de voltar -->
            <div class="absolute top-4 left-4">
                <x-arrow-back :href="route('home')" />
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                ✏️ Editar Transação
            </h2>

            <!-- Formulário -->
            <form method="POST" action="{{ route('editAction', ['id_account' => $transaction->id]) }}" class="space-y-6">
                @csrf

                {{-- Valor --}}
                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700">💵 Valor</label>
                    <input type="number" step="0.01" name="amount" id="amount" required
                        value="{{ $transaction->amount }}"
                        class="mt-2 p-3 block w-full rounded-lg border border-gray-300 bg-gray-50
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                </div>

                {{-- Categoria --}}
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700">📂 Categoria</label>
                    <select name="category_id" id="category_id"
                        class="mt-2 block w-full rounded-lg border p-3 border-gray-300 bg-gray-50
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        required>
                        <option value="">Selecione...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $transaction->expense_category_id ? 'selected' : '' }}>
                                {{ ucfirst($category->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">📊 Tipo</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" {{ $transaction->type === 'revenue' ? 'checked' : '' }} name="type"
                                value="revenue" class="text-green-600 focus:ring-green-500">
                            <span class="text-gray-700">Receita</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" {{ $transaction->type === 'expense' ? 'checked' : '' }} name="type"
                                value="expense" class="text-red-600 focus:ring-red-500">
                            <span class="text-gray-700">Despesa</span>
                        </label>
                    </div>
                </div>

                {{-- Descrição --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700">📝 Descrição</label>
                    <input type="text" name="description" id="description" value="{{ $transaction->description }}"
                        class="mt-2 block w-full rounded-lg p-3 border border-gray-300 bg-gray-50
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                </div>

                {{-- Botão --}}
                <div class="text-right">
                    <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700
                               focus:ring-2 focus:ring-indigo-400 transition transform hover:scale-105">
                        💾 Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
