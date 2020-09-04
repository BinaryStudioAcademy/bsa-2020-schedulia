<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.MY_EVENTS }}
        </template>
        <TabsLink :tabs="tabs"></TabsLink>
        <Component v-bind:is="routePageName"></Component>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import TabsLink from '@/components/tabs/TabsLink.vue';
import Upcoming from '@/components/scheduled-events/UpcomingScheduledEventsList';
import Past from '@/components/scheduled-events/PastScheduledEventsList';
import DateRange from '@/components/scheduled-events/DateRangeScheduledEventsList';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'ScheduledEvents',
    components: {
        GeneralLayout,
        Upcoming,
        Past,
        DateRange,
        TabsLink
    },
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),

        routePageName() {
            return this.$route.name;
        },

        tabs() {
            return [
                {
                    title: this.lang.EVENT_TYPES,
                    routeName: 'EventTypes'
                },
                {
                    title: this.lang.SCHEDULED_EVENTS,
                    routeName: 'Upcoming'
                }
            ];
        }
    }
};
</script>

<style scoped></style>
