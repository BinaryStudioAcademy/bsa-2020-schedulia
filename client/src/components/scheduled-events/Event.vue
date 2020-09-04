<template>
    <div class="event">
        <VContainer class="event-date">
            <span>
                {{ getEventDate(scheduledEvent.startDate) }}
            </span>
        </VContainer>
        <VExpansionPanels flat tile accordion>
            <VExpansionPanel>
                <VExpansionPanelHeader class="event-time-name">
                    <VRow>
                        <VCol sm="3" class="text-left">
                            <EventTypesColor
                                :color="scheduledEvent.eventType.color"
                            />

                            <span class="time">
                                {{
                                    getDurationTime(
                                        scheduledEvent.startDate,
                                        scheduledEvent.eventType.duration
                                    )
                                }}
                            </span>
                        </VCol>
                        <VCol sm="2">
                            <VChip class="ma-2" :color="statusColor">
                                {{ scheduledEvent.status }}
                            </VChip>
                        </VCol>
                        <VCol>
                            <div class="user-name">
                                {{ scheduledEvent.name }}
                            </div>
                            <div class="event-type">
                                {{ lang.EVENT_TYPE }}
                                <span>
                                    {{ scheduledEvent.eventType.name }}
                                </span>
                            </div>
                        </VCol>
                    </VRow>
                </VExpansionPanelHeader>

                <BorderBottom />

                <VExpansionPanelContent>
                    <VRow class="event-detail">
                        <VCol sm="3" class="text-left action-col">
                            <ConfirmDialog
                                v-if="!isCancelled"
                                :header="lang.CANCELLATION_EVENT"
                                :content="lang.CANCEL_EVENT_TEXT"
                                :buttonText="lang.CANCEL"
                                icon="mdi-table-cancel"
                                @confirm="onCancelHandle"
                            />
                        </VCol>
                        <VCol class="info-col">
                            <ul>
                                <li>
                                    {{ lang.EMAIL }}
                                    <span>
                                        {{ scheduledEvent.email }}
                                    </span>
                                </li>
                                <li v-show="scheduledEvent.location">
                                    {{ lang.LOCATION }}
                                    <span>
                                        {{ scheduledEvent.location }}
                                    </span>
                                </li>
                                <li>
                                    {{ lang.INVITEE_TIME_ZONE }}
                                    <span>
                                        {{ scheduledEvent.timezone }}
                                    </span>
                                </li>
                                <li>
                                    {{ lang.QUESTIONS }}
                                    <span>
                                        {{ scheduledEvent.question }}
                                    </span>
                                </li>
                                <li class="created">
                                    {{ lang.CREATED }}
                                    {{
                                        getDateWithStringMonth(
                                            scheduledEvent.createdAt
                                        )
                                    }}
                                </li>
                            </ul>
                        </VCol>
                    </VRow>
                </VExpansionPanelContent>
            </VExpansionPanel>
        </VExpansionPanels>
        <BorderBottom />
    </div>
</template>

<script>
import BorderBottom from '@/components/common/GeneralLayout/BorderBottom';
import * as actions from '@/store/modules/scheduledEvent/types/actions';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as EventStatus from '@/store/modules/scheduledEvent/types/statuses';
import { mapGetters, mapActions } from 'vuex';
import EventTypesColor from '../common/EventTypesColor/EventTypesColor';
import ConfirmDialog from '@/components/confirm/ConfirmDialog.vue';

