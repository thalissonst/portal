<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { useLayout } from '@/layout/composables/layout';
import { useRouter } from 'vue-router';

const { layoutConfig, onMenuToggle } = useLayout();

const nome = ref(null);

const outsideClickListener = ref(null);
const topbarMenuActive = ref(false);
const router = useRouter();
const confirmLogoutDialog = ref(false);

onMounted(() => {
    bindOutsideClickListener();

    nome.value = sessionStorage.getItem("nome");
    console.log(localStorage);
});

onBeforeUnmount(() => {
    unbindOutsideClickListener();
});

const logoUrl = computed(() => {
    return `/logoPortal.png`;
});

const onTopBarMenuButton = () => {
    topbarMenuActive.value = !topbarMenuActive.value;
};
const onSettingsClick = () => {
    topbarMenuActive.value = false;
    router.push('/documentation');
};
const topbarMenuClasses = computed(() => {
    return {
        'layout-topbar-menu-mobile-active': topbarMenuActive.value
    };
});

const bindOutsideClickListener = () => {
    if (!outsideClickListener.value) {
        outsideClickListener.value = (event) => {
            if (isOutsideClicked(event)) {
                topbarMenuActive.value = false;
            }
        };
        document.addEventListener('click', outsideClickListener.value);
    }
};
const unbindOutsideClickListener = () => {
    if (outsideClickListener.value) {
        document.removeEventListener('click', outsideClickListener);
        outsideClickListener.value = null;
    }
};
const isOutsideClicked = (event) => {
    if (!topbarMenuActive.value) return;

    const sidebarEl = document.querySelector('.layout-topbar-menu');
    const topbarEl = document.querySelector('.layout-topbar-menu-button');

    return !(sidebarEl.isSameNode(event.target) || sidebarEl.contains(event.target) || topbarEl.isSameNode(event.target) || topbarEl.contains(event.target));
};

//Modal de confirmação para sair do portal.
const confirmLogout = () => {
    confirmLogoutDialog.value = true;
};

//Realiza o Logout do portal.
const logout = () => {
    sessionStorage.clear();
    location.reload();
};

</script>

<template>
    <div class="layout-topbar">
        <router-link to="/" class="layout-topbar-logo">
            <img :src="logoUrl" alt="logo" />
            <span> </span>
        </router-link>

        <button class="p-link layout-menu-button layout-topbar-button" @click="onMenuToggle()">
            <i class="pi pi-bars"></i>
        </button>

        <button class="p-link layout-topbar-menu-button layout-topbar-button" @click="onTopBarMenuButton()">
            <i class="pi pi-ellipsis-v"></i>
        </button>

        <div class="layout-topbar-menu" :class="topbarMenuClasses">
            <!-- <small class="p-link layout-topbar-button">Olá, {{nome}}!</small> -->
            <button @click="this.$router.push({path:`/perfil`});" class="p-link layout-topbar-button" title="Perfil do Usuário">
                <i class="pi pi-user"></i>
                <span>Perfil</span>
            </button>
            <button @click="confirmLogout()" class="p-link layout-topbar-button" title="Sair do portal">
                <i class="pi pi-sign-out"></i>
                <span>Sair</span>
            </button>
        </div>
    </div>

    <Dialog v-model:visible="confirmLogoutDialog" :style="{ width: '450px' }" header="Deseja sair do sistema?" :modal="true">
        <div class="flex align-items-center justify-content-center">
            <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
            <span>Ao confirmar você será redirecionado para a tela de Login.</span>
        </div>
        <template #footer>
            <Button label="Não" icon="pi pi-times" text @click="confirmLogoutDialog = false" />
            <Button label="Sim" icon="pi pi-check" text @click="logout()" />
        </template>
    </Dialog>
</template>


<style lang="scss" scoped></style>
