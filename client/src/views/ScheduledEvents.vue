<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.MY_EVENTS }}
        </template>
        <TabsLink :tabs="tabs"></TabsLink>
        <ScheduledEventsList />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import TabsLink from '@/components/tabs/TabsLink.vue';
import ScheduledEventsList from '@/components/scheduled-events/ScheduledEventsList';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'ScheduledEvents',
    components: {
        GeneralLayout,
        ScheduledEventsList,
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
                    title: this.lang.EVENT_TYPES,
                    route: '/'
                },
                {
                    title: this.lang.SCHEDULED_EVENTS,
                    route: '/scheduled-events'
                }
            ];
        }
    }
};
</script>

<style scoped></style>
