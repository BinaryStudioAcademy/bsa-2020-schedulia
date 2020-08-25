<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            {{ lang.EVENT_TYPES }}
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
                        {{ lang.ALL_EVENT_TYPES }}
                    </span>
                    <span v-else>
                        {{ scheduledEventFilter.eventTypes.length }}
                        {{ lang.EVENT_TYPES }}
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
                                    {{ lang.SELECT_ALL }}
                                </VBtn>
                                \
                                <VBtn
                                    :ripple="false"
                                    :hover="false"
                                    class="filter-form__button"
                                    text
                                    @click="clearSelectAll"
                                >
                                    {{ lang.CLEAR }}
                                </VBtn>
                                <div class="filter-form__checkbox">
                                    <div
                                        v-for="(checkbox, index) in checkboxes"
                                        :key="index"
                                    >
                                        <VCheckbox
                                            hide-details
                                            :label="checkbox.name"
                                            :input-value="
                                                eventTypes.includes(checkbox.id)
                                            "
                                            @change="onChangeType(checkbox.id)"
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
                                        {{ lang.SHOW_MORE }}
                                    </VBtn>
                                </div>
                            </VContainer>
                            <VContainer class="filter-button">
                                <VBtn
                                    @click="closeMenu"
                                    class="cancel-button"
                                    outlined
                                >
                                    {{ lang.CANCEL }}
                                </VBtn>
                                <VBtn
                                    class="apply-button primary"
                                    @click="filterScheduledEvent"
                                >
                                    {{ lang.APPLY }}
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
import * as i18nGetters from '@/store/modules/i18n/types/getters';

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
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('scheduledEvent', {
            filterScheduledEventsTypes: GET_FILTER_SCHEDULED_EVENTS_TYPES
        }),

        checkboxes() {
            if (!Array.isArray(this.filterScheduledEventsTypes)) {
                return [];
            }

            if (this.moreEventTypes) {
                return this.filterScheduledEventsTypes;
            } else {
                return this.filterScheduledEventsTypes.slice(0, 6);
            }
        }
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

        selectAll() {
            let eventTypes = [];

            this.checkboxes.forEach(function(scheduledEventsType) {
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
            this.setScheduledEvents(this.scheduledEventFilter.eventTypes);
            this.closeMenu();
        },

        onChangeType(id) {
            if (this.eventTypes.includes(id)) {
                this.eventTypes = this.eventTypes.filter(
                    eventType => eventType !== id
                );
            } else {
                this.eventTypes = this.eventTypes.concat(id);
            }
        }
    }
};
</script>
