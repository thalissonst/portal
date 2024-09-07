const apiUrl = 'http://127.0.0.1:8000';

export class UsuarioService 
{
    // Solicitação para buscar Usuários.
    async getUsers() 
    {
        return fetch(`${apiUrl}/users`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Solicitação para buscar um Usuário.
    async getUser(ID) 
    {
        return fetch(`${apiUrl}/users/${ID}`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json.lista[0]) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Cadastrar um novo Usuário.
    async postUser(DADOS) 
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


    // Editar um Usuário.
    async putUser(DADOS) 
    {
        return fetch(`${apiUrl}/users/${DADOS.id}`, { 
        method: 'PUT',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Excluir um Usuário.
    async deleteUser(ID) 
    {
        return fetch(`${apiUrl}/users/${ID}`, { 
        method: 'DELETE',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }
    
}
