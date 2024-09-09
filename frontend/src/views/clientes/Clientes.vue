<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import { ClienteService } from '@/service/ClienteService';
import { useToast } from 'primevue/usetoast';

const clienteService = new ClienteService();

const toast = useToast();

const customers = ref(null);
const customer = ref({});
const states = ref([]);
const cities = ref([]);
const customerDialog = ref(false);
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
    clienteService.getCustomers().then((data) => (customers.value = data.response));
};

// Faz a parametrização dos filtros da tabela
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};

// Exibe modal para cadastrar novo Cliente
const openNew = () => {
    customer.value = {}; 
    submitted.value = false; 
    customerDialog.value = true;

    let result = [];
    clienteService.getStates().then((data) => ( 
        data.response.forEach(function(r) { result.push({value: r.id, name: r.estado_nome}) }),
        states.value = result
    ));
};

// Busca as Cidades de acordo com o Estado selecionado
const handleSelectChange = () => {
    let result = [];
    const selectedValue = customer.value.cliente_estado_id.value;

    clienteService.getCitiesState(selectedValue).then((data) => (
        data.response.forEach(function(r) { result.push({value: r.id, name: r.cidade_nome}) }),
        cities.value = result
    ));
}

// Salva os dados do Cliente
const saveCustomer = () => {
    submitted.value = true;

    if (customer.value.cliente_nome && customer.value.cliente_nome.trim() && customer.value.cliente_cpf && customer.value.cliente_nascimento) 
    {
        if (customer.value.id) 
        {
            clienteService.putCustomer(customer.value).then(response => {
                if (response.message) { 
                    toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
                } else { 
                    toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
                } 
                tableData();
            });
        } 
        else 
        {
            clienteService.postCustomer(customer.value).then(response => {
                if (response.message) { 
                    toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
                } else { 
                    toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
                } 
                tableData();
            });
            
        }

        customerDialog.value = false;
        customer.value = {};
    }
};

// Exibe modal de editar Cliente
const editCustomer = (editCustomer) => {
    customer.value = { ...editCustomer };
    customerDialog.value = true;

    let result = [];
    clienteService.getStates().then((data) => ( 
        data.response.forEach(function(r) { result.push({value: r.id, name: r.estado_nome}) }),
        states.value = result
    ));
};

// Exbe modal de confirmação
const confirmDelete = (editProduct) => {
    customer.value = editProduct;
    deleteDialog.value = true;
};

// Faz a exclusão
const deleteCustomer = (ID) => {
    clienteService.deleteCustomer(ID).then(response => {
        if (response.message)  { 
            toast.add({ severity: 'success', summary: 'Sucesso!', detail: response.message, life: 3000 }) 
        } else { 
            toast.add({ severity: 'error', summary: 'Erro!', detail: response.error, life: 5000 }) 
        } 
    });

    deleteDialog.value = false; 
    tableData();
};

