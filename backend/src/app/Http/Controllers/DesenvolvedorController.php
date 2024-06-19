<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Desenvolvedor;

use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class DesenvolvedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desenvolvedores =  Desenvolvedor::with('nivel')->get();
        // $desenvolvedores =  Desenvolvedor::all();

        if ($desenvolvedores->isEmpty()) {
            return response()->json(['message' => 'Nenhum desenvolvedor encontrado.'], 404);
        }

        return response()->json($desenvolvedores, 200);

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
            $result = json_decode($request->getContent(), true);
        
            $validator = Validator::make($result, [
                'nivel_id' => 'required|exists:niveis,id',
                'nome' => 'required|string|max:255',
                'sexo' => 'required|in:M,F',
                'data_nascimento' => 'required|date',
                'hobby' => 'nullable|string|max:255',
            ]);
        
            if ($validator->fails()) {
                return response()->json(["message" => "Não foi possivel salvar o Desenvolvedor",'errors' => $validator->errors()], 400);
            }
        
            $idade = Carbon::parse($result['data_nascimento'])->age;
        
            $desenvolvedor = Desenvolvedor::create(
                array_merge(
                    $result,
                    ['idade' => $idade]
                )
            );
        
            return response()->json($desenvolvedor, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao validar dados.'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Desenvolvedor::with('nivel')->find($id);
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
        $desenvolvedor = Desenvolvedor::findOrFail($id);
        $desenvolvedor->update($request->all());
        return response()->json($desenvolvedor, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Desenvolvedor::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
