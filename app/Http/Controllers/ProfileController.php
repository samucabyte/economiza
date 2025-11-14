<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\Spent;
use App\Models\User;
use App\Models\Wage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class ProfileController extends Controller
{
    private $user_id;
    public function __construct()
    {
        //Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login'); // Redireciona para login se não estiver autenticado
        }
        // Pega o ID do usuário autenticado
        $this->user_id =  Auth::user()->id;
        setlocale(LC_TIME, 'pt_BR.UTF-8', 'Portuguese_Brazil.1252');
    }
    public function index()
    {
        $user = User::find($this->user_id);
        $categories = ExpenseCategory::where('user_id', $this->user_id)->get();
        
    
        return view('profile', compact('user', 'categories'));
    }
public function profileAction(Request $request)
{
    $user = Auth::user();
    // 🔹 Atualiza nome
    $user->update([
        'name' => $request->name
    ]);

    // 🔹 CATEGORIAS
    $categoriesInput = $request->categories ?? [];

    // Busca categorias já existentes
    $existingCategories = ExpenseCategory::where('user_id', $this->user_id)->get();

    // 1️⃣ Atualiza ou cria
    foreach ($categoriesInput as $inputName) {

        if (empty($inputName)) continue;

        // Verifica se já existe essa categoria
        $category = ExpenseCategory::where('name', $inputName)
            ->where('user_id', $this->user_id)
            ->first();

        if (!$category) {
            // Criar nova
            ExpenseCategory::create([
                'name' => $inputName,
                'user_id' => $this->user_id
            ]);
        }
    }

    // 2️⃣ Exclui categorias removidas do formulário
    foreach ($existingCategories as $cat) {
        if (!in_array($cat->name, $categoriesInput)) {
            $cat->delete();
        }
    }

    return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
}

    
}
