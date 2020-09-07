<template>
    <VDialog
        v-model="dialog"
        persistent
        max-width="600px"
        activator=".slack-delete"
    >
        <VCard>
            <VCardTitle>
                <span class="headline text-danger"
                    >{{ lang.DELETE }} Slack</span
                >
            </VCardTitle>
            <VCardText>
                <h3>
                    {{ lang.ARE_YOU_SURE_YOU_WANT_TO_DELETE }} Slack
                    {{ lang.NOTIFICATIONS }}?
                </h3>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false">{{
                    lang.CLOSE
                }}</VBtn>
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
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped></style>
