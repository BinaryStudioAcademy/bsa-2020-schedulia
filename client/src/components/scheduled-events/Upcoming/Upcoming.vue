<template>
    <div>
        <BorderBottom />
        <div v-if="scheduledEvents">
            <template v-for="scheduledEvent in scheduledEvents">
                <Event
                    :key="scheduledEvent.id"
                    :scheduledEvent="scheduledEvent"
                />
            </template>
        </div>
        <NoEvents v-else>{{ lang.NO_UPCOMING_EVENTS }}</NoEvents>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import * as scheduledEventGetters from '@/store/modules/scheduledEvent/types/getters';
import * as scheduledEventActions from '@/store/modules/scheduledEvent/types/actions';
import BorderBottom from '../../common/GeneralLayout/BorderBottom';
import Event from '../Event';
import NoEvents from '../NoEvents';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'Upcoming',

    data: () => ({
        page: 1,
        sort: 'start_date',
        direction: 'asc',
        startDate: new Date().toLocaleDateString()
    }),

    components: {
        NoEvents,
        Event,
        BorderBottom
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
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
            await this.setScheduledEvents({
                page: 1,
                sort: this.sort,
                direction: this.direction,
                startDate: this.startDate
            });
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    }
};
</script>

<style scoped></style>
