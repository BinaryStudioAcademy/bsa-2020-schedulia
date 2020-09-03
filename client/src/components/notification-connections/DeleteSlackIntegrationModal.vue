<template>
    <VDialog v-model="dialog" persistent max-width="600px" activator=".slack-delete">
        <VCard>
            <VCardTitle>
                <span class="headline text-danger">Delete Slack</span>
            </VCardTitle>
            <VCardText>
                <h3>Are you sure you want to delete Slack notifications?</h3>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false"
                    >Close</VBtn
                >
                <VBtn
                    color="red"
                    @click="onDelete"
                >
                    Delete
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import { mapActions } from 'vuex';
import * as actions from '@/store/modules/auth/types/actions';
export default {
    name: 'DeleteSlackIntegrationModal',
    data: () => ({
        dialog: false
    }),
    methods: {
        ...mapActions('auth', {
            deleteSlackNotifications: actions.DELETE_SLACK_NOTIFICATIONS
        }),
        async onDelete() {
            await this.deleteSlackNotifications();
            this.dialog = false;
        }
    }
};
</script>

<style scoped>

</style>