import { createRouter, createWebHistory } from 'vue-router'

import Login from '../views/Login.vue'
import TelaInicial from '../views/TelaInicial.vue'
import TelaUsuarios from '../views/TelaUsuarios.vue'
import { validarToken } from '../auth'

const routes = [
    {
        path: '/',
        redirect: '/login'
    },

    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { requiresAuth: false },
    },

    {
        path: '/telainicial',
        name: 'TelaInicial',
        component: TelaInicial,
        meta: { requiresAuth: true },
    },

    {
        path: '/telausuarios',
        name: 'TelaUsuarios',
        component: TelaUsuarios,
        meta: { requiresAuth: true },
    },
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

// Proteção das rotas.
router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.meta.requiresAuth

    if (requiresAuth) {
        const valido = await validarToken()

    if (!valido) {
        localStorage.removeItem('token')
        next('/login')
    } else {
        next()
    }
  } else {
        next()
  }
})

export default router
