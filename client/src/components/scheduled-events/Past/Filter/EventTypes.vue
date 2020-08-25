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
                                v-model="searchString"
                                color="#2C2C2C"
                                background-color="rgba(224, 224, 224, 0.3)"
                                label="Search"
                                clearable
                                prepend-inner-icon="mdi-magnify"
                                @input="searchEventTypes(searchString)"
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
                                        v-if="!moreEventTypes && this.getEventTypes.length > 6"
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
import * as scheduledEventActions from '@/store/modules/scheduledEvent/types/actions';
import * as notificationActions from '@/store/modules/notification/types/actions';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as eventTypesActions from '@/store/modules/eventTypes/types/actions';
import * as eventTypesGetters from '@/store/modules/eventTypes/types/getters';

export default {
    name: 'EventTypes',

    data() {
        return {
            menu: false,
            searchString: '',
            eventTypes: [],
            moreEventTypes: false,
            scheduledEventFilter: {
                eventTypes: []
            }
        };
    },

    async created() {
        try {
            await this.setEventTypes();
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),

        ...mapGetters('eventTypes', {
            getEventTypes: eventTypesGetters.GET_ALL_EVENT_TYPES
        }),

        checkboxes() {
            if (!Array.isArray(this.getEventTypes)) {
                return [];
            }

            if (this.moreEventTypes) {
                return this.getEventTypes;
            } else {
                return this.getEventTypes.slice(0, 6);
            }
        }
    },

    methods: {
        ...mapActions('scheduledEvent', {
            setScheduledEvents: scheduledEventActions.SET_SCHEDULED_EVENTS
        }),

        ...mapActions('eventTypes', {
            setEventTypes: eventTypesActions.FETCH_EVENT_TYPES
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

        searchEventTypes(searchString) {
            this.clearSelectAll();
            this.setEventTypes(searchString);
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
