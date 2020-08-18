<template>
    <GeneralLayout>
        <template v-slot:title>
            My Events
        </template>
        <Tabs :tabs="tabs"></Tabs>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import Tabs from '@/components/tabs/Tabs.vue';
import EventTypesList from '@/components/event-types/EventTypesList';
import ScheduledEventsList from '@/components/scheduled-events/ScheduledEventsList';
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'EventTypes',
    components: {
        GeneralLayout,
        Tabs
    },
    data: () => ({
        tabs: [
            { title: 'Event Types', component: EventTypesList },
            { title: enLang.SCHEDULED_EVENTS, component: ScheduledEventsList }
        ]
    })
};
</script>

<style scoped></style>
