<template>
    <VCol cols="12" md="3" lg="3" sm="6">
        <div class="notification-block">
            <div class="notification-main p-4">
                <div class="notification-content text-center">
                    <h3 class="notification-name">Slack</h3>
                    <VChip class="ma-2" v-if="!user.slack_active">
                        Disabled
                    </VChip>
                    <VChip class="ma-2" color="#36c5f0" v-else>
                        Active
                    </VChip>
                </div>
                <VDivider></VDivider>
                <div class="actions mt-3 mb-3 text-center row">
                    <div class="col text-left">
                        <SlackModalIntegrationConnect />
                        <VBtn
                            color="red"
                            class="slack-delete"
                            :disabled="!user.slack_active"
                        >
                            <VIcon color="white">mdi-delete</VIcon>
                        </VBtn>
                    </div>
                    <div class="col text-right"></div>
                </div>
            </div>
        </div>

        <DeleteSlackIntegrationModal />
    </VCol>
</template>

<script>
import SlackModalIntegrationConnect from '@/components/notification-connections/slack/SlackModalIntegrationConnect';
import DeleteSlackIntegrationModal from '@/components/notification-connections/slack/DeleteSlackIntegrationModal';
import { mapGetters } from 'vuex';
import * as getters from '@/store/modules/auth/types/getters';
export default {
    name: 'SlackNotificationConnection',
    components: {
        SlackModalIntegrationConnect,
        DeleteSlackIntegrationModal
    },
    computed: {
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        })
    }
};
</script>

<style scoped>
.notification-block {
    background: #fff;
    padding: 15px 20px 0 20px;
    border-radius: 10px;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.25);
    height: 100%;
}
.notification-content {
    min-height: 120px;
}
.notification-name {
    font-size: 30px;
    word-break: break-all;
}
</style>
