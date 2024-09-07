<script setup>
import AppConfig from '@/layout/AppConfig.vue';
import { AuthService } from '@/service/AuthService';

const authService = new AuthService();

//Realiza o Login no Portal.
const acessar = () => {

    const email = document.getElementById("email").value;
    const senha = document.getElementById("password").value;

    if (email == '' || senha == '') {
        window.alert('Preencha todos os campos corretamente.');
    } 
    else {
        $.blockUI({ message: '<h4>Carregando...</h4>' });

        authService.login({email: email, senha: senha}).then(response => {

            if (response.status == false) {
                window.alert(response.message); console.log(response);
            } else {     
                sessionStorage.setItem('loggedIn', true),
                sessionStorage.setItem('nome', response.user.usuario_nome),
                sessionStorage.setItem('email', email),
                sessionStorage.setItem('senha', senha)

                location.href = '/'; 
            } 

            $.unblockUI();
        }); 
    }
};


//Realiza o Login no portal via Protheus.
// const login = () => {

//     $.blockUI({ message: '<h4>Carregando...</h4>' });
    
//     const usuario = document.getElementById("username").value;;
//     const senha = document.getElementById("password").value;
  
//     if (usuario == '' || senha == '') {
//         $.unblockUI(); window.alert('Por favor, preencha todos os campos corretamente.');
//     } 
//     else {
//         var DADOS = {grant_type: 'password', username: usuario, password: senha};

//         apiProtheusService.getToken(DADOS).then(response => {

//             if (response.code == 401) {
//                 window.alert(response.message); console.log(response); $.unblockUI();
//             } else {     
//                 localStorage.setItem('userObject', JSON.stringify({username: usuario, password: senha})),
//                 localStorage.setItem('loggedIn', true),
//                 localStorage.setItem('token', response.access_token),
//                 localStorage.setItem('token_type', response.token_type),
//                 localStorage.setItem('expires_in', response.expires_in),
//                 localStorage.setItem('refresh_token', response.refresh_token),
//                 localStorage.setItem('authorization', `Bearer ${response.access_token}`)

//                 location.href = '/'; console.log(localStorage); $.unblockUI();
//             } 
//         }); 
//     }
// };

</script>

<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="/logoPortal.png" alt="Image" height="100" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3"></div>
                        <span class="text-600 font-medium">Digite seus dados para acessar</span>
                    </div>
                    <div>
                        <label for="email" class="block text-900 text-xl font-medium mb-2">E-mail</label>
                        <InputText id="email" type="text" class="w-full md:w-30rem mb-5" style="padding: 1rem" />

                        <label for="password" class="block text-900 font-medium text-xl mb-2">Senha</label>
                        <InputText id="password" type="password" class="w-full md:w-30rem mb-5" style="padding: 1rem" />

                        <div class="flex align-items-center justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center"></div>
                            <a href="/register" class="font-medium no-underline ml-2 text-right" style="color: var(--primary-color)">Cadastre-se</a>
                        </div>
                        <Button label="Acessar" class="w-full p-3 text-xl" @click="acessar()"></Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
</style>
