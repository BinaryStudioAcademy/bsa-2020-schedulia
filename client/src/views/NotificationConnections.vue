<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.NOTIFICATION_CONNECTIONS }}
        </template>
        <div class="container">
            <div class="row-flex flex-wrap flex-row d-flex">
                <SlackNotificationConnection />
                <ChatitoNotificationConnection />
            </div>
        </div>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import SlackNotificationConnection from '@/components/notification-connections/slack/SlackNotificationConnection';
import ChatitoNotificationConnection from '@/components/notification-connections/chatito/ChatitoNotificationConnection';
import { mapGetters } from 'vuex';
import * as getters from '@/store/modules/auth/types/getters';
import * as langGetters from '@/store/modules/i18n/types/getters';
export default {
    name: 'NotificationConnections',
    components: {
        GeneralLayout,
        SlackNotificationConnection,
        ChatitoNotificationConnection
    },
    data: () => ({
        slackIsActive: false
    }),
    computed: {
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        }),
        ...mapGetters('i18n', {
            lang: langGetters.GET_LANGUAGE_CONSTANTS
        })
    },
    async mounted() {
        this.slackIsActive = this.user.slack_active;
    }
};
</script>

<style scoped></style>
