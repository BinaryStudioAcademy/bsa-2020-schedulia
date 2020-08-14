<template>
    <VDialog v-model="dialog" persistent max-width="500">
        <template v-slot:activator="{ on, attrs }">
            <span v-bind="attrs" v-on="on">
                {{ lang.DELETE }}
            </span>
        </template>
        <VCard>
            <VCardTitle class="headline text-danger"
                >{{ lang.DELETE }} {{ eventType.name }}?</VCardTitle
            >
            <VCardText>
                {{ lang.DIALOG_EVENT_TYPE_DELETE_CONFIRM }}
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="darken-1" text @click="dialog = false">{{
                    lang.CANCEL
                }}</VBtn>
                <VBtn color="red darken-1" @click="onDelete">{{
                    lang.YES
                }}</VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import * as actions from '@/store/modules/eventTypes/types/actions';
import { mapActions } from 'vuex';
import enLang from '@/store/modules/i18n/en';
export default {
    name: 'DeleteConfirmDialog',
    data: () => ({
        lang: enLang,
        dialog: false
    }),
    props: {
        eventType: {
            required: true
        }
    },
    methods: {
        ...mapActions('eventTypes', {
            deleteEventType: actions.DELETE_EVENT_TYPE_BY_ID
        }),
        async onDelete() {
            await this.deleteEventType(this.eventType.id);
            this.dialog = false;
        }
    }
};
</script>

<style scoped></style>
