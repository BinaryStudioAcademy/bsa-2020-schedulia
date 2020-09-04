<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            {{ lang.STATUS }}
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
                    {{ statusFilterTitle() }}
                    <VIcon>mdi-chevron-down</VIcon>
                </VBtn>
            </template>

            <VCard class="status-filter">
                <VList>
                    <VListItem>
                        <VListItemContent>
                            <VContainer fluid>
                                <div
                                    v-for="(checkbox, index) in checkboxes"
                                    :key="index"
                                >
                                    <VCheckbox
                                        hide-details
                                        :label="checkbox.name"
                                        :input-value="
                                            eventStatus.includes(checkbox.id)
                                        "
                                        @change="onChangeStatus(checkbox.id)"
                                    ></VCheckbox>
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

export default {
    name: 'Status',

    data() {
        return {
            menu: false,
            eventStatus: [],
            eventStatusChecked: [],
            getEventStatus: []
        };
    },

    watch: {
        $route: 'setEventStatusFilter'
    },

    async mounted() {
        try {
            await this.setEventStatusFilter();
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),

        checkboxes() {
            if (!Array.isArray(this.getEventStatus)) {
                return [];
            } else {
                return this.getEventStatus;
            }
        }
    },

    methods: {
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),

        closeMenu() {
            this.menu = false;
        },

        async setEventStatusFilter() {
            if (this.$route.query.event_status) {
                this.eventStatus = this.$route.query.event_status;
            } else {
                this.eventStatus = [];
            }

            this.eventStatusChecked = this.eventStatus;

            this.setEventStatus();
        },

        setEventStatus() {
            this.getEventStatus = [
                {
                    id: 'scheduled',
                    name: this.lang.ACTIVE_EVENTS
                },
                {
                    id: 'cancelled',
                    name: this.lang.CANCELED_EVENTS
                }
            ];
        },

        filterScheduledEvent() {
            this.eventStatusChecked = this.eventStatus;
            this.$router.push({
                name: 'DateRange',
                query: {
                    event_types: this.$route.query.event_types,
                    event_emails: this.$route.query.event_emails,
                    event_status: this.eventStatus,
                    tags: this.$route.query.tags,
                    search: this.$route.query.search,
                    startDate: this.$route.query.start_date,
                    endDate: this.$route.query.end_date
                }
            });
            this.closeMenu();
        },

        statusFilterTitle() {
            if (
                this.eventStatusChecked.includes('scheduled') &&
                this.eventStatusChecked.includes('cancelled')
            ) {
                return this.lang.ALL_EVENTS;
            } else if (this.eventStatusChecked.includes('scheduled')) {
                return this.lang.ACTIVE_EVENTS;
            } else if (this.eventStatusChecked.includes('cancelled')) {
                return this.lang.CANCELED_EVENTS;
            } else {
                return this.lang.ALL_EVENTS;
            }
        },

        onChangeStatus(id) {
            if (this.eventStatus.includes(id)) {
                this.eventStatus = this.eventStatus.filter(
                    eventStatus => eventStatus !== id
                );
            } else {
                this.eventStatus = this.eventStatus.concat(id);
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.status-filter {
    .v-list-item__content::v-deep {
        padding-top: 0;
    }

    .container.container--fluid::v-deep {
        padding-top: 0;
    }
}
</style>
