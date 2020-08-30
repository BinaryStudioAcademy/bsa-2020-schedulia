<template>
    <div>
        <p>{{ lang.PLEASE_WAIT_WHILE_WE_ARE_LOGGING_YOU_IN }}</p>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import * as actions from '@/store/modules/auth/types/actions';
import * as notificationActions from '@/store/modules/notification/types/actions';
import authService from '@/services/auth/authService';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    name: 'SocialLoginCallback',

    async mounted() {
        try {
            await authService.saveToken(this.$route.query.token);
            await this.fetchLoggedUser();
            this.$router.push({ name: 'EventTypes' });
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },

    methods: {
        ...mapActions('auth', {
            fetchLoggedUser: actions.FETCH_LOGGED_USER
        }),

        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        })
    }
};
</script>

<style scoped></style>
