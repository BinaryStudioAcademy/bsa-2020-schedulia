<template>
    <VDialog v-model="dialog" persistent max-width="500">
        <template v-slot:activator="{ on, attrs }">
            <span
                v-bind="attrs"
                v-on="on"
            >
                Delete
            </span>
        </template>
        <VCard>
            <VCardTitle class="headline text-danger">Delete {{ eventType.name }}?</VCardTitle>
            <VCardText>
                Users will be unable to schedule further meetings with deleted event types. Meetings previously scheduled will be affected.
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="darken-1" text @click="dialog = false">Cancel</VBtn>
                <VBtn color="red darken-1" @click="onDelete">Yes</VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import * as actions from '@/store/modules/eventTypes/types/actions';
import { mapActions } from 'vuex';
export default {
    name: 'DeleteConfirmDialog',
    data: () => ({
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

<style scoped>

</style>