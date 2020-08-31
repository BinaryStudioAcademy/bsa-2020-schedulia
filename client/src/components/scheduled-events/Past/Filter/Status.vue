<template>
    <div class="text-left filter-menu">
        <div class="filter-title">
            {{ lang.STATUS }}
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
                    {{ lang.ACTIVE_EVENTS }}
                    {{ lang.ALL_EVENTS }}
                    {{ lang.CANCELED_EVENTS }}
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
                                            @change="onChangeType(checkbox.id)"
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
                                <VBtn class="apply-button primary">
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
            eventStatus: [0],
            eventStatusChecked: [0],
            getEventStatus: []
        };
    },

    watch: {
        $route: 'setEventStatusFilter'
    },

    created() {
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
                this.eventStatus = this.arrayToInt(
                        this.$route.query.event_status
                );
            } else {
                this.eventStatus = [0];
            }

            this.eventStatusChecked = this.eventStatus;

            this.setEventStatus();
        },

        setEventStatus () {
            this.getEventStatus = [
                {
                    id: 0,
                    name: this.lang.ACTIVE_EVENTS
                },
                {
                    id: 1,
                    name: this.lang.CANCELED_EVENTS
                }
            ];
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
