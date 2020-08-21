<template>
    <GeneralLayout>
        <ConfirmEventType />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/public/calendar/GeneralLayout';
import ConfirmEventType from '@/components/public/calendar/ConfirmEventType';

export default {
    name: 'PublicEventConfirm',
    components: {
        GeneralLayout,
        ConfirmEventType
    }
};
</script>
