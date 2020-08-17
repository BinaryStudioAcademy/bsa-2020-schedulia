<template>
    <GeneralLayout>
        <EventTypeDetails />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/public/calendar/GeneralLayout';
import EventTypeDetails from '@/components/public/calendar/EventTypeDetails';

export default {
    name: 'PublicEventDetails',
    components: {
        GeneralLayout,
        EventTypeDetails
    }
};
</script>
