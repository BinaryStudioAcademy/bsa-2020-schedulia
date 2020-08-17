<template>
    <div>
        <FilterList v-if="this.eventFilterView" />
        <BorderBottom />
        <div v-if="events">
            <template v-for="event in events">
                <Event :key="event.id" :event="event" />
            </template>
        </div>
        <NoEvents v-else>No Past Events</NoEvents>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import * as eventScheduledGetters from '@/store/modules/eventScheduled/types/getters';
import * as eventScheduledActions from '@/store/modules/eventScheduled/types/actions';
import FilterList from './Filter/FilterList';
import BorderBottom from '../../common/GeneralLayout/BorderBottom';
import Event from '../ScheduledEvents/Event';
import NoEvents from '../NoEvents';

export default {
    name: 'Past',

    components: {
        NoEvents,
        Event,
        BorderBottom,
        FilterList
    },

    computed: {
        ...mapGetters('eventScheduled', {
            eventFilterView: eventScheduledGetters.GET_EVENT_FILTER_VIEW,
            events: eventScheduledGetters.GET_SCHEDULED_EVENTS
        })
    },

    methods: {
        ...mapActions('eventScheduled', {
            setScheduledEvents: eventScheduledActions.SET_SCHEDULED_EVENTS
        })
    },

    async created() {
        try {
            await this.setScheduledEvents();
        } catch (error) {
            console.error(error.message);
        }
    }
};
</script>

<style scoped></style>
