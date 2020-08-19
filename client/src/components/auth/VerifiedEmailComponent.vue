<template>
    <div>
        <p v-show="textVisible">Your account is being activated...</p>

        <Alert
            :type="alert.type"
            :message="alert.message"
            :visibility="alert.visible"
            @user-deleted="onAlertClose"
        />
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions } from 'vuex';
import * as notificationActions from '@/store/modules/notification/types/actions';
import Alert from '@/components/alert/Alert';
export default {
    name: 'VerifiedEmailComponent',
    components: {
        Alert
    },
    data: () => ({
        lang: enLang,
        alert: {
            visible: false,
            message: '',
            type: ''
        },
        textVisible: true
    }),
    methods: {
        ...mapActions('auth', {
            verifyEmail: actions.VERIFY_EMAIL
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),

        onAlertClose() {
            this.alert.visible = false;
        },

        showMessage(message, type = '') {
            this.alert.message = message;
            this.alert.type = type;
            this.alert.visible = true;
        }
    },

    async created() {
        try {
            await this.verifyEmail(this.$route.query);
            setTimeout(() => (this.textVisible = false), 1000);
            this.showMessage(this.lang.ACCOUNT_VERIFIED, 'success.login');
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    }
};
</script>

<style scoped></style>
