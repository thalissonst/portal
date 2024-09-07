<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import { UsuarioService } from '@/service/UsuarioService';
import { useToast } from 'primevue/usetoast';

const usuarioService = new UsuarioService();

const toast = useToast();

const user = ref({});
const users = ref(null);
const userDialog = ref(false);
const deleteUserDialog = ref(false);
const dt = ref(null);
const filters = ref({});
const submitted = ref(false);

onBeforeMount(() => {
    initFilters();
});
onMounted(() => {
    tableData();
});

// Faz a parametrização dos filtros da tabela
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};

// Faz a busca dos dados da tabela
const tableData = () => {
    usuarioService.getUsers().then((data) => (users.value = data.response));
};

// Exibe o Modal para atualização dos dados
const editUser = (editUser) => {
    user.value = { ...editUser };
    userDialog.value = true;
};

// Realiza a atualização dos dados
const saveUser = () => {
    submitted.value = true;
    
    if (user.value.id) 
    {
        usuarioService.putUser(user.value).then(response => {
            if (response.message) { 
                toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
            } else { 
                toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
            } 
        });
    } 
    
    userDialog.value = false;
    user.value = {}; 
    tableData();
};

// Exibe o Modal de confirmação
const confirmDelete = (editUser) => {
    user.value = editUser;
    deleteUserDialog.value = true;
};

// Realiza a exclusão 
const deleteUser = (ID) => {
    usuarioService.deleteUser(ID).then(response => {
        if (response.message)  { 
            toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
        } else { 
            toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
        } 
    });

    deleteUserDialog.value = false; 
    tableData();
};

//Fecha o modal de Usuário
const hideDialog = () => {
    userDialog.value = false;
    submitted.value = false;
};

</script>

<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <Toolbar class="mb-4">
                    <template v-slot:start>
                        <div class="my-2">
                            <Button label="Voltar" icon="pi pi-chevron-left" class="mr-2" severity="secondary" @click="this.$router.push({path:`/`});" />
                        </div>
                    </template>
                    <template v-slot:end>
                    
                    </template>
                </Toolbar>

                <DataTable
                    ref="dt"
                    :value="users"
                    dataKey="id"
                    :paginator="true"
                    :rows="10"
                    :filters="filters"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} resultados"
                >
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Usuários</h5>
                            <IconField iconPosition="left" class="block mt-2 md:mt-0">
                                <InputIcon class="pi pi-search" />
                                <InputText class="w-full sm:w-auto" v-model="filters['global'].value" placeholder="Procurar..." />
                            </IconField>
                        </div>
                    </template>

                    <Column field="nome" header="Nome" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Nome Completo</span>
                            {{ slotProps.data.usuario_nome }}
                        </template>
                    </Column>
                    <Column field="email" header="Email" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">E-mail</span>
                            {{ slotProps.data.usuario_email }}
                        </template>
                    </Column>
                
                    <Column>
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded @click="editUser(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded @click="confirmDelete(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>

                <Dialog v-model:visible="userDialog" :style="{ width: '450px' }" header="Usuário" :modal="true" class="p-fluid">
                    <div class="field">
                        <label for="nome">Nome</label>
                        <InputText id="nome" v-model.trim="user.usuario_nome" required="true" autofocus :invalid="submitted && !user.usuario_nome" />
                    </div>
                    
                    <div class="field">
                        <label for="email">E-mail</label>
                        <InputText id="email" v-model.trim="user.usuario_email" required="true" autofocus :invalid="submitted && !user.usuario_email" />
                    </div>

                    <template #footer>
                        <Button label="Cancelar" icon="pi pi-times" text="" @click="hideDialog" />
                        <Button label="Salvar" icon="pi pi-check" text="" @click="saveUser" />
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteUserDialog" :style="{ width: '450px' }" header="Confirmar" :modal="true">
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="user"
                            >Confirma a exclusão do usuário <b>{{ user.usuario_nome }}</b
                            >?</span
                        >
                    </div>
                    <template #footer>
                        <Button label="Cancelar" icon="pi pi-times" text @click="deleteUserDialog = false" />
                        <Button label="Salvar" icon="pi pi-check" text @click="deleteUser(user.id)" />
                    </template>
                </Dialog>

            </div>
        </div>
    </div>
</template>
