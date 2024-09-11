<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Cliente;

class ClienteController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //Ajusta a query para o resultado
            $response = Cliente::query()
            ->join('cidades', 'clientes.cliente_cidade_id', '=', 'cidades.id')
            ->join('estados', 'cidades.cidade_estado_id', '=', 'estados.id')
            ->select('clientes.*', 'cidades.cidade_nome as cliente_cidade_nome', 'estados.estado_nome as cliente_estado_nome')
            ->get();

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
            $request->validate([
                'cliente_nome'          => 'required|string|max:255', 
                'cliente_cpf'           => 'required|string|min:9', 
                'cliente_nascimento'    => 'required|string', 
            ]);

            // Cria uma instância de Carbon com a data de nascimento
            $dateBirth = Carbon::parse($request->cliente_nascimento);
            
            //Realiza o cadastro do usuário
            $response = Cliente::create([
                'cliente_nome'          => $request->cliente_nome,
                'cliente_cpf'           => $request->cliente_cpf,
                'cliente_nascimento'    => $request->cliente_nascimento,
                'cliente_idade'         => $dateBirth->age,
                'cliente_telefone'      => $request->cliente_telefone,
                'cliente_cidade_id'     => $request->cliente_cidade_id['value'],
                'cliente_estado_id'     => $request->cliente_estado_id['value'],
                'cliente_foto'          => str_replace(' ', '', $request->cliente_nome) . '.png'
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
            return response()->json(['response' => Cliente::findOrFail($id)], 200); //Retorna um json da operação
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
            $response = Cliente::findOrFail($id); 
            
            // Cria uma instância de Carbon com a data de nascimento
            $dateBirth = Carbon::parse($request->cliente_nascimento);

            //Realiza a atualização do usuário retornado na busca
            $response->update([ 
                'cliente_nome'          => $request->cliente_nome,
                'cliente_cpf'           => $request->cliente_cpf,
                'cliente_nascimento'    => $request->cliente_nascimento,
                'cliente_idade'         => $dateBirth->age,
                'cliente_telefone'      => $request->cliente_telefone,
                'cliente_cidade_id'     => $request->cliente_cidade_id['value'],
                'cliente_estado_id'     => $request->cliente_estado_id['value']
            ]);

            //Retorna um json da atualização e mensagem de retorno
            return response()->json(['message' => 'O cliente foi atualizado com sucesso.', 'response' => $response], 200); 
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
            return response()->json(['message' => 'O cliente foi excluido com sucesso.', 'response' => Cliente::destroy($id)], 200); //Retorna um json da operação e mensagem de retorno
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }
}
