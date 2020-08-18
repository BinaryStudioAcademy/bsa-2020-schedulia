<template>
    <VContainer class="scheduled-pagination">
        <VRow>
            <VCol class="text-right">
                {{ lang.DISPLAYING }} {{ eventsPagination.pageStartEventNum }} – {{ eventsPagination.pageEndEventNum }} {{ lang.OF }} {{ eventsPagination.allEvents }} {{ lang.EVENTS }}
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
    import { mapGetters } from 'vuex';
    import enLang from '@/store/modules/i18n/en.js';
    import { GET_SCHEDULED_EVENTS_PAGINATION } from '@/store/modules/scheduledEvent/types/getters';

    export default {
        name: "Pagination",

        data: () => ({
            lang: enLang
        }),

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
