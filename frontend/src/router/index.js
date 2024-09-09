import { createRouter, createWebHistory } from 'vue-router';
import AppLayout from '@/layout/AppLayout.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('@/views/Inicio.vue')
                },
                {
                    path: '/clientes',
                    name: 'clientes',
                    component: () => import('@/views/clientes/Clientes.vue')
                },
                {
                    path: '/usuarios',
                    name: 'usuarios',
                    component: () => import('@/views/configuracoes/Usuarios.vue')
                },
                {
                    path: 'configuracoes/estados',
                    name: 'estados',
                    component: () => import('@/views/configuracoes/Estados.vue')
                },
                {
                    path: 'configuracoes/cidades',
                    name: 'cidades',
                    component: () => import('@/views/configuracoes/Cidades.vue')
                },
                {
                    path: '/perfil',
                    name: 'perfil',
                    component: () => import('@/views/Perfil.vue')
                },
            ]
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('@/views/auth/Login.vue')
        },
        {
            path: '/register',
            name: 'register',
            component: () => import('@/views/auth/Register.vue')
        }
    ]
});

router.beforeEach(async (to, from) => {

    const loggedIn = sessionStorage.getItem('loggedIn');

    if (!loggedIn && to.name !== 'login' && to.name !== 'register') { // Certifica-te que utilizador está logado & Evite um redirecionamento infinito
        return { name: 'login' } // redireciona o utilizador para uma página `login`
    }

});

export default router;
