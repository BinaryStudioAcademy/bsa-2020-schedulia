<template>
    <VContainer class="scheduled-pagination">
        <VRow>
            <VCol class="text-right">
                Displaying {{ eventsPagination.pageStartEventNum }} – {{ eventsPagination.pageEndEventNum }} of {{ eventsPagination.allEvents }} Events
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { GET_SCHEDULED_EVENTS_PAGINATION } from '@/store/modules/scheduledEvent/types/getters';

    export default {
        name: "Pagination",

        computed: {
            ...mapGetters('scheduledEvent', {
                eventsPagination: GET_SCHEDULED_EVENTS_PAGINATION,
            })
        },
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
