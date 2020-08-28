<template>
    <GeneralLayout>
        <VContainer>
            <VCard class="mt-7">
                <FirstTitle></FirstTitle>
                <VDivider class="mx-4"></VDivider>
                <VRow>
                    <VCol cols="6" offset-sm="2" offset-md="2">
                        <CreateEventTypeForm></CreateEventTypeForm>
                    </VCol>
                </VRow>
            </VCard>
        </VContainer>
        <template v-slot:title>
            <NewEventTypeTitle />
        </template>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import NewEventTypeTitle from '@/components/events/NewEventTypeTitle';
import CreateEventTypeForm from '@/components/events/CreateEventTypeForm';
import eventTypeMixin from "@/components/events/eventTypeMixin";
import FirstTitle from "@/components/events/CreateEventTypeTitle";
export default {
    name: 'NewEventType',
    mixins: [eventTypeMixin],
    components: {
        FirstTitle,
        GeneralLayout,
        NewEventTypeTitle,
        CreateEventTypeForm
    }
};
</script>
<style scoped>

</style>
