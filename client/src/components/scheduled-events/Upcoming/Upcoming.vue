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
        <NoEvents v-else>{{ lang.NO_UPCOMING_EVENTS }}</NoEvents>
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
import BorderBottom from '../../common/GeneralLayout/BorderBottom';
import Event from '../Event';
import NoEvents from '../NoEvents';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as notificationActions from '@/store/modules/notification/types/actions';
import FilterList from './Filter/FilterList';

export default {
    name: 'Upcoming',

    data: () => ({
        page: 1,
        loadMoreActive: false,
        perPage: 8,
        sort: 'start_date',
        direction: 'asc',
        startDate: new Date().toString()
    }),

    components: {
        FilterList,
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
                startDate: this.startDate
            });

            if (
                this.eventsPagination.currentPage <
                this.eventsPagination.lastPage
            ) {
                this.page += 1;
            } else {
                this.loadMoreActive = false;
            }
        }
    },

    async mounted() {
        try {
            await this.setScheduledEvents({
                page: 1,
                sort: this.sort,
                direction: this.direction,
                startDate: this.startDate
            });

            if (
                this.eventsPagination.currentPage <
                this.eventsPagination.lastPage
            ) {
                this.loadMoreActive = true;
            }
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    }
};
</script>

<style scoped></style>
