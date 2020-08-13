<template>
    <GeneralLayout>
        <template v-slot:title>
            My Schedulia
        </template>
        <Tabs :tabs="tabs"></Tabs>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import Tabs from '@/components/tabs/Tabs.vue';
import EventTypesList from '@/components/event-types/EventTypesList';

export default {
    name: 'EventTypes',
    components: {
        GeneralLayout,
        Tabs
    },
    data: () => ({
        tabs: [{ title: 'Event Types', component: EventTypesList }]
    })
};
</script>

<style scoped></style>
