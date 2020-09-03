<template>
    <GeneralLayout>
        <template v-slot:title>
            Notification Connections
        </template>
        <SlackNotificationConnection />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import SlackNotificationConnection from '@/components/notification-connections/SlackNotificationConnection';
import { mapGetters } from 'vuex';
import * as getters from '@/store/modules/auth/types/getters';
export default {
    name: 'NotificationConnections',
    components: {
        GeneralLayout,
        SlackNotificationConnection
    },
    data: () => ({
        slackIsActive: false
    }),
    computed: {
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        })
    },
    async mounted() {
        this.slackIsActive = this.user.slack_active;
    }
};
</script>

<style scoped></style>
