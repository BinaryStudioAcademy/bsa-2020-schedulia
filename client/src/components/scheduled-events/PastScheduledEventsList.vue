<template>
    <div>
        <Pagination />
        <VContainer class="container-content pagination">
            <TabsLink class="scheduled-tabs" :tabs="tabs">
                <template v-slot:right-side>
                    <FilterButton />
                    <ExportButton />
                </template>
            </TabsLink>
            <Past />
        </VContainer>
    </div>
</template>

<script>
import TabsLink from '@/components/tabs/TabsLink.vue';
import Past from './Past/Past';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import FilterButton from './FilterButton';
import ExportButton from './ExportButton';
import Pagination from './Pagination';
import { mapGetters } from 'vuex';

export default {
    name: 'PastScheduledEventsList',

    components: {
        Pagination,
        ExportButton,
        FilterButton,
        Past,
        TabsLink
    },
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        tabs() {
            return [
                {
                    title: this.lang.UPCOMING,
                    routeName: 'Upcoming'
                },
                {
                    title: this.lang.PAST,
                    routeName: 'Past'
                },
                {
                    title: this.lang.DATE_RANGE,
                    routeName: 'DateRange'
                }
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
