<template>
    <div class="event">
        <VContainer class="event-date">
            <span>Friday, 24 July 2020</span>
        </VContainer>
        <VContainer class="event-time-name">
            <VExpansionPanels flat tile accordion>
                <VExpansionPanel>
                    <VExpansionPanelHeader>
                        <VRow class="mb-12 text-left" align-content="top">
                            <VCol sm="2" align-self="center" class="text-left">
                                <img
                                    class=""
                                    :src="
                                        require('@/assets/images/blue_circle.svg')
                                    "
                                />
                                <span class="time">
                                    10:30 - 11:00
                                </span>
                            </VCol>
                            <VCol align-self="center">
                                <div class="user-name">
                                    Jim Halpert
                                </div>
                                <div class="event-type">
                                    Event type
                                    <span>
                                        Sales manager
                                    </span>
                                </div>
                            </VCol>
                        </VRow>
                    </VExpansionPanelHeader>
                    <VExpansionPanelContent>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                        sed do eiusmod tempor incididunt ut labore et dolore
                        magna aliqua. Ut enim ad minim veniam, quis nostrud
                        exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat.
                    </VExpansionPanelContent>
                </VExpansionPanel>
            </VExpansionPanels>
        </VContainer>
    </div>
</template>

<script>
export default {
    name: 'Event'
};
</script>

<style lang="scss" scoped>
.event {
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

    .event-time-name {
        padding: 0 55px;

        .v-expansion-panel-header {
            padding: 0;
            height: 110px;
        }

        .mb-12::v-deep {
            margin: 0 !important;
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
        margin-top: 28px;
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
}
</style>
