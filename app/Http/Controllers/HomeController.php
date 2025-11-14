<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Revenue;
use App\Models\Spend;
use App\Models\Spent;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wage;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    private $userId;

    

    public function index(Request $request)
    {

        $userId = Auth::id();
        $month = $request->input('month') ?? Carbon::now()->month;
    $year = $request->input('year') ?? Carbon::now()->year;

    $query = Transaction::with('category')
                ->where('user_id', $userId)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
    
    // Filtro por mês
    if ($month) {
        $query->whereMonth('created_at', $month);
    }

    // Filtro por ano
    if ($year) {
        $query->whereYear('created_at', $year);
    }

    $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

    // Totais
    $revenuesTotal = (clone $query)->where('type', 'revenue')->sum('amount');
    $expensesTotal = (clone $query)->where('type', 'expense')->sum('amount');

    // Categorias
    $categories = ExpenseCategory::where('user_id', $userId)->get();

    // Lista de anos existentes no banco
    $years = Transaction::where('user_id', $userId)
            ->selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
    
    $monthlyData = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(CASE WHEN type = "revenue" THEN amount ELSE 0 END) as revenues'),
            DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expenses')
        )
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $chartMonths = [];
    $chartRevenues = [];
    $chartExpenses = [];
    $chartBalance = [];

    foreach ($monthlyData as $data) {
        $chartMonths[] = Carbon::create()->month($data->month)->translatedFormat('F');

        $chartRevenues[] = $data->revenues;
        $chartExpenses[] = $data->expenses;

        $chartBalance[] = $data->revenues - $data->expenses;
    }

    // === GRÁFICO ANUAL ===
    $yearlyData = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(CASE WHEN type = "revenue" THEN amount ELSE 0 END) as revenues'),
            DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expenses')
        )
        ->groupBy('year')
        ->orderBy('year')
        ->get();

    $chartYears = [];
    $chartYearRevenue = [];
    $chartYearExpense = [];
    $chartYearBalance = [];

    foreach ($yearlyData as $y) {
        $chartYears[] = $y->year;
        $chartYearRevenue[] = $y->revenues;
        $chartYearExpense[] = $y->expenses;
        $chartYearBalance[] = $y->revenues - $y->expenses;
    }

    return view('home', compact(
        'transactions',
        'revenuesTotal',
        'expensesTotal',
        'categories',
        'years',
        'chartMonths',
        'chartRevenues',
        'chartExpenses',
        'chartBalance',
        'chartYears',
        'chartYearRevenue',
        'chartYearExpense',
        'chartYearBalance'
    ));
    
    }

    public function store(Request $request)
    {
     
       
      $validator = Validator::make($request->all(), [
            'type' => 'required|in:revenue,expense',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:expense_categories,id',
            'description' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if($request->input('type') === 'revenue'){
            Revenue::create([
                'amount'=>$request->input('amount'),
                'description'=>$request->input('description'),
                'user_id'=>Auth::id(),
            ]);
        }
        

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'date' => new DateTime($request->input('date')),
            'expense_category_id'=>$request->input('category_id'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('home')->with('success', 'Transaction added successfully!');
    }

    public function edit($id)
    {
        $categories = ExpenseCategory::all();
        $transaction = Transaction::where('id', $id)->first();
        return view('editAccount',compact('transaction','categories'));
    }

    public function editAction(Request $request, $id)
    {
       
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:revenue,expense',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:expense_categories,id',
            'description' => 'nullable|string|max:255',
        ]);
          if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Transaction::where('id', $id)->update([
                'type'        => $request->input('type'),
                'amount'      => $request->input('amount'),
                'expense_category_id' => $request->input('category_id'),
                'description' => $request->input('description'),
            ]);
        return redirect()->route('home');
    }

    public function filter(Request $request)
    {
        
        return redirect()->route('filter');
        
    }

    public function destroy($id_account)
    {
        $transaction = Transaction::where('user_id', Auth::id())->where('id', $id_account)->first();

       if($transaction){
                $transaction->delete();
       }
       return redirect()->route('home');
    }
}
