<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nivel;

class NivelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $niveis = Nivel::all();

        if ($niveis->isEmpty()) {
            return response()->json(['message' => 'Nenhum nível encontrado.'], 404);
        }

        return response()->json($niveis, 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nivel' => 'required|string|max:255',
            ]);
            $nivel = Nivel::create($request->all());
            return response()->json($nivel, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar nível.'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'nivel' => 'required|string|max:255',
            ]);

            $nivel = Nivel::findOrFail($id);
            $nivel->update($request->all());
            return response()->json($nivel, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Nível não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar nível.'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $nivel = Nivel::findOrFail($id);
            if ($nivel->desenvolvedores()->exists()) {
                return response()->json(['message' => 'Nível tem desenvolvedores associados'], 400);
            }
            $nivel->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao destruir nível.'], 400);
        }
    }
}
