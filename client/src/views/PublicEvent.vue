<template>
    <GeneralLayout>
        <EventType />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/public/calendar/GeneralLayout';
import EventType from '@/components/public/calendar/EventType';

export default {
    name: 'PublicEvent',
    components: {
        GeneralLayout,
        EventType
    }
};
</script>
