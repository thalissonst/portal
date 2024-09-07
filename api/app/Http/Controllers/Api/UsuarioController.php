<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Usuario;

class UsuarioController extends Controller
{

    /**
     * Método para listar usuários.
     */
    public function index()
    {
        try {
            return response()->json(['response' => Usuario::all()], 200); //Retorna um json da operação e mensagem de retorno
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     *  Método para cadastrar um novo usuário.
     */
    public function store(Request $request)
    {
        try {
            //Faz a validação dos campos
            $request->validate(['nome' => 'required|string|max:255', 'senha' => 'required|string|min:4', 'email' => 'required|string|email|max:255']);

            //Realiza o cadastro do usuário
            $response = Usuario::create([
                'usuario_nome'  => $request->nome,
                'usuario_email' => $request->email,
                'usuario_senha' => Hash::make($request->senha)
            ]);

            //Retorna um json do cadastro e mensagem de retorno
            return response()->json(['message' => 'O cadastro foi realizado com sucesso.', 'response' => $response], 201); 
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Método para mostrar um usuário específico.
     */
    public function show(string $id)
    {
        try {
            return response()->json(['response' => Usuario::findOrFail($id)], 200); //Retorna um json da operação
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Método para atualizar um usuário específico.
     */
    public function update(Request $request, string $id)
    {
        try {
            //Realiza a busca do usuário
            $response = Usuario::findOrFail($id); 
            
            //Realiza a atualização do usuário retornado na busca
            $response->update([ 
                'usuario_nome'  => $request->usuario_nome,
                'usuario_email' => $request->usuario_email
            ]);

            //Retorna um json da atualização e mensagem de retorno
            return response()->json(['message' => 'O usuario foi atualizado com sucesso.', 'response' => $response], 200); 
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Método para excluir um usuário.
     */
    public function destroy(string $id)
    {
        try {
            return response()->json(['message' => 'O usuario foi excluido com sucesso.', 'response' => Usuario::destroy($id)], 200); //Retorna um json da operação e mensagem de retorno
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }


    /**
     * Método para realizar a validação do Login do usuário.
     */
    public function loginUser(Request $request)
    {
        try {
            $user = Usuario::where('usuario_email', $request->email)->first(); //Faz a busca do usuário

            if ($user) //Realiza a verificação
            {
                if ($user && Hash::check($request->senha, $user->usuario_senha)) //Realiza a verificação das senhas criptografadas 
                {
                    return response()->json(['status' => true, 'message' => 'Autenticado com sucesso.', 'user' => $user], 200); //Senha correta, usuário autenticado
                } 
                else {
                    return response()->json(['status' => false, 'message' => 'Senha incorreta informada.'], 401); //Senha incorreta
                }
            } 
            else {
                return response()->json(['status' => false, 'message' => 'Nenhum acesso encontrado com o e-mail informado.'], 401); //Usuário não existe
            }
        } 
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //Retorna o erro em caso de exceção
        }
    }
}
