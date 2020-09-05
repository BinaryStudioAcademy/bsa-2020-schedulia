<template>
    <VDialog
        v-model="dialog"
        persistent
        max-width="600px"
        activator="#chatito-delete"
    >
        <VCard>
            <VCardTitle>
                <span class="headline text-danger">Delete Chatito</span>
            </VCardTitle>
            <VCardText>
                <h3>
                    Are you sure you want to delete
                    <a href="http://chatito.xyz" target="_blank">Chatito</a>
                    notifications?
                </h3>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false"
                    >Close</VBtn
                >
                <VBtn color="red" @click="onDelete">
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
    name: 'DeleteChatitoNotifications',
    data: () => ({
        dialog: false
    }),
    methods: {
        ...mapActions('auth', {
            changeChatitoActivity: actions.CHANGE_CHATITO_NOTIFICATIONS_ACTIVITY
        }),
        async onDelete() {
            await this.changeChatitoActivity({
                chatito_active: false
            });
            this.dialog = false;
        }
    }
};
</script>

<style scoped></style>
