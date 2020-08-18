<template>
    <div class="event">
        <VContainer class="event-date">
            <span>{{ scheduledEvent.date }}</span>
        </VContainer>
        <VExpansionPanels flat tile accordion>
            <VExpansionPanel>
                <VExpansionPanelHeader class="event-time-name">
                    <VRow class="mb-12">
                        <VCol sm="3" class="text-left">
                            <img
                                class=""
                                :src="
                                    require('@/assets/images/blue_circle.svg')
                                "
                            />
                            <span class="time">
                                {{ scheduledEvent.time }}
                            </span>
                        </VCol>
                        <VCol>
                            <div class="user-name">
                                {{ scheduledEvent.name }}
                            </div>
                            <div class="event-type">
                                {{ lang.EVENT_TYPE }}
                                <span>
                                    {{ scheduledEvent.type }}
                                </span>
                            </div>
                        </VCol>
                    </VRow>
                </VExpansionPanelHeader>

                <BorderBottom />

                <VExpansionPanelContent>
                    <VRow class="event-detail mb-12">
                        <VCol sm="3" class="text-left action-col">
                            <VBtn
                                :ripple="false"
                                :hover="false"
                                class="action-col__button"
                                text
                            >
                                <VIcon>mdi-pencil-outline</VIcon>
                                {{ lang.EDIT }}
                            </VBtn>

                            <VBtn
                                :ripple="false"
                                :hover="false"
                                class="action-col__button"
                                text
                            >
                                <VIcon>mdi-filter-outline</VIcon>
                                {{ lang.FILTER }}
                            </VBtn>

                            <VBtn
                                :ripple="false"
                                :hover="false"
                                class="action-col__button"
                                text
                            >
                                <VIcon>mdi-refresh</VIcon>
                                {{ lang.INVITE_AGAIN }}
                            </VBtn>
                        </VCol>
                        <VCol class="info-col">
                            <ul>
                                <li>
                                    {{ lang.EMAIL }}
                                    <span>
                                        {{ scheduledEvent.email }}
                                    </span>
                                </li>
                                <li>
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
                                        {{ scheduledEvent.questions }}
                                    </span>
                                </li>
                                <li class="created">
                                    {{ lang.CREATED }}
                                    {{ scheduledEvent.created_at }}
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
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'Event',

    data: () => ({
        lang: enLang
    }),

    components: {
        BorderBottom
    },

    props: {
        scheduledEvent: {
            type: Object,
            required: true
        }
    }
};
</script>

<style lang="scss" scoped>
.event {
    .mb-12::v-deep {
        margin: 0 !important;
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
                    font-family: Inter;
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
