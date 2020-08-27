<template>
    <VContainer class="scheduled-pagination">
        <VRow>
            <VCol class="text-right">
                {{ lang.DISPLAYING }} 1 –
                {{ eventsPagination.currentPage * eventsPagination.perPage }}
                {{ lang.OF }} {{ eventsPagination.total }} {{ lang.EVENTS }}
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import { mapGetters } from 'vuex';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { GET_SCHEDULED_EVENTS_PAGINATION } from '@/store/modules/scheduledEvent/types/getters';

export default {
    name: 'Pagination',

    data: () => ({}),

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('scheduledEvent', {
            eventsPagination: GET_SCHEDULED_EVENTS_PAGINATION
        })
    }
};
</script>

<style scoped>
.scheduled-pagination {
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.25px;
    color: #989898;
}
</style>
