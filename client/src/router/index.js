import Vue from 'vue';
import VueRouter from 'vue-router';

import UserDataProvider from '@/components/guard/UserDataProvider';
import LoginGuard from '@/components/guard/LoginGuard';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'UserDataProvider',
        component: UserDataProvider,
        children: [
            {
                path: '',
                name: 'Home',
                component: () => import('../views/Login.vue')
            },
            {
                path: 'about',
                name: 'About',
                component: () => import('../views/About.vue')
            },
            {
                path: 'status',
                component: () => import('../views/Status.vue')
            },
            {
                path: 'profile',
                name: 'profile',
                component: () => import('../views/Profile.vue')
            },
            {
                path: '',
                name: 'LoginGuard',
                component: LoginGuard,
                children: [
                    // There must be routes which need logged user
                ]
            },
            {
                path: 'signup',
                name: 'SignUp',
                component: () => import('../views/SignUp')
            },
            {
                path: 'login',
                name: 'Login',
                component: () => import('../views/Login.vue')
            },
            {
                path: 'event',
                name: 'Event',
                component: () => import('../views/Event.vue')
            }
        ]
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

export default router;
