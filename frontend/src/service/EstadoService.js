const apiUrl = 'http://127.0.0.1:8000';

export class EstadoService 
{
    // Solicitação para buscar.
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

    // Solicitação para buscar um.
    async getState(ID) 
    {
        return fetch(`${apiUrl}/states/${ID}`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json.lista[0]) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Cadastrar um novo.
    async postState(DADOS) 
    {
        return fetch(`${apiUrl}/states`, { 
        method: 'POST',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }


    // Editar um.
    async putState(DADOS) 
    {
        return fetch(`${apiUrl}/states/${DADOS.id}`, { 
        method: 'PUT',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Excluir um.
    async deleteState(ID) 
    {
        return fetch(`${apiUrl}/states/${ID}`, { 
        method: 'DELETE',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }
    
}

