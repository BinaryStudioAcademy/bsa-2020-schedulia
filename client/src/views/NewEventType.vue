<template>
    <GeneralLayout>
        <VContainer>
            <VCard class="mt-7">
                <CreateEventTypeTitle></CreateEventTypeTitle>
                <VDivider class="mx-4"></VDivider>
                <VRow>
                    <VCol
                        cols="10"
                        offset-sm="3"
                        offset-md="3"
                        md="6"
                        sm="6"
                        :class="{ 'ml-10': $vuetify.breakpoint.xs }"
                    >
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
import eventTypeMixin from '@/components/events/eventTypeMixin';
import CreateEventTypeTitle from '@/components/events/CreateEventTypeTitle';
export default {
    name: 'NewEventType',
    mixins: [eventTypeMixin],
    components: {
        CreateEventTypeTitle,
        GeneralLayout,
        NewEventTypeTitle,
        CreateEventTypeForm
    }
};
</script>
<style scoped></style>