//Fecha o modal de Cliente
const hideDialog = () => {
    customerDialog.value = false;
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
                        <Button label="Novo Cliente" icon="pi pi-plus" class="mr-2" severity="success" @click="openNew" />
                    </template>
                </Toolbar>

                <DataTable
                    ref="dt"
                    :value="customers"
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
                            <h5 class="m-0">Cadastro de Clientes</h5>
                            <IconField iconPosition="left" class="block mt-2 md:mt-0">
                                <InputIcon class="pi pi-search" />
                                <InputText class="w-full sm:w-auto" v-model="filters['global'].value" placeholder="Procurar..." />
                            </IconField>
                        </div>
                    </template>

                    <Column field="nome" header="Nome" :sortable="true" headerStyle="min-width:20rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nome</span>
                            {{ slotProps.data.cliente_nome }}
                        </template>
                    </Column>
                    <Column header="Foto" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Foto</span>
                            <!-- <img :src="'/demo/images/product/' + slotProps.data.cliente_foto" :alt="slotProps.data.cliente_foto" class="shadow-2" width="100" /> -->
                        </template>
                    </Column>
                    <Column field="cpf" header="C.P.F" :sortable="true" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">C.P.F</span>
                            {{ slotProps.data.cliente_cpf }}
                        </template>
                    </Column>
                    <Column field="nascimento" header="Nascimento" :sortable="true" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nascimento</span>
                            {{ slotProps.data.cliente_nascimento }}
                        </template>
                    </Column>
                    <Column field="idade" header="Idade" :sortable="true" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Idade</span>
                            {{ slotProps.data.cliente_idade }} Anos
                        </template>
                    </Column>
                    <Column field="telefone" header="Telefone" :sortable="true" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Telefone</span>
                            {{ slotProps.data.cliente_telefone }}
                        </template>
                    </Column>
                    <Column field="cidade" header="Cidade" :sortable="true" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Cidade</span>
                            {{ slotProps.data.cliente_cidade_nome }}
                        </template>
                    </Column>
                    <Column field="estado" header="Estado" :sortable="true" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Estado</span>
                            {{ slotProps.data.cliente_estado_nome }}
                        </template>
                    </Column>
                    <Column headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded @click="editCustomer(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded @click="confirmDelete(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>

                <Dialog v-model:visible="customerDialog" :style="{ width: '450px' }" header="Cliente" :modal="true" class="p-fluid">
                    <img :src="'/demo/images/product/' + customer.cliente_image" :alt="customer.cliente_image" v-if="customer.cliente_image" width="150" class="mt-0 mx-auto mb-5 block shadow-2" />
                    <div class="field">
                        <label for="nome">Nome *</label>
                        <InputText id="nome" v-model.trim="customer.cliente_nome" required="true" autofocus :invalid="submitted && !customer.cliente_nome" />
                    </div>
                    <div class="field">
                        <label for="cpf">C.P.F *</label>
                        <InputText id="cpf" v-model.trim="customer.cliente_cpf" v-mask="'###.###.###-##'" required="true" autofocus :invalid="submitted && !customer.cliente_cpf" />
                    </div>
                    <div class="field">
                        <label for="nascimento">Data Nascimento *</label>
                        <InputText type="date" id="nascimento" v-model.trim="customer.cliente_nascimento" required="true" autofocus :invalid="submitted && !customer.cliente_nascimento" />
                    </div>
                    <div class="field">
                        <label for="telefone">Telefone</label>
                        <InputText id="telefone" v-model.trim="customer.cliente_telefone" v-mask="'(##) #####-####'" required="true" autofocus :invalid="submitted && !customer.cliente_telefone" />
                    </div>
                    
                    <div class="field">
                        <label for="estado">Estado</label>
                        <Dropdown id="estado" v-model.trim="customer.cliente_estado_id" :options="states" optionLabel="name" placeholder="Selecione o Estado" @change="handleSelectChange"></Dropdown>
                    </div>

                    <div class="field">
                        <label for="cidade">Cidade</label>
                        <Dropdown id="cidade" v-model.trim="customer.cliente_cidade_id" :options="cities" optionLabel="name" placeholder="Selecione a Cidade"></Dropdown>
                    </div>

                    <template #footer>
                        <Button label="Cancelar" icon="pi pi-times" text="" @click="hideDialog" />
                        <Button label="Salvar" icon="pi pi-check" text="" @click="saveCustomer" />
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteDialog" :style="{ width: '450px' }" header="Confirmar" :modal="true">
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="customer"
                            >Confirma a exclusão do usuário <b>{{ customer.cliente_nome }}</b
                            >?</span
                        >
                    </div>
                    <template #footer>
                        <Button label="Não" icon="pi pi-times" text @click="deleteDialog = false" />
                        <Button label="Sim" icon="pi pi-check" text @click="deleteCustomer(customer.id)" />
                    </template>
                </Dialog>

            </div>
        </div>
    </div>
</template>
