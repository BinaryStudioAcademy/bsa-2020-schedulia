<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.MY_EVENTS }}
        </template>
        <TabsLink :tabs="tabs"></TabsLink>
        <EventTypesList />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import TabsLink from '@/components/tabs/TabsLink.vue';
import EventTypesList from '@/components/event-types/EventTypesList';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'EventTypes',
    components: {
        GeneralLayout,
        EventTypesList,
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
