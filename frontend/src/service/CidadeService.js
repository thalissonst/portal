const apiUrl = 'http://127.0.0.1:8000';

export class CidadeService 
{
    // Solicitação para buscar.
    async getCities() 
    {
        return fetch(`${apiUrl}/cities`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Solicitação para buscar um.
    async getCity(ID) 
    {
        return fetch(`${apiUrl}/cities/${ID}`, {
        method: 'GET',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json.lista[0]) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Cadastrar um novo.
    async postCity(DADOS) 
    {
        return fetch(`${apiUrl}/cities`, { 
        method: 'POST',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }


    // Editar um.
    async putCity(DADOS) 
    {
        return fetch(`${apiUrl}/cities/${DADOS.id}`, { 
        method: 'PUT',
        body: JSON.stringify(DADOS),
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }

    // Excluir um.
    async deleteCity(ID) 
    {
        return fetch(`${apiUrl}/cities/${ID}`, { 
        method: 'DELETE',
        headers: {'Content-type': 'application/json;charset=UTF-8'} 
        }) 
        .then((response) => response.json()) // converter para json
        .then((json) => json) // imprimir dados no console
        .catch(error => console.log('Erro na requisição: ', error)); // lidar com os erros por catch
    }
    
}

