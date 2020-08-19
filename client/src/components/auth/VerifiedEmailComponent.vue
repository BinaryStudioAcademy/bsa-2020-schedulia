<template>
    <div class="ml-5 mt-5">
        <div>
            <p v-show="textVisible">{{ lang.ACCOUNT_IS_BEING_ACTIVATED }}</p>
        </div>
        <div  v-if="textVisible === false" class="d-flex">
            <p class="mr-2">{{ lang.ACCOUNT_VERIFIED }} </p>
            <RouterLink :to="{ name: 'SignIn' }">{{ lang.LOGIN }}</RouterLink>
        </div>

    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions } from 'vuex';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'VerifiedEmailComponent',

    data: () => ({
        lang: enLang,

        textVisible: true,
    }),
    methods: {
        ...mapActions('auth', {
            verifyEmail: actions.VERIFY_EMAIL
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
    },

    async created() {
        try {
            await this.verifyEmail(this.$route.query);
            this.textVisible = false;
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    }
};
</script>

<style scoped>
</style>
