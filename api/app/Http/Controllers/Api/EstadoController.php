<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Estado;

class EstadoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(['response' => Estado::all()], 200); //Retorna um json da operação e mensagem de retorno
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //Faz a validação dos campos
            $request->validate(['nome' => 'required|string|max:255']);

            //Realiza o cadastro do usuário
            $response = Estado::create([
                'estado_nome' => $request->nome
            ]);

            //Retorna um json do cadastro e mensagem de retorno
            return response()->json(['message' => 'O cadastro foi realizado com sucesso.', 'response' => $response], 201); 
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json(['response' => Estado::findOrFail($id)], 200); //Retorna um json da operação
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //Realiza a busca do usuário
            $response = Estado::findOrFail($id); 
            
            //Realiza a atualização do usuário retornado na busca
            $response->update([ 
                'estado_nome'   => $request->nome,
            ]);

            //Retorna um json da atualização e mensagem de retorno
            return response()->json(['message' => 'O estado foi atualizado com sucesso.', 'response' => $response], 200); 
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            return response()->json(['message' => 'O estado foi excluido com sucesso.', 'response' => Estado::destroy($id)], 200); //Retorna um json da operação e mensagem de retorno
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }
    
}
