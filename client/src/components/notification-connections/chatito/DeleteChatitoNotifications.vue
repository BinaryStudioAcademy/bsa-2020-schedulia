<template>
    <VDialog
        v-model="dialog"
        persistent
        max-width="600px"
        activator="#chatito-delete"
    >
        <VCard>
            <VCardTitle>
                <span class="headline text-danger">{{ lang.DELETE }} Chatito</span>
            </VCardTitle>
            <VCardText>
                <h3>
                    {{ lang.ARE_YOU_SURE_YOU_WANT_TO_DELETE }}
                    <a href="http://chatito.xyz" target="_blank">Chatito</a>
                    {{ lang.NOTIFICATIONS }}?
                </h3>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false"
                    >{{ lang.CLOSE }}</VBtn
                >
                <VBtn color="red" @click="onDelete">
                    {{ lang.DELETE }}
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
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped></style>
