<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            {{ lang.TAGS }}
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
                    <span v-if="!eventTypesTagsChecked.length">
                        {{ lang.ALL_TAGS }}
                    </span>
                    <span v-else>
                        {{ eventTypesTagsChecked.length }}
                        {{ lang.TAGS }}
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
                                color="var(--v-customDark-base)"
                                background-color="rgba(224, 224, 224, 0.3)"
                                :label="lang.SEARCH"
                                clearable
                                prepend-inner-icon="mdi-magnify"
                                @input="searchEventTypesTags"
                            ></VTextField>
                            <VContainer class="filter-form" fluid>
                                <span v-if="this.getEventTypesTags.length">
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
                                                eventTypesTags.includes(
                                                    checkbox.id
                                                )
                                            "
                                            @change="onChangeType(checkbox.id)"
                                        ></VCheckbox>
                                    </div>
                                    <VBtn
                                        :ripple="false"
                                        :hover="false"
                                        class="filter-form__button more"
                                        text
                                        v-if="
                                            !moreEventTypesTags &&
                                                this.getEventTypesTags.length >
                                                    countShowEventTypesTags
                                        "
                                        @click="showMoreEventTypesTags"
                                    >
                                        {{ lang.SHOW_MORE }}
                                    </VBtn>
                                    <div
                                        class="no-items"
                                        v-if="!this.getEventTypesTags.length"
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
import * as notificationActions from '@/store/modules/notification/types/actions';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as eventTypesActions from '@/store/modules/eventTypes/types/actions';
import * as eventTypesGetters from '@/store/modules/eventTypes/types/getters';

export default {
    name: 'EventTypesTags',

    data() {
        return {
            countShowEventTypesTags: 12,
            menu: false,
            eventTypesTags: [],
            moreEventTypesTags: false,
            eventTypesTagsChecked: [],
            endDate: new Date().toLocaleDateString()
        };
    },

    watch: {
        $route: 'setEventTypesTagsFilter'
    },

    async mounted() {
        try {
            await this.setEventTypesTagsFilter();
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),

        ...mapGetters('eventTypes', {
            getEventTypesTags: eventTypesGetters.GET_ALL_EVENT_TYPES_TAGS
        }),

        checkboxes() {
            if (!Array.isArray(this.getEventTypesTags)) {
                return [];
            }

            if (this.moreEventTypesTags) {
                return this.getEventTypesTags;
            } else {
                return this.getEventTypesTags.slice(
                    0,
                    this.countShowEventTypesTags
                );
            }
        }
    },

    methods: {
        ...mapActions('eventTypes', {
            setEventTypesTags: eventTypesActions.FETCH_EVENT_TYPES_TAGS
        }),

        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),

        async setEventTypesTagsFilter() {
            if (this.$route.query.tags) {
                this.eventTypesTags = this.arrayToInt(this.$route.query.tags);
            } else {
                this.eventTypesTags = [];
            }

            this.eventTypesTagsChecked = this.eventTypesTags;

            await this.setEventTypesTags({
                endDate: this.endDate
            });
        },

        closeMenu() {
            this.menu = false;
        },

        showMoreEventTypesTags() {
            this.moreEventTypesTags = true;
        },

        selectAll() {
            let eventTypesTags = [];

            this.checkboxes.forEach(function(scheduledEventsTypeTags) {
                eventTypesTags.push(scheduledEventsTypeTags.id);
            });

            this.eventTypesTags = eventTypesTags;
        },

        clearSelectAll() {
            this.eventTypesTags = [];
        },

        clearChecked() {
            this.eventTypesTags = [];
            this.eventTypesTagsChecked = [];
        },

        searchEventTypesTags(searchString) {
            this.clearSelectAll();
            this.setEventTypesTags({
                searchString: searchString,
                endDate: this.endDate
            });
        },

        filterScheduledEvent() {
            this.eventTypesTagsChecked = this.eventTypesTags;
            this.$router.push({
                name: 'Past',
                query: {
                    event_types: this.$route.query.event_types,
                    event_emails: this.$route.query.event_emails,
                    event_status: this.$route.query.event_status,
                    tags: this.eventTypesTags,
                    search: this.$route.query.search
                }
            });
            this.closeMenu();
        },

        onChangeType(id) {
            if (this.eventTypesTags.includes(id)) {
                this.eventTypesTags = this.eventTypesTags.filter(
                    eventTypeTags => eventTypeTags !== id
                );
            } else {
                this.eventTypesTags = this.eventTypesTags.concat(id);
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
    color: var(--v-customDark-base);
    font-weight: 500;
    font-size: 13px;
    line-height: 16px;
}
</style>
