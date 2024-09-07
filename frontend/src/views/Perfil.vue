<script setup>
import { ref, onMounted, onBeforeMount } from 'vue';
import { UsuarioService } from '@/service/UsuarioService';
import { useToast } from 'primevue/usetoast';

const usuarioService = new UsuarioService();

const nome = sessionStorage.getItem("nome");
const email = sessionStorage.getItem("email");

</script>

<template>
    <Toolbar class="mb-4">
        <template v-slot:start>
            <div class="my-2">
                <Button label="Voltar" icon="pi pi-angle-left" class="mr-2 inline-block" severity="secondary" @click="this.$router.push({path:`/`});" />
            </div>
        </template>
    </Toolbar>
    
    <div class="grid">
        <div class="col-12 md:col-12">
            <div class="card p-fluid">
                <h5>Meu Perfil</h5>
                <div class="formgrid grid">
                    <div class="field col">
                        <label for="nome">Nome Completo</label>
                        <InputText id="nome" type="text" v-model="nome" />
                    </div>
                    <div class="field col">
                        <label for="cargo">E-mail</label>
                        <InputText id="cargo" type="text" v-model="email" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>
