<template>
    <VDialog
        v-model="dialog"
        persistent
        max-width="600px"
        activator="#chatito-confirm"
    >
        <VCard>
            <VCardTitle>
                <span class="headline text-danger">Connect Chatito</span>
            </VCardTitle>
            <VCardText>
                <h3>
                    Are you sure you registered in
                    <a href="http://chatito.xyz" target="_blank">Chatito</a>?
                </h3>
                <br />
                <span class="subtitle-2">Register if you didn't it yet.</span>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false"
                    >Close</VBtn
                >
                <VBtn color="red" @click="onConfirm">
                    Confirm
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import { mapActions } from 'vuex';
import * as actions from '@/store/modules/auth/types/actions';
export default {
    name: 'ConfirmRegistrationgInChatito',
    data: () => ({
        dialog: false
    }),
    methods: {
        ...mapActions('auth', {
            changeChatitoActivity: actions.CHANGE_CHATITO_NOTIFICATIONS_ACTIVITY
        }),
        async onConfirm() {
            await this.changeChatitoActivity({
                chatito_active: true
            });
            this.dialog = false;
        }
    }
};
</script>

<style scoped></style>
