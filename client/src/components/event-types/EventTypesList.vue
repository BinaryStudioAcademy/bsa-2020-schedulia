<template>
    <div>
        <div class="row">
            <VCol cols="3" sm="12" md="3" class="pa-0">
                <VTextField
                    type="text"
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    dense
                    filled
                    solo-inverted
                ></VTextField>
            </VCol>
        </div>
        <ActionBlock />
        <VDivider />
        <div class="event-types-block row">
            <div
                class="col-md-3"
                v-for="eventType in eventTypes"
                :key="eventType.id"
            >
                <EventType :eventType="eventType" />
            </div>
        </div>
    </div>
</template>

<script>
import ActionBlock from '@/components/event-types/all-event-types/ActionBlock';
import EventType from '@/components/event-types/all-event-types/EventType';
export default {
    name: 'EventTypesList',
    components: {
        ActionBlock,
        EventType
    },
    data: () => ({
        eventTypes: [
            {
                id: 1,
                name: 'Event Type Name',
                color: 'green',
                duration: 45,
                disabled: false
            },
            {
                id: 2,
                name: 'Event Type Name 2',
                color: 'red',
                duration: 15,
                disabled: true
            }
        ]
    })
};
</script>

<style scoped></style>
