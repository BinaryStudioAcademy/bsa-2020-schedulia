<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            {{ lang.INVITEE_EMAILS }}
        </div>
        <VMenu
            v-model="menu"
            max-width="290"
            :close-on-content-click="false"
            :offset-y="true"
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
                    <span v-if="!eventEmailsChecked.length">
                        {{ lang.ALL_INVITEE_EMAILS }}
                    </span>
                    <span v-else>
                        {{ eventEmailsChecked.length }}
                        {{ lang.INVITEE_EMAILS }}
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
                                color="#2C2C2C"
                                background-color="rgba(224, 224, 224, 0.3)"
                                label="Search"
                                clearable
                                prepend-inner-icon="mdi-magnify"
                                @input="searchEventEmails"
                            ></VTextField>
                            <VContainer class="filter-form" fluid>
                                <span v-if="this.getEventEmailsFilter.length">
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
                                </span>
                                <div class="filter-form__checkbox">
                                    <div
                                        v-for="(checkbox, index) in checkboxes"
                                        :key="index"
                                    >
                                        <VCheckbox
                                            hide-details
                                            :label="checkbox.name"
                                            :input-value="
                                                eventEmails.includes(
                                                    checkbox.name
                                                )
                                            "
                                            @change="
                                                onChangeType(checkbox.name)
                                            "
                                        ></VCheckbox>
                                    </div>
                                    <VBtn
                                        :ripple="false"
                                        :hover="false"
                                        class="filter-form__button more"
                                        text
                                        v-if="
                                            !moreEventEmails &&
                                                this.getEventEmailsFilter
                                                    .length >
                                                    countShowEventEmails
                                        "
                                        @click="showMoreEventEmails"
                                    >
                                        {{ lang.SHOW_MORE }}
                                    </VBtn>
                                    <div
                                        class="no-items"
                                        v-if="!this.getEventEmailsFilter.length"
                                    >
                                        {{ lang.NO_ITEMS_FOUND }}
                                    </div>
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
import * as scheduledEventGetters from '@/store/modules/scheduledEvent/types/getters';

export default {
    name: 'InviteeEmails',

    data() {
        return {
            countShowEventEmails: 12,
            menu: false,
            eventEmails: [],
            moreEventEmails: false,
            eventEmailsChecked: [],
            endDate: new Date().toLocaleDateString()
        };
    },

    watch: {
        $route: 'setEmailsFilter'
    },

    async mounted() {
        try {
            await this.setEmailsFilter();
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),

        ...mapGetters('scheduledEvent', {
            getEventEmailsFilter: scheduledEventGetters.GET_EVENT_EMAILS_FILTER
        }),

        checkboxes() {
            if (!Array.isArray(this.getEventEmailsFilter)) {
                return [];
            }

            if (this.moreEventEmails) {
                return this.getEventEmailsFilter;
            } else {
                return this.getEventEmailsFilter.slice(
                    0,
                    this.countShowEventEmails
                );
            }
        }
    },

    methods: {
        ...mapActions('scheduledEvent', {
            setScheduledEvents: scheduledEventActions.SET_SCHEDULED_EVENTS,
            setEventEmailsFilter:
                scheduledEventActions.FETCH_EVENT_EMAILS_FILTER
        }),

        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),

        async setEmailsFilter() {
            if (this.$route.query.event_emails) {
                this.eventEmails = this.arrayToInt(
                    this.$route.query.event_emails
                );
            } else {
                this.eventEmails = [];
            }

            this.eventEmailsChecked = this.eventEmails;

            await this.setEventEmailsFilter({
                endDate: this.endDate
            });
        },

        closeMenu() {
            this.menu = false;
        },

        showMoreEventEmails() {
            this.moreEventEmails = true;
        },

        selectAll() {
            let eventEmails = [];

            this.checkboxes.forEach(function(scheduledEventsEmail) {
                eventEmails.push(scheduledEventsEmail.name);
            });

            this.eventEmails = eventEmails;
        },

        clearSelectAll() {
            this.eventEmails = [];
        },

        clearChecked() {
            this.eventEmails = [];
            this.eventEmailsChecked = [];
        },

        searchEventEmails(searchString) {
            this.clearSelectAll();
            this.setEventEmailsFilter({
                endDate: this.endDate,
                searchString: searchString
            });
        },

        filterScheduledEvent() {
            this.eventEmailsChecked = this.eventEmails;
            this.$router.push({
                name: 'Past',
                query: {
                    event_types: this.$route.query.event_types,
                    event_emails: this.eventEmails,
                    event_status: this.$route.query.event_status,
                    tags: this.$route.query.tags
                }
            });
            this.closeMenu();
        },

        onChangeType(name) {
            if (this.eventEmails.includes(name)) {
                this.eventEmails = this.eventEmails.filter(
                    eventEmails => eventEmails !== name
                );
            } else {
                this.eventEmails = this.eventEmails.concat(name);
            }
        },

        arrayToInt(arr) {
            return arr.map(function(item) {
                let number = parseInt(item);
                return isNaN(number) ? item : number;
            });
        }
    }
};
</script>

<style scoped>
.no-items {
    color: #2c2c2c;
    font-weight: 500;
    font-size: 13px;
    line-height: 16px;
}
</style>
