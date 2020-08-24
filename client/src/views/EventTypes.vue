<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.MY_EVENTS }}
        </template>
        <Tabs :tabs="tabs"></Tabs>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import Tabs from '@/components/tabs/Tabs.vue';
import EventTypesList from '@/components/event-types/EventTypesList';
import ScheduledEventsList from '@/components/scheduled-events/ScheduledEventsList';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'EventTypes',
    components: {
        GeneralLayout,
        Tabs
    },
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        tabs() {
            return [
                { title: this.lang.EVENT_TYPES, component: EventTypesList },
                {
                    title: this.lang.SCHEDULED_EVENTS,
                    component: ScheduledEventsList
                }
            ];
        }
    }
};
</script>

<style scoped></style>
