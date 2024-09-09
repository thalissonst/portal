<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cidade;

class CidadeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $response = Cidade::query()->join('estados', 'cidades.cidade_estado_id', '=', 'estados.id')->select('cidades.id', 'cidades.cidade_nome', 'cidades.cidade_estado_id', 'estados.estado_nome as estado_nome')->get();

            return response()->json(['response' => $response], 200); //Retorna um json da operação e mensagem de retorno
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
            $request->validate(['nome' => 'required|string|max:255', 'estado_id' => 'required|max:10']);

            //Realiza o cadastro do usuário
            $response = Cidade::create([
                'cidade_nome' => $request->nome,
                'cidade_estado_id' => $request->estado_id
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
            $response = Cidade::query()->join('estados', 'cidades.cidade_estado_id', '=', 'estados.id')->where('cidades.id', $id)->select('cidades.*', 'estados.estado_nome as estado_nome')->get();

            return response()->json(['response' => $response], 200); //Retorna um json da operação
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
            $response = Cidade::findOrFail($id); 
            
            //Realiza a atualização do usuário retornado na busca
            $response->update([ 
                'cidade_nome'       => $request->nome,
                'cidade_estado_id'  => $request->estado_id,
            ]);

            //Retorna um json da atualização e mensagem de retorno
            return response()->json(['message' => 'A cidade foi atualizada com sucesso.', 'response' => $response], 200); 
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
            return response()->json(['message' => 'A cidade foi excluida com sucesso.', 'response' => Cidade::destroy($id)], 200); //Retorna um json da operação e mensagem de retorno
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }
    

    /**
     * Busca as cidades de acordo com o estado informado.
     */
    public function citiesStates($estado_id)
    {
        try {
            return response()->json(['response' => Cidade::query()->where('cidades.cidade_estado_id', $estado_id)->get()], 200); //Retorna um json da operação e mensagem de retorno
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }
}
