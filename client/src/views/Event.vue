<template>
    <ETGeneralLayout>
        <EventType />
    </ETGeneralLayout>
</template>

<script>
// @ is an alias to /src
import ETGeneralLayout from '@/components/common/ETGeneralLayout/ETGeneralLayout';
import EventType from '@/components/eventType/EventType';

export default {
    name: 'Event',
    components: {
        ETGeneralLayout,
        EventType
    }
};
</script>
