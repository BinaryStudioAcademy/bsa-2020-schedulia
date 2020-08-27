<template>
    <div>
        <p>Please wait while we're logging you in...</p>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import * as actions from '@/store/modules/auth/types/actions';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'SocialLoginCallback',

    data: () => ({
        token: this.$route.query.token // this undefined
    }),

    async mounted() {
        console.log(this.$route.query.token); //this working
        // try {
        //     await this.saveToken(this.token);
        //     await this.fetchLoggedUser();
        //     this.$router.push({ name: 'EventTypes' });
        // } catch (error) {
        //     this.setErrorNotification(error.message);
        // }
    },

    methods: {
        ...mapActions('auth', {
            saveToken: 'saveToken',
            fetchLoggedUser: actions.FETCH_LOGGED_USER
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
    }
};
</script>

<style scoped>

</style>