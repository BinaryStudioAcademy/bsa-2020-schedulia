<template>
    <div>
        <Pagination />
        <VContainer class="container-content pagination">
            <Tabs class="scheduled-tabs" :tabs="tabs">
                <template v-slot:right-side>
                    <FilterButton />
                    <ExportButton />
                </template>
            </Tabs>
        </VContainer>
    </div>
</template>

<script>
import Tabs from '@/components/tabs/Tabs.vue';
import Upcoming from './Upcoming/Upcoming';
import Pending from './Pending/Pending';
import Past from './Past/Past';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import FilterButton from './FilterButton';
import ExportButton from './ExportButton';
import Pagination from './Pagination';
import { mapGetters } from 'vuex';

export default {
    name: 'ScheduledEventList',

    components: {
        Pagination,
        ExportButton,
        FilterButton,
        Tabs
    },
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        tabs() {
            return [
                { title: this.lang.UPCOMING, component: Upcoming },
                { title: this.lang.PENDING, component: Pending },
                { title: this.lang.PAST, component: Past },
                { title: this.lang.DATE_RANGE }
            ];
        }
    }
};
</script>

<style scoped>
.container-content.pagination {
    margin-top: 0;
}

.scheduled-tabs::v-deep .v-tabs-bar {
    height: 87px !important;
}

.scheduled-tabs::v-deep .v-toolbar__content {
    height: 87px !important;
}

.scheduled-tabs::v-deep .v-sheet {
    height: 87px !important;
}
</style>
