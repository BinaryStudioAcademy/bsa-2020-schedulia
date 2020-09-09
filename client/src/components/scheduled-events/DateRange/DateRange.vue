<template>
    <div>
        <FilterList v-if="this.scheduledEventsFilterView" />
        <BorderBottom />
        <div v-if="this.eventsPagination.total">
            <VContainer class="date-range">
                {{
                    formatDateRange(
                        $route.query.start_date,
                        $route.query.end_date
                    )
                }}
            </VContainer>
            <template v-for="scheduledEvent in scheduledEvents">
                <Event
                    :key="scheduledEvent.id"
                    :scheduledEvent="scheduledEvent"
                />
            </template>
        </div>
        <NoEvents v-else>{{ lang.NO_DATE_RANGE_EVENTS }}</NoEvents>
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
import moment from 'moment-timezone';

export default {
    name: 'DateRange',

    data: () => ({
        page: 1,
        loadMoreActive: false,
        perPage: 8,
        sort: 'start_date',
        direction: 'asc'
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
                startDate: this.$route.query.start_date,
                endDate: this.getEndDateDateRange(this.$route.query.end_date),
                eventTypes: this.$route.query.event_types,
                eventEmails: this.$route.query.event_emails,
                eventStatus: this.$route.query.event_status,
                tags: this.$route.query.tags,
                searchString: this.$route.query.search
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
                startDate: this.$route.query.start_date,
                endDate: this.getEndDateDateRange(this.$route.query.end_date),
                eventTypes: this.$route.query.event_types,
                eventEmails: this.$route.query.event_emails,
                eventStatus: this.$route.query.event_status,
                tags: this.$route.query.tags,
                searchString: this.$route.query.search
            });

            if (
                this.eventsPagination.currentPage <
                this.eventsPagination.lastPage
            ) {
                this.loadMoreActive = true;
            } else {
                this.loadMoreActive = false;
            }
        },

        getEndDateDateRange(endDate) {
            return moment
                .utc(endDate)
                .add(1, 'day')
                .format('YYYY-MM-DD');
        },

        formatDateRange(startDate, endDate) {
            if (startDate && endDate) {
                let dateStart = new Date(startDate);
                let dateEnd = new Date(endDate);

                let dateStartYear = dateStart.getFullYear();
                let dateEndYear = dateEnd.getFullYear();

                let dateStartMonth = this.getMonthName(
                    dateStart,
                    this.lang.LOCALIZATION
                );
                let dateEndMonth = this.getMonthName(
                    dateEnd,
                    this.lang.LOCALIZATION
                );

                let dateStartDay = dateStart.getDate();
                let dateEndDay = dateEnd.getDate();

                if (dateStartYear === dateEndYear) {
                    return (
                        dateStartMonth +
                        ' ' +
                        dateStartDay +
                        ' - ' +
                        dateEndMonth +
                        ' ' +
                        dateEndDay +
                        ', ' +
                        dateEndYear
                    );
                } else {
                    return (
                        dateStartMonth +
                        ' ' +
                        dateStartDay +
                        ', ' +
                        dateStartYear +
                        ' - ' +
                        dateEndMonth +
                        ' ' +
                        dateEndDay +
                        ', ' +
                        dateEndYear
                    );
                }
            } else {
                return this.lang.TODAY_TO_INFINITY;
            }
        },

        getMonthName(dateStr, locale) {
            let date = new Date(dateStr);
            return date.toLocaleDateString(locale, { month: 'short' });
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

<style scoped>
.date-range {
    font-size: 17px;
    padding: 20px 55px;
    background-color: rgba(224, 224, 224, 0.4);
}
</style>
