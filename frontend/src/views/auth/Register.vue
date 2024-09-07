<script setup>
import { ref, computed } from 'vue';
import { useLayout } from '@/layout/composables/layout';
import AppConfig from '@/layout/AppConfig.vue';
import { AuthService } from '@/service/AuthService';

//import VueSession from 'vue-session'

const { layoutConfig } = useLayout();
const authService = new AuthService();

const checked = ref(false);
const username = ref(null);
const password = ref(null);
const token = ref(false);
const authorization = ref(false);

//Realiza o Login no Portal.
const registerUser = () => {

    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("password").value;

    if (nome == '' || email == '' || senha == '') {
        window.alert('Por favor, preencha todos os campos corretamente.');
    } 
    else {
        $.blockUI({ message: '<h4>Carregando...</h4>' });

        authService.register({nome: nome, email: email, senha: senha}).then(response => {
            if (response.message) {
                window.alert(response.message); location.href = '/'; 
            } else {     
                window.alert(response.error); console.log(response);
            } 

            $.unblockUI();
        }); 
    }

};


</script>

<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <!-- <img :src="logoUrl" alt="Minas Verde Logo" class="mb-5 w-6rem flex-shrink-0" /> -->
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="/logoPortal.png" alt="Image" height="100" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3"></div>
                        <span class="text-600 font-medium">Realize seu cadastro para utilizar o sistema</span>
                    </div>
                    <div>
                        <label for="nome" class="block text-900 text-xl font-medium mb-2">Nome Completo</label>
                        <InputText id="nome" type="text" required="true" class="w-full md:w-30rem mb-5" style="padding: 1rem" />

                        <label for="email" class="block text-900 text-xl font-medium mb-2">E-mail</label>
                        <InputText id="email" type="text" required="true" class="w-full md:w-30rem mb-5" style="padding: 1rem" />

                        <label for="password" class="block text-900 font-medium text-xl mb-2">Senha</label>
                        <InputText id="password" type="password" required="true" class="w-full md:w-30rem mb-5" style="padding: 1rem" />

                        <div class="flex align-items-center justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center"></div>
                            <a href="/login" class="font-medium no-underline ml-2 text-right" style="color: var(--primary-color)">Acessar o Sistema</a>
                        </div>
                        <Button label="Cadastrar" class="w-full p-3 text-xl" @click="registerUser()"></Button>
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
