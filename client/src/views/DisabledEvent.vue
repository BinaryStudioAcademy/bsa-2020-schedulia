<template>
    <GeneralLayout>
        <DisabledEvent />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/public/calendar/GeneralLayout';
import DisabledEvent from '@/components/public/calendar/DisabledEvent';

export default {
    name: 'PublicEvent',
    components: {
        GeneralLayout,
        DisabledEvent
    }
};
</script>
