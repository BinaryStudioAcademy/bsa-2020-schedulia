<template>
    <div>
        <FilterList v-if="this.scheduledEventsFilterView" />
        <BorderBottom />
        <div v-if="scheduledEvents">
            <template v-for="scheduledEvent in scheduledEvents">
                <Event
                    :key="scheduledEvent.id"
                    :scheduledEvent="scheduledEvent"
                />
            </template>
        </div>
        <NoEvents v-else>{{ lang.NO_PAST_EVENTS }}</NoEvents>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import * as scheduledEventGetters from '@/store/modules/scheduledEvent/types/getters';
import * as scheduledEventActions from '@/store/modules/scheduledEvent/types/actions';
import FilterList from './Filter/FilterList';
import BorderBottom from '../../common/GeneralLayout/BorderBottom';
import Event from '../Event';
import NoEvents from '../NoEvents';
import enLang from '@/store/modules/i18n/en.js';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'Past',

    data: () => ({
        lang: enLang
    }),

    components: {
        NoEvents,
        Event,
        BorderBottom,
        FilterList
    },

    computed: {
        ...mapGetters('scheduledEvent', {
            scheduledEventsFilterView:
                scheduledEventGetters.GET_SCHEDULED_EVENT_FILTER_VIEW,
            scheduledEvents: scheduledEventGetters.GET_SCHEDULED_EVENTS
        })
    },

    methods: {
        ...mapActions('scheduledEvent', {
            setScheduledEvents: scheduledEventActions.SET_SCHEDULED_EVENTS
        }),

        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        })
    },

    async created() {
        try {
            await this.setScheduledEvents();
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    }
};
</script>

<style scoped></style>
