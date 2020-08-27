<template>
    <div>
        <p>Please wait while we're logging you in...</p>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import * as actions from '@/store/modules/auth/types/actions';
import * as notificationActions from '@/store/modules/notification/types/actions';
import authService from '@/services/auth/authService';

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
