<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import { CidadeService } from '@/service/CidadeService';
import { EstadoService } from '@/service/EstadoService';
import { useToast } from 'primevue/usetoast';

const cidadeService = new CidadeService();
const estadoService = new EstadoService();

const toast = useToast();

const cities = ref(null);
const city = ref({});
const states = ref([]);

const cityDialog = ref(false);
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
    cidadeService.getCities().then((data) => (cities.value = data.response));
};

// Faz a busca dos Estados
const returnStates = () => {
    let result = [];
    estadoService.getStates().then((data) => ( 
        data.response.forEach(function(r) { result.push({value: r.id, name: r.estado_nome}) }),
        states.value = result
    ));
};

// Faz a parametrização dos filtros da tabela
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};

// Exibe modal para cadastrar novo cidade
const openNew = () => {
    city.value = {}; 
    submitted.value = false; 
    cityDialog.value = true;
    returnStates();
};


// Salva os dados do cidade
const saveCity = () => {
    submitted.value = true;

    if (city.value.cidade_nome && city.value.cidade_nome.trim()) 
    {
        if (city.value.id) 
        {
            cidadeService.putCity({nome: city.value.cidade_nome, estado_id: city.value.cidade_estado.value}).then(response => {
                if (response.message) { 
                    toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
                } else { 
                    toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
                } 
            });
        } 
        else 
        {
            cidadeService.postCity({nome: city.value.cidade_nome, estado_id: city.value.cidade_estado.value}).then(response => {
                if (response.message) { 
                    toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
                } else { 
                    toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
                } 
            });
        }

        cityDialog.value = false;
        city.value = {};
        tableData();
    }
};

// Exibe modal de editar cidade
const editCity = (editCity) => {
    city.value = { ...editCity };
    cityDialog.value = true;
    returnStates();
};

// Exbe modal de confirmação
const confirmDelete = (editCity) => {
    city.value = editCity;
    deleteDialog.value = true;
};

// Faz a exclusão
const deleteCity = (ID) => {
    cidadeService.deleteCity(ID).then(response => {
        if (response.message)  { 
            toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
        } else { 
            toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
        } 
    });

    deleteDialog.value = false; 
    tableData();
};

//Fecha o modal de cidade
const hideDialog = () => {
    cityDialog.value = false;
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
                        <Button label="Nova Cidade" icon="pi pi-plus" class="mr-2" severity="success" @click="openNew" />
                    </template>
                </Toolbar>

                <DataTable
                    ref="dt"
                    :value="cities"
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
                            <h5 class="m-0">Cidades</h5>
                            <IconField iconPosition="left" class="block mt-2 md:mt-0">
                                <InputIcon class="pi pi-search" />
                                <InputText class="w-full sm:w-auto" v-model="filters['global'].value" placeholder="Procurar..." />
                            </IconField>
                        </div>
                    </template>

                    <Column field="nome" header="Nome" :sortable="true" headerStyle="min-width:20rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nome</span>
                            {{ slotProps.data.cidade_nome }}
                        </template>
                    </Column>
                    <Column field="estado" header="Estado" :sortable="true" headerStyle="min-width:20rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Estado</span>
                            {{ slotProps.data.estado_nome }}
                        </template>
                    </Column>

                    <Column headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded @click="editCity(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded @click="confirmDelete(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>

                <Dialog v-model:visible="cityDialog" :style="{ width: '450px' }" header="Cidade" :modal="true" class="p-fluid">
                    <div class="field">
                        <label for="cidade">Nome: *</label>
                        <InputText id="cidade" v-model.trim="city.cidade_nome" required="true" autofocus :invalid="submitted && !city.cidade_nome" />
                    </div>
                    <div class="field">
                        <label for="estado">Estado: *</label>
                        <Dropdown id="estado" v-model.trim="city.cidade_estado" :options="states" optionLabel="name" placeholder="Selecione o Estado"></Dropdown>
                    </div>
                    <template #footer>
                        <Button label="Cancelar" icon="pi pi-times" text="" @click="hideDialog" />
                        <Button label="Salvar" icon="pi pi-check" text="" @click="saveCity" />
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteDialog" :style="{ width: '450px' }" header="Confirmar" :modal="true">
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="city"
                            >Confirma a exclusão do Estado <b>{{ city.estado_nome }}</b
                            >?</span
                        >
                    </div>
                    <template #footer>
                        <Button label="Não" icon="pi pi-times" text @click="deleteDialog = false" />
                        <Button label="Sim" icon="pi pi-check" text @click="deleteCity(city.id)" />
                    </template>
                </Dialog>

            </div>
        </div>
    </div>
</template>
