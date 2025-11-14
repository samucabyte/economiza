@extends('layout.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Minhas Transações</h1>
    {{-- Formulário de Nova Despesa --}}

    <x-formAdd :categories="$categories" />

    {{-- Resumo --}}
    {{-- FILTRO POR MÊS + ANO --}}
    <div class="mb-6 flex items-center gap-4 bg-white p-4 shadow rounded-lg w-full">
        <form method="GET" action="{{ route('transactions.index') }}"
            class="flex flex-wrap md:flex-nowrap items-center gap-3 w-full">

            {{-- FILTRO MÊS --}}
            <select name="month" class="p-2 border rounded-lg bg-gray-100 text-gray-700 focus:ring-2 focus:ring-sky-500">
                <option value="">Todos os meses</option>

                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            {{-- FILTRO ANO --}}
            <select name="year" class="p-2 border rounded-lg bg-gray-100 text-gray-700 focus:ring-2 focus:ring-sky-500">
                <option value="">Todos os anos</option>

                @foreach ($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition">
                Filtrar
            </button>

        </form>
    </div>


    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-green-100 p-4 rounded-lg text-center">
            <p class="text-sm text-green-700">Receitas</p>
            <p class="text-xl font-bold text-green-800">
                R$ {{ number_format($revenuesTotal, 2, ',', '.') }}
            </p>
        </div>
        <div class="bg-red-100 p-4 rounded-lg text-center">
            <p class="text-sm text-red-700">Despesas</p>
            <p class="text-xl font-bold text-red-800">
                R$ {{ number_format($expensesTotal, 2, ',', '.') }}
            </p>
        </div>
        <div class="bg-blue-100 p-4 rounded-lg text-center">
            <p class="text-sm text-blue-700">Saldo</p>
            <p class="text-xl font-bold text-blue-800">
                R$ {{ number_format($revenuesTotal - $expensesTotal, 2, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Lista de transações --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left min-w-[600px]"> {{-- min-w garante largura mínima --}}
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">📅 Data</th>

                        <th class="px-6 py-3">📂 Categoria</th>
                        <th class="px-6 py-3">💰 Tipo</th>
                        <th class="px-6 py-3 text-right">R$ Valor</th>
                        <th class="px-6 py-3">📝 Descrição</th>
                        <th class="px-6 py-3 text-right">⚙️ Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">
                                {{ $transaction->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-3 text-center">
                                {{ $transaction->category->name ?? '---' }}
                            </td>
                            <td class="px-6 py-3">
                                @if ($transaction->type === 'revenue')
                                    <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-200 rounded">
                                        Receita
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-200 rounded">
                                        Despesa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right font-semibold">
                                @if ($transaction->type === 'revenue')
                                    <span class="text-green-600">
                                        + R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-red-600">
                                        - R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3">{{ $transaction->description ?? '-' }}</td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex flex-col md:flex-row gap-2 justify-end items-center">
                                    <form action="{{ route('transactions.edit', $transaction->id) }}" method="GET">
                                        <button type="submit" class="text-blue-600 hover:underline text-sm md:text-base">
                                            Editar
                                        </button>
                                    </form>
                                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta transação?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm md:text-base">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                Nenhuma transação encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    {{-- Gráfico MENSAL --}}
    <div class="bg-white p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-xl font-bold mb-4">Evolução Mensal</h2>
        <canvas id="monthlyChart"></canvas>
    </div>

    {{-- Gráfico ANUAL --}}
    <div class="bg-white p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-xl font-bold mb-4">Evolução Anual</h2>
        <canvas id="yearlyChart"></canvas>
    </div>



    {{-- Paginação --}}
    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('scripts')
    <script>
        // === MENSAL ===
        const monthlyCtx = document.getElementById('monthlyChart');

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: @json($chartMonths),
                datasets: [{
                        label: 'Receitas',
                        data: @json($chartRevenues),
                        borderColor: 'rgb(34,197,94)',
                        backgroundColor: 'rgba(34,197,94,0.3)',
                        borderWidth: 2
                    },
                    {
                        label: 'Despesas',
                        data: @json($chartExpenses),
                        borderColor: 'rgb(239,68,68)',
                        backgroundColor: 'rgba(239,68,68,0.3)',
                        borderWidth: 2
                    },
                    {
                        label: 'Saldo',
                        data: @json($chartBalance),
                        borderColor: 'rgb(59,130,246)',
                        backgroundColor: 'rgba(59,130,246,0.3)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true
            }
        });

        // === ANUAL ===
        const yearlyCtx = document.getElementById('yearlyChart');

        new Chart(yearlyCtx, {
            type: 'bar',
            data: {
                labels: @json($chartYears),
                datasets: [{
                        label: 'Receitas',
                        data: @json($chartYearRevenue),
                        backgroundColor: 'rgba(34,197,94,0.7)'
                    },
                    {
                        label: 'Despesas',
                        data: @json($chartYearExpense),
                        backgroundColor: 'rgba(239,68,68,0.7)'
                    },
                    {
                        label: 'Saldo',
                        data: @json($chartYearBalance),
                        backgroundColor: 'rgba(59,130,246,0.7)'
                    }
                ]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
