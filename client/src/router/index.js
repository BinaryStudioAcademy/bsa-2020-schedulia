import Vue from 'vue';
import VueRouter from 'vue-router';

import UserDataProvider from '@/components/guard/UserDataProvider';
import LoginGuard from '@/components/guard/LoginGuard';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: UserDataProvider,
        children: [
            {
                path: '',
                name: 'SignIn',
                component: () => import('../views/SignIn')
            },
            {
                path: 'signup',
                name: 'SignUp',
                component: () => import('../views/SignUp')
            },
            {
                path: '',
                component: LoginGuard,
                children: [
                    // There must be routes which need logged user
                    {
                        path: 'home',
                        name: 'Home',
                        component: () => import('../views/Home')
                    },
                    {
                        path: 'status',
                        name: 'Status',
                        component: () => import('../views/Status')
                    },
                    {
                        path: 'about',
                        name: 'About',
                        component: () => import('../views/About')
                    },
                    {
                        path: 'profile',
                        name: 'Profile',
                        component: () => import('../views/Profile')
                    },

                    {
                        path: 'new-event',
                        name: 'new-event',
                        component: () => import('../views/NewEventType')
                    },
                ]
            },
        ]
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

export default router;
