<template>
    <div>
        <FilterList v-if="this.scheduledEventsFilterView" />
        <BorderBottom />
        <div v-if="this.eventsPagination.total">
            <template v-for="scheduledEvent in scheduledEvents">
                <Event
                    :key="scheduledEvent.id"
                    :scheduledEvent="scheduledEvent"
                />
            </template>
        </div>
        <NoEvents v-else>{{ lang.NO_PAST_EVENTS }}</NoEvents>
        <div class="text-center" v-show="loadMoreActive">
            <VBtn
                color="primary"
                class="ma-2 white--text"
                rounded
                @click="onLoadMore"
            >
                <VIcon left dark>mdi-plus</VIcon>
                {{ lang.LOAD_MORE }}
            </VBtn>
        </div>
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
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'Past',

    data: () => ({
        page: 1,
        loadMoreActive: false,
        perPage: 8,
        sort: 'start_date',
        direction: 'desc',
        endDate: new Date().toLocaleDateString()
    }),

    components: {
        NoEvents,
        Event,
        BorderBottom,
        FilterList
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('scheduledEvent', {
            scheduledEventsFilterView:
                scheduledEventGetters.GET_SCHEDULED_EVENT_FILTER_VIEW,
            scheduledEvents: scheduledEventGetters.GET_SCHEDULED_EVENTS,
            eventsPagination:
                scheduledEventGetters.GET_SCHEDULED_EVENTS_PAGINATION
        })
    },

    methods: {
        ...mapActions('scheduledEvent', {
            setScheduledEvents: scheduledEventActions.SET_SCHEDULED_EVENTS
        }),

        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),

        async onLoadMore() {
            await this.setScheduledEvents({
                page: this.page + 1,
                sort: this.sort,
                direction: this.direction,
                endDate: this.endDate,
                eventTypes: this.$route.query.event_types,
                eventEmails: this.$route.query.event_emails,
                eventStatus: this.$route.query.event_status,
                tags: this.$route.query.tags
            });

            if (
                this.eventsPagination.currentPage <
                this.eventsPagination.lastPage
            ) {
                this.page += 1;
                this.loadMoreActive = true;
            } else {
                this.loadMoreActive = false;
            }
        },

        async setEvents() {
            await this.setScheduledEvents({
                page: 1,
                sort: this.sort,
                direction: this.direction,
                endDate: this.endDate,
                eventTypes: this.$route.query.event_types,
                eventEmails: this.$route.query.event_emails,
                eventStatus: this.$route.query.event_status,
                tags: this.$route.query.tags
            });

            if (
                this.eventsPagination.currentPage <
                this.eventsPagination.lastPage
            ) {
                this.loadMoreActive = true;
            } else {
                this.loadMoreActive = false;
            }
        }
    },

    watch: {
        $route: 'setEvents'
    },

    async mounted() {
        try {
            await this.setEvents();
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    }
};
</script>

<style scoped></style>
