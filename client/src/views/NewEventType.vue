<template>
    <GeneralLayout>
        <NewEventTypeCard/>
        <template v-slot:title>
            <NewEventTypeTitle />
        </template>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import NewEventTypeTitle from '@/components/events/NewEventTypeTitle';
import NewEventTypeCard from '@/components/events/NewEventTypeCard';
export default {
    name: 'NewEventType',
    components: {
        GeneralLayout,
        NewEventTypeTitle,
        NewEventTypeCard
    }
};
</script>
<style scoped>
</style>