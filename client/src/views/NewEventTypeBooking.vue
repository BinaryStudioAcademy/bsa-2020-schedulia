<template>
    <GeneralLayout>
        <CreateEventTypeBooking/>
        <template v-slot:title>
            <NewEventTypeTitle />
        </template>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import NewEventTypeTitle from '@/components/events/NewEventTypeTitle';
import CreateEventTypeBooking from '@/components/events/CreateEventTypeBooking';
export default {
    name: 'NewEventTypeBooking',
    components: {
        GeneralLayout,
        NewEventTypeTitle,
        CreateEventTypeBooking

    }
};
</script>

<style scoped>

</style>