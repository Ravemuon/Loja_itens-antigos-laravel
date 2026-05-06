<?php

namespace App\Http\Controllers;

use App\Models\MediaFormat;
use Illuminate\Http\Request;

class MediaFormatController extends Controller
{
    public function index()
    {
        $formatos = MediaFormat::withCount('items')->get();
        return view('media_formats.index', compact('formatos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|unique:media_formats|max:255',
            'sigla' => 'nullable|unique:media_formats|max:10', // novo campo sigla
        ]);

        MediaFormat::create($request->all());
        return redirect()->back()->with('success', 'Formato cadastrado!');
    }

    public function update(Request $request, MediaFormat $mediaFormat)
    {
        $request->validate([
            'nome' => 'required|max:255|unique:media_formats,nome,' . $mediaFormat->id,
            'sigla' => 'nullable|max:10|unique:media_formats,sigla,' . $mediaFormat->id, // novo campo sigla
        ]);

        $mediaFormat->update($request->all());
        return redirect()->back()->with('success', 'Formato atualizado!');
    }

    public function destroy(MediaFormat $mediaFormat)
    {
        // Impede a exclusão se houver itens usando este formato
        if ($mediaFormat->items()->count() > 0) {
            return redirect()->back()->with('error', 'Não é possível excluir: existem itens vinculados a este formato.');
        }

        $mediaFormat->delete();
        return redirect()->back()->with('success', 'Formato removido.');
    }
    
}