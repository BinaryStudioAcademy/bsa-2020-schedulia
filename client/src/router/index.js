import Vue from 'vue';
import VueRouter from 'vue-router';

import UserDataProvider from '@/components/guard/UserDataProvider';
import LoginGuard from '@/components/guard/LoginGuard';
import AuthGuard from '@/components/guard/AuthGuard';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: UserDataProvider,
        children: [
            {
                path: 'event',
                name: 'PublicEvent',
                component: () => import('../views/PublicEvent.vue')
            },
            {
                path: 'confirm-event',
                name: 'PublicEventConfirm',
                component: () => import('../views/PublicEventConfirm.vue')
            },
            {
                path: 'event-details',
                name: 'PublicEventDetails',
                component: () => import('../views/PublicEventDetails.vue')
            },
            {
                path: 'event-disabled',
                name: 'DisabledEvent',
                component: () => import('../views/DisabledEvent.vue')
            },
            {
                path: '',
                component: AuthGuard,
                children: [
                    {
                        path: '',
                        name: 'SignIn',
                        component: () => import('../views/SignIn')
                    },
                    {
                        path: 'sign-up',
                        name: 'SignUp',
                        component: () => import('../views/SignUp')
                    },
                    {
                        path: 'forgot-password',
                        name: 'ForgotPassword',
                        component: () => import('../views/ForgotPassword')
                    },
                    {
                        path: 'reset-password',
                        name: 'ResetPassword',
                        component: () => import('../views/ResetPassword')
                    }
                ]
            },
            {
                path: '',
                component: LoginGuard,
                children: [
                    // There must be routes which need logged user
                    {
                        path: '',
                        name: 'EventTypes',
                        component: () => import('../views/EventTypes')
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
                        path: 'calendar-connections',
                        name: 'CalendarConnections',
                        component: () => import('../views/CalendarConnections')
                    },
                    {
                        path: 'new-event',
                        name: 'newEvent',
                        component: () => import('../views/NewEventType')
                    },
                    {
                        path: 'new-event-edit',
                        name: 'newEventEdit',
                        component: () => import('../views/NewEventTypeBooking')
                    },
                    {
                        path: 'scheduled-events',
                        name: 'ScheduledEvents',
                        component: () => import('../views/ScheduledEvents'),
                        children: [
                            {
                                path: '',
                                name: 'Upcoming',
                            },
                            {
                                path: 'past',
                                name: 'Past',
                            },
                            {
                                path: 'date-range',
                                name: 'DateRange',
                            },
                        ]
                    }
                ]
            },

            {
                path: 'verified-email',
                name: 'verified-email',
                component: () => import('../views/VerifiedEmail')
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
