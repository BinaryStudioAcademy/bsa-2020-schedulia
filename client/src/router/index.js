import Vue from 'vue';
import VueRouter from 'vue-router';
import qs from 'qs';

import UserDataProvider from '@/components/guard/UserDataProvider';
import LoginGuard from '@/components/guard/LoginGuard';
import AuthGuard from '@/components/guard/AuthGuard';
import RoutersTesterGuard from '@/components/guard/UseExistGuard';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: UserDataProvider,
        children: [
            {
                path: 'error404',
                name: 'Error404',
                component: () => import('../views/Error404')
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
                    },

                    {
                        path: 'verified-email',
                        name: 'verifiedEmail',
                        component: () => import('../views/VerifiedEmail')
                    },

                    {
                        path: 'auth/social-callback',
                        name: 'socialCallback',
                        component: () => import('../views/SocialLogin')
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
                        path: 'notification-connections',
                        name: 'NotificationConnections',
                        component: () =>
                            import('../views/NotificationConnections')
                    },
                    {
                        path: 'new-event-type',
                        name: 'newEventType',
                        component: () => import('../views/NewEventTypeBooking')
                    },
                    {
                        path: 'event-type/:id',
                        name: 'EventType',
                        component: () =>
                            import('../views/NewEventTypeAdditionalOptions')
                    },
                    {
                        path: 'scheduled-events',
                        name: 'ScheduledEvents',
                        component: () => import('../views/ScheduledEvents'),
                        children: [
                            {
                                path: '',
                                name: 'Upcoming'
                            },
                            {
                                path: 'past',
                                name: 'Past'
                            },
                            {
                                path: 'date-range',
                                name: 'DateRange'
                            }
                        ]
                    }
                ]
            },
            {
                path: 'event-disabled',
                name: 'DisabledEvent',
                component: () => import('../views/DisabledEvent.vue')
            },
            {
                path: ':nickname',
                component: RoutersTesterGuard,
                children: [
                    {
                        path: '',
                        name: 'UserEventTypes',
                        component: () =>
                            import('../views/UserEventTypesList.vue')
                    },
                    {
                        path: ':slug',
                        name: 'PublicEvent',
                        component: () => import('../views/PublicEvent.vue')
                    },
                    {
                        path: ':slug/:date',
                        name: 'PublicEventConfirm',
                        component: () =>
                            import('../views/PublicEventConfirm.vue')
                    },
                    {
                        path: ':slug/invitee/details',
                        name: 'PublicEventDetails',
                        component: () =>
                            import('../views/PublicEventDetails.vue')
                    }
                ]
            },
            {
                path: '*',
                redirect: { name: 'Error404' }
            }
        ]
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
    parseQuery(query) {
        return qs.parse(query);
    },
    stringifyQuery(query) {
        let result = qs.stringify(query, { encode: false });

        return result ? '?' + result : '';
    }
});

export default router;
