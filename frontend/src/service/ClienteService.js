const apiUrl = 'http://127.0.0.1:8000';

export class ClienteService 
{
    // Solicitação para buscar Usuários.
    async getCustomers() 
    {
        return fetch(`${apiUrl}/customers`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Solicitação para buscar um Usuário.
    async getCustomer(ID) 
    {
        return fetch(`${apiUrl}/customers/${ID}`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json.lista[0]) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Cadastrar um novo Usuário.
    async postCustomer(DADOS) 
    {
        return fetch(`${apiUrl}/customers`, { 
        method: 'POST',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }


    // Editar um Usuário.
    async putCustomer(DADOS) 
    {
        return fetch(`${apiUrl}/customers/${DADOS.id}`, { 
        method: 'PUT',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Excluir um Usuário.
    async deleteCustomer(ID) 
    {
        return fetch(`${apiUrl}/customers/${ID}`, { 
        method: 'DELETE',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }
    

    // Solicitação para buscar os Estados.
    async getStates() 
    {
        return fetch(`${apiUrl}/states`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Solicitação para buscar as cidades de um estado.
    async getCitiesState(ID_STATE) 
    {
        return fetch(`${apiUrl}/cities/states/${ID_STATE}`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }
}
