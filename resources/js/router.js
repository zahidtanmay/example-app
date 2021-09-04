import VueRouter from "vue-router";

import LoginPage from './pages/LoginPage'
import RegisterPage from './pages/RegisterPage'
import NotFoundPage from './pages/NotFoundPage'
import AuthenticatedBase from './pages/authenticated/AuthenicatedBase'
import ProductPage from './pages/authenticated/ProductPage'
import LogoutPage from './pages/authenticated/LogoutPage'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: {name: 'dashboard'}
        },
        {
            name: 'login',
            path: '/login',
            component: LoginPage,
        },
        {
            name: 'register',
            path: '/register',
            component: RegisterPage,
        },
        {
            path: '/auth',
            component: AuthenticatedBase,
            meta: {requiresAuth: true},
            children: [
                {
                    name: 'dashboard',
                    path: 'dashboard',
                    component: ProductPage,
                },
                {
                    name: 'logout',
                    path: 'logout',
                    component: LogoutPage,
                }
            ]
        },
        // Catch-all for unknown pages
        {
            path: '*',
            component: NotFoundPage,
        }
    ]
});

router.beforeEach((to, from, next) => {
    console.log(to, from)
    if(to.matched.some(record => record.meta.requiresAuth)) {
        const authToken = window.localStorage.getItem('authToken');
        console.log(authToken)
        if (!authToken) {
            next({
                name: 'login',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else {
        next();
    }
});

export default router;
