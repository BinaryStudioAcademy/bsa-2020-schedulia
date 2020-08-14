<template>
    <VApp>
        <RouterView />
        <Notifications />
        <Alert
            :visibility="alert.visible"
            :type="alert.type"
            :message="alert.message"
        />
    </VApp>
</template>

<script>
import Notifications from './components/common/Notification/Notifications';
import EventEmitter from '@/services/EventEmmiter';
import authService from '@/services/auth/authService';
import Alert from '@/components/alert/Alert';
export default {
    name: 'App',
    components: {
        Notifications,
        Alert
    },
    data: () => ({
        alert: {
            visible: false,
            type: '',
            message: ''
        }
    }),
    created() {
        EventEmitter.$on('token-expired', () => {
            authService.removeToken();
            this.$router.push({ name: 'SignIn' });
            this.showAlert('error', 'Unauthorized!');
        });
    },
    methods: {
        showAlert(type, msg) {
            this.alert.type = type;
            this.alert.message = msg;
            this.alert.visible = true;
        }
    }
};
</script>

<style lang="scss" type="text/scss">
@import './scss/common.scss';
</style>
