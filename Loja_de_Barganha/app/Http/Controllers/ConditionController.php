<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Models\Item;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    // READ: Lista todas as fichas técnicas para o Admin auditar o estoque
    public function index()
    {
        $conditions = Condition::with('item')->paginate(15);
        return view('conditions.index', compact('conditions'));
    }

    // UPDATE: O único método que realmente importa aqui (ajustar o estado do item)
    public function update(Request $request, Condition $condition)
    {
        $request->validate([
            'estado_conservacao' => 'required',
            'observacoes_tecnicas' => 'nullable'
        ]);

        $condition->update($request->all());
        return redirect()->back()->with('success', 'Ficha técnica atualizada!');
    }

    // SHOW: Ver detalhes técnicos específicos
    public function show(Condition $condition)
    {
        return view('conditions.show', compact('condition'));
    }
    
    // OBS: Store e Destroy ficam omitidos pois o ItemController já faz isso 
    // através da relação direta 1:1, garantindo a integridade dos dados.
}