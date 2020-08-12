<template>
    <GeneralLayout>
        <CreateEventTypeForm />
        <template v-slot:title>
            <NewEventTypeTitle />
        </template>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import NewEventTypeTitle from '@/components/events/NewEventTypeTitle';
import CreateEventTypeForm from '@/components/events/CreateEventTypeForm';
export default {
    name: 'NewEventType',
    components: {
        GeneralLayout,
        NewEventTypeTitle,
        CreateEventTypeForm
    }
};
</script>
<style scoped></style>
