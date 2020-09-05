<template>
    <VDialog
        v-model="dialog"
        persistent
        max-width="600px"
        activator="#chatito-confirm"
    >
        <VCard>
            <VCardTitle>
                <span class="headline text-danger">{{ lang.CONNECT }} Chatito</span>
            </VCardTitle>
            <VCardText>
                <h3>
                    {{ lang.ARE_YOU_SURE_YOU_REGISTERED_IN }}
                    <a href="http://chatito.xyz" target="_blank">Chatito</a>?
                </h3>
                <br />
                <span class="subtitle-2">{{ lang.REGISTER_IF_YOU_DIDNT_IT_YET }}</span>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false"
                    >{{ lang.CLOSE }}</VBtn
                >
                <VBtn color="red" @click="onConfirm">
                    {{ lang.CONFIRM }}
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import * as actions from '@/store/modules/auth/types/actions';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

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
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped></style>
