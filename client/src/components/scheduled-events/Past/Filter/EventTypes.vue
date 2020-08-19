<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            Event Types
        </div>
        <VMenu
            v-model="menu"
            max-width="290"
            :close-on-content-click="false"
            offset-y
        >
            <template v-slot:activator="{ on, attrs }">
                <VBtn
                    :ripple="false"
                    :hover="false"
                    class="filter-menu__button"
                    text
                    v-bind="attrs"
                    v-on="on"
                >
                    <span v-if="!scheduledEventFilter.eventTypes.length">
                        All Event Types
                    </span>
                    <span v-else>
                        {{ scheduledEventFilter.eventTypes.length }} Event Types
                    </span>
                    <VIcon>mdi-chevron-down</VIcon>
                </VBtn>
            </template>

            <VCard>
                <VList>
                    <VListItem>
                        <VListItemContent>
                            <VTextField
                                solo
                                hide-details
                                dense
                                flat
                                v-model="eventTypesSearch"
                                color="#2C2C2C"
                                background-color="rgba(224, 224, 224, 0.3)"
                                label="Search"
                                clearable
                                prepend-inner-icon="mdi-magnify"
                                @input="searchEventTypes(eventTypesSearch)"
                            ></VTextField>
                            <VContainer class="filter-form" fluid>
                                <VBtn
                                    :ripple="false"
                                    :hover="false"
                                    class="filter-form__button"
                                    text
                                    @click="selectAll"
                                >
                                    select all
                                </VBtn>
                                \
                                <VBtn
                                    :ripple="false"
                                    :hover="false"
                                    class="filter-form__button"
                                    text
                                    @click="clearSelectAll"
                                >
                                    clear
                                </VBtn>
                                <div class="filter-form__checkbox">
                                    <div
                                        v-for="(FilterScheduledEventsType,
                                        index) in FilterScheduledEventsTypes"
                                        :key="eventTypes[index]"
                                    >
                                        <VCheckbox
                                            v-if="index < 5"
                                            hide-details
                                            :label="
                                                FilterScheduledEventsType.name
                                            "
                                            v-model="eventTypes"
                                            :value="
                                                FilterScheduledEventsType.id
                                            "
                                        ></VCheckbox>
                                        <VCheckbox
                                            v-else
                                            v-show="moreEventTypes"
                                            hide-details
                                            :label="
                                                FilterScheduledEventsType.name
                                            "
                                            v-model="eventTypes"
                                            :value="
                                                FilterScheduledEventsType.id
                                            "
                                        ></VCheckbox>
                                    </div>
                                    <VBtn
                                        :ripple="false"
                                        :hover="false"
                                        class="filter-form__button more"
                                        text
                                        v-if="!moreEventTypes"
                                        @click="showMoreEventTypes"
                                    >
                                        Show more
                                    </VBtn>
                                </div>
                            </VContainer>
                            <VContainer class="filter-button">
                                <VBtn
                                    @click="closeMenu"
                                    class="cancel-button"
                                    outlined
                                >
                                    Cancel
                                </VBtn>
                                <VBtn
                                    class="apply-button primary"
                                    @click="filterScheduledEvent"
                                >
                                    Apply
                                </VBtn>
                            </VContainer>
                        </VListItemContent>
                    </VListItem>
                </VList>

                <VDivider></VDivider>
            </VCard>
        </VMenu>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { GET_FILTER_SCHEDULED_EVENTS_TYPES } from '@/store/modules/scheduledEvent/types/getters';
import * as scheduledEventActions from '@/store/modules/scheduledEvent/types/actions';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'EventTypes',

    data() {
        return {
            menu: false,
            eventTypesSearch: '',
            eventTypes: [],
            moreEventTypes: false,
            scheduledEventFilter: {
                eventTypes: []
            }
        };
    },

    async created() {
        try {
            await this.setFilterScheduledEventsTypes();
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    },

    computed: {
        ...mapGetters('scheduledEvent', {
            FilterScheduledEventsTypes: GET_FILTER_SCHEDULED_EVENTS_TYPES
        })
    },

    methods: {
        ...mapActions('scheduledEvent', {
            setFilterScheduledEventsTypes:
                scheduledEventActions.SET_FILTER_SCHEDULED_EVENTS_TYPES,
            setScheduledEvents: scheduledEventActions.SET_SCHEDULED_EVENTS
        }),

        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),

        closeMenu() {
            this.menu = false;
        },

        showMoreEventTypes() {
            this.moreEventTypes = true;
        },

        selectedEventTypes() {
            return this.scheduledEventFilter.eventTypes.length;
        },

        selectAll() {
            let eventTypes = [];

            this.showMoreEventTypes();

            this.FilterScheduledEventsTypes.forEach(function(
                scheduledEventsType
            ) {
                eventTypes.push(scheduledEventsType.id);
            });

            this.eventTypes = eventTypes;
        },

        clearSelectAll() {
            this.eventTypes = [];
        },

        searchEventTypes(eventTypesSearch) {
            this.clearSelectAll();

            this.setFilterScheduledEventsTypes(eventTypesSearch);
        },

        filterScheduledEvent() {
            this.scheduledEventFilter.eventTypes = this.eventTypes;
            this.setScheduledEvents(this.scheduledEventFilter);
            this.closeMenu();
        }
    }
};
</script>
