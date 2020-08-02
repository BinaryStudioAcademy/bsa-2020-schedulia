import Vue from 'vue';
import * as Sentry from '@sentry/browser';
import { Vue as VueIntegration } from '@sentry/integrations';

export const initializeSentry = () => {
    Sentry.init({
        dsn: process.env.VUE_APP_SENTRY_DSN,
        integrations: [
            new VueIntegration({
                Vue,
                attachProps: true,
                logErrors: true
            })
        ]
    });
};
