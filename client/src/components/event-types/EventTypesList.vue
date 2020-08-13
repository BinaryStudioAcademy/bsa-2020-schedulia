<template>
    <VContainer class="container-content background-none">
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
                class="col-md-3 col-lg-3 col-sm-12"
                v-for="eventType in eventTypes"
                :key="eventType.id"
            >
                <EventType :eventType="eventType" />
            </div>
        </div>
    </VContainer>
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
                invitee: true,
                disabled: true
            },
            {
                id: 3,
                name: 'Event Type Name 3',
                color: 'orange',
                duration: 54,
                invitee: true,
                disabled: false
            },
            {
                id: 4,
                name: 'Event Type Name 4',
                color: 'indigo',
                duration: 54,
                disabled: true
            },
            {
                id: 5,
                name: 'Event Type Name 5',
                color: 'pink',
                duration: 54,
                invitee: true,
                disabled: false
            },
            {
                id: 6,
                name: 'Event Type Name 6',
                color: 'red',
                duration: 15,
                disabled: false
            },
            {
                id: 7,
                name: 'Event Type Name 7',
                color: 'yellow',
                duration: 15,
                disabled: false
            },
            {
                id: 8,
                name: 'Event Type Name 8',
                color: 'darkorange',
                duration: 23,
                invitee: true,
                disabled: false
            },
            {
                id: 9,
                name: 'Event Type Name 9',
                color: '#2be8b4',
                duration: 89,
                disabled: false
            }
        ]
    })
};
</script>