export default {
    name: 'Event',

    data: () => ({}),

    components: {
        EventTypesColor,
        BorderBottom,
        ConfirmDialog
    },

    props: {
        scheduledEvent: {
            type: Object,
            required: true
        }
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),

        isCancelled() {
            return (
                this.scheduledEvent.status ===
                EventStatus.EVENT_STATUS_CANCELLED
            );
        },

        statusColor() {
            return this.isCancelled ? 'red' : 'green';
        }
    },

    methods: {
        ...mapActions('scheduledEvent', {
            updateEvent: actions.UPDATE_EVENT
        }),

        getDurationTime(startDate, duration) {
            let timeStart = new Date(startDate);
            let timeEnd = new Date(startDate);
            timeEnd.setMinutes(timeEnd.getMinutes() + duration);

            return (
                timeStart.toLocaleTimeString().slice(0, -6) +
                '-' +
                timeEnd.toLocaleTimeString().slice(0, -6)
            );
        },

        getEventDate(startDate) {
            let dayName = this.getDayName(startDate, this.lang.LOCALIZATION);
            let date = this.getDateWithStringMonth(startDate);

            return dayName + ', ' + date;
        },

        getDayName(dateStr, locale) {
            let date = new Date(dateStr);
            return date.toLocaleDateString(locale, { weekday: 'long' });
        },

        getMonthName(dateStr, locale) {
            let date = new Date(dateStr);
            return date.toLocaleDateString(locale, { month: 'long' });
        },

        getDateWithStringMonth(dateStr) {
            let date = new Date(dateStr);
            let year = date.getFullYear();
            let month = this.getMonthName(date, this.lang.LOCALIZATION);
            let day = date
                .getDate()
                .toString()
                .padStart(2, '0');

            return day + ' ' + month + ' ' + year;
        },

        async onCancelHandle() {
            const updatedEvent = {
                ...this.scheduledEvent,
                status: EventStatus.EVENT_STATUS_CANCELLED
            };
            await this.updateEvent(updatedEvent);
        }
    }
};
</script>

<style lang="scss" scoped>
.event {
    .row::v-deep {
        margin: 0;
    }

    .col-sm-3 {
        max-width: 20%;
        min-width: 215px;
    }

    .event-date {
        padding: 20px 55px;
        background-color: rgb(224, 224, 224, 0.2);

        span::v-deep {
            font-style: normal;
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            letter-spacing: 0.25px;
            color: #2c2c2c;
            text-transform: capitalize;
        }
    }

    .v-expansion-panel-header::v-deep {
        padding: 11px 55px;
    }

    .v-expansion-panel-content::v-deep {
        padding: 23px 55px;

        .v-expansion-panel-content__wrap {
            padding: 0;
        }
    }

    .event-time-name {
        .col {
            padding: 0;
        }

        .v-expansion-panel-header {
            padding: 0;
            height: 110px;
        }

        .time {
            display: inline-block;
            margin-left: 10px;
            line-height: 44px;
            height: 44px;
            vertical-align: top;
            font-weight: 500;
            font-size: 13px;
            color: #2c2c2c;
        }
    }

    .user-name {
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        letter-spacing: 0.25px;
        color: #2c2c2c;
    }

    .event-type {
        margin-top: 15px;
        font-weight: 600;
        font-size: 14px;
        line-height: 20px;
        letter-spacing: 0.25px;
        text-transform: capitalize;
        color: #989898;

        span {
            color: #2c2c2c;
            font-weight: normal;
        }
    }

    .event-detail {
        margin-bottom: 0px !important;

        .col {
            padding: 0;
        }

        .action-col {
            &__button::v-deep {
                margin-bottom: 5px;
                padding: 0px 2px;
                display: block;

                span.v-btn__content {
                    font-family: $body-font-family;
                    font-style: normal;
                    font-size: 13px;
                    line-height: 16px;
                    text-transform: none;
                }
            }

            &__button i {
                padding-right: 10px;
                color: var(--v-primary-base);
            }

            &__button::v-deep:before {
                background-color: transparent;
            }

            &__button::v-deep:hover,
            &__button::v-deep[aria-expanded='true'] {
                span.v-btn__content {
                    opacity: 0.9;
                }
            }
        }

        .info-col {
            ul {
                padding: 0;
            }

            li {
                margin-bottom: 24px;
                list-style: none;
                font-style: normal;
                font-weight: 600;
                font-size: 14px;
                line-height: 20px;
                letter-spacing: 0.25px;
                text-transform: capitalize;
                color: #989898;

                span {
                    display: block;
                    color: #2c2c2c;
                    font-size: 16px;
                }
            }

            .created {
                margin-bottom: 0;
                font-weight: normal;
                font-size: 9px;
                line-height: 16px;
                letter-spacing: 0.4px;
                color: #2c2c2c;
            }
        }
    }
}
</style>
