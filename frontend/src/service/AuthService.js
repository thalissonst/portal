//API Responsável pelas requisições na API do Protheus.

const apiUrl = 'http://127.0.0.1:8000';

export class AuthService 
{
    // Realiza o ligin no portal.
    async login(DADOS) 
    {
        return fetch(`${apiUrl}/login`, { 
            method: 'POST',
            body: JSON.stringify(DADOS),
            headers: { 'Content-type': 'application/json;charset=UTF-8'}
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Cadastrar um novo Usuário no portal.
    async register(DADOS) 
    {
        return fetch(`${apiUrl}/users`, { 
        method: 'POST',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }
}
