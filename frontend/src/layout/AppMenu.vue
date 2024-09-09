<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Portal',
        items: [
            { label: 'Início', icon: 'pi pi-fw pi-home', to: '/' },
            { label: 'Clientes', icon: 'pi pi-fw pi-id-card', to: '/clientes' }
        ],
    },
    {
        label: 'Configurações',
        items: [
            { label: 'Usuarios', icon: 'pi pi-fw pi-users', to: '/usuarios' },
            { label: 'Estados', icon: 'pi pi-fw pi-map', to: '/configuracoes/estados' },
            { label: 'Cidades', icon: 'pi pi-fw pi-map-marker', to: '/configuracoes/cidades' }
        ]
    },
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
