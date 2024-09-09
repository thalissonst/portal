<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import { EstadoService } from '@/service/EstadoService';
import { useToast } from 'primevue/usetoast';

const estadoService = new EstadoService();

const toast = useToast();

const states = ref(null);
const state = ref({});
const stateDialog = ref(false);
const deleteDialog = ref(false);
const dt = ref(null);
const filters = ref({});
const submitted = ref(false);

onBeforeMount(() => {
    initFilters();
});
onMounted(() => {
    tableData();
});

// Faz a busca dos dados da tabela
const tableData = () => {
    estadoService.getStates().then((data) => (states.value = data.response));
};

// Faz a parametrização dos filtros da tabela
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};

// Exibe modal para cadastrar novo estado
const openNew = () => {
    state.value = {}; 
    submitted.value = false; 
    stateDialog.value = true;
};


// Salva os dados do estado
const saveState = () => {
    submitted.value = true;

    if (state.value.estado_nome && state.value.estado_nome.trim()) 
    {
        if (state.value.id) 
        {
            estadoService.putState({nome: state.value.estado_nome}).then(response => {
                if (response.message) { 
                    toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
                } else { 
                    toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
                } 
            });
        } 
        else 
        {
            estadoService.postState({nome: state.value.estado_nome}).then(response => {
                if (response.message) { 
                    toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
                } else { 
                    toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
                } 
            });
            
        }

        stateDialog.value = false;
        state.value = {};
        tableData();
    }
};

// Exibe modal de editar estado
const editState = (editState) => {
    state.value = { ...editState };
    stateDialog.value = true;

    let result = [];
    estadoService.getStates().then((data) => ( 
        data.response.forEach(function(r) { result.push({value: r.id, name: r.estado_nome}) }),
        states.value = result
    ));
};

// Exbe modal de confirmação
const confirmDelete = (editProduct) => {
    state.value = editProduct;
    deleteDialog.value = true;
};

// Faz a exclusão
const deleteState = (ID) => {
    estadoService.deleteState(ID).then(response => {
        if (response.message)  { 
            toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
        } else { 
            toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
        } 
    });

    deleteDialog.value = false; 
    tableData();
};

//Fecha o modal de estado
const hideDialog = () => {
    stateDialog.value = false;
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
                        <Button label="Novo Estado" icon="pi pi-plus" class="mr-2" severity="success" @click="openNew" />
                    </template>
                </Toolbar>

                <DataTable
                    ref="dt"
                    :value="states"
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
                            <h5 class="m-0">Estados</h5>
                            <IconField iconPosition="left" class="block mt-2 md:mt-0">
                                <InputIcon class="pi pi-search" />
                                <InputText class="w-full sm:w-auto" v-model="filters['global'].value" placeholder="Procurar..." />
                            </IconField>
                        </div>
                    </template>

                    <Column field="nome" header="Nome" :sortable="true" headerStyle="min-width:20rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nome</span>
                            {{ slotProps.data.estado_nome }}
                        </template>
                    </Column>
                    <Column headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded @click="editState(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded @click="confirmDelete(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>

                <Dialog v-model:visible="stateDialog" :style="{ width: '450px' }" header="Estado" :modal="true" class="p-fluid">
                    <div class="field">
                        <label for="estado">Nome *</label>
                        <InputText id="estado" v-model.trim="state.estado_nome" required="true" autofocus :invalid="submitted && !state.estado_nome" />
                    </div>
                    <template #footer>
                        <Button label="Cancelar" icon="pi pi-times" text="" @click="hideDialog" />
                        <Button label="Salvar" icon="pi pi-check" text="" @click="saveState" />
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteDialog" :style="{ width: '450px' }" header="Confirmar" :modal="true">
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="state"
                            >Confirma a exclusão do Estado <b>{{ state.estado_nome }}</b
                            >?</span
                        >
                    </div>
                    <template #footer>
                        <Button label="Não" icon="pi pi-times" text @click="deleteDialog = false" />
                        <Button label="Sim" icon="pi pi-check" text @click="deleteState(state.id)" />
                    </template>
                </Dialog>

            </div>
        </div>
    </div>
</template>
