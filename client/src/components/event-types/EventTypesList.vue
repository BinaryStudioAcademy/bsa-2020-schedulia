<template>
    <VContainer class="background-none">
        <div class="row ma-0">
            <VCol cols="12" sm="12" md="3" class="pa-0">
                <VTextField
                    type="text"
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    dense
                    filled
                    solo-inverted
                    v-model="search"
                ></VTextField>
            </VCol>
        </div>
        <ActionBlock />
        <VDivider />
        <div class="event-types-block row" v-if="searchedEventTypes.length">
            <VCol
                cols="12"
                md="4"
                lg="3"
                sm="6"
                v-for="eventType in searchedEventTypes"
                :key="eventType.id"
            >
                <EventType :eventType="eventType" />
            </VCol>
        </div>
        <NoEventTypes v-else />
    </VContainer>
</template>

<script>
import ActionBlock from '@/components/event-types/all-event-types/ActionBlock';
import EventType from '@/components/event-types/all-event-types/EventType';
import NoEventTypes from '@/components/event-types/all-event-types/NoEventTypes';
import * as actions from '@/store/modules/eventTypes/types/actions';
import * as getters from '@/store/modules/eventTypes/types/getters';
import { mapActions, mapGetters } from 'vuex';
export default {
    name: 'EventTypesList',
    components: {
        ActionBlock,
        EventType,
        NoEventTypes
    },
    data: () => ({
        search: ''
    }),
    methods: {
        ...mapActions('eventTypes', {
            fetchAllEventTypes: actions.FETCH_ALL_EVENT_TYPES
        })
    },
    async mounted() {
        await this.fetchAllEventTypes();
    },
    computed: {
        ...mapGetters('eventTypes', {
            eventTypes: getters.GET_ALL_EVENT_TYPES
        }),
        searchedEventTypes() {
            return this.eventTypes.filter(eventType => {
                return eventType.name
                    .toLowerCase()
                    .startsWith(this.search.toLowerCase());
            });
        }
    }
};
</script>
