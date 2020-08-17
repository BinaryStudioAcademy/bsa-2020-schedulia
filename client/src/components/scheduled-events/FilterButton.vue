<template>
    <VBtn
        v-if="!this.scheduledEventsFilterView"
        @click="setScheduledEventsFilterView(true)"
        class="filter-button filter-open"
        outlined
    >
        <VRow>
            <VCol class="text-left" align-self="center">
                Filter
            </VCol>
            <VSpacer></VSpacer>
            <VCol class="text-right">
                <VIcon small>mdi-filter-outline</VIcon>
            </VCol>
        </VRow>
    </VBtn>

    <VBtn
        v-else
        @click="setScheduledEventsFilterView(false)"
        class="filter-button primary"
        depressed
    >
        <VRow>
            <VCol class="text-left" align-self="center">
                Close
            </VCol>
            <VSpacer></VSpacer>
            <VCol class="text-right">
                <VIcon small>mdi-close</VIcon>
            </VCol>
        </VRow>
    </VBtn>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { GET_SCHEDULED_EVENT_FILTER_VIEW } from '@/store/modules/scheduledEvent/types/getters';
import { SET_SCHEDULED_EVENT_FILTER_VIEW } from '@/store/modules/scheduledEvent/types/actions';

export default {
    name: 'FilterButton',

    computed: {
        ...mapGetters('scheduledEvent', {
            scheduledEventsFilterView: GET_SCHEDULED_EVENT_FILTER_VIEW
        })
    },

    methods: {
        ...mapActions('scheduledEvent', {
            setScheduledEventsFilterView: SET_SCHEDULED_EVENT_FILTER_VIEW
        })
    }
};
</script>

<style scoped>
.filter-button::v-deep {
    width: 120px;
    text-transform: none;
    margin-right: 14px;
}

.filter-open::v-deep {
    color: var(--v-primary-base);
}
</style>
