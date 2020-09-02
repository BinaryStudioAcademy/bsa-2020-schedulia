<template>
    <VDialog v-model="visible" width="380" persistent>
        <VCard class="day-availabilities">
            <VCard>
                <VRow justify="center">
                    <VCardTitle class="headline">
                        {{ lang.EDIT_AVAILABILITY }}
                    </VCardTitle>
                    <VCol cols="9">
                        <VRow v-if="!isUnavailable" align="baseline">
                            <VRow>
                                <VCol>
                                    <label class="availability-label">
                                        {{ lang.FROM }}
                                    </label>
                                </VCol>
                                <VCol>
                                    <label class="availability-label">
                                        {{ lang.TO }}
                                    </label>
                                </VCol>
                            </VRow>
                            <VRow
                                v-for="(availability,
                                index) in dayAvailabilitiesData"
                                :key="index"
                            >
                                <TimeIntervalMenu
                                    :index="index"
                                    :availability="availability"
                                >
                                </TimeIntervalMenu>
                            </VRow>
                        </VRow>
                        <VRow v-else class="unavailable">
                            <span>{{ lang.UNAVAILABLE }}</span>
                        </VRow>
                    </VCol>
                    <VCol>
                        <VCol>
                            <div class="new-interval" @click="addNewInterval">
                                + {{ lang.NEW_INTERVAL }}
                            </div>
                        </VCol>
                    </VCol>
                </VRow>
                <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn color="primary" text @click="apply">
                        {{ lang.APPLY }}
                    </VBtn>
                    <VBtn color="primary" text @click="cancel">
                        {{ lang.CANCEL }}
                    </VBtn>
                </VCardActions>
            </VCard>
        </VCard>
    </VDialog>
</template>

<script>
import { mapGetters } from 'vuex';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import eventTypeMixin from '@/components/events/eventTypeMixin';
import TimeIntervalMenu from '@/components/events/TimeIntervalMenu';

export default {
    name: 'DayAvailabilitiesDialog',
    components: { TimeIntervalMenu },
    mixins: [eventTypeMixin],
    data() {
        return {
            exampleAvailability: {
                type: 'exact_date',
                startDate: '',
                endDate: '',
                startTime: '',
                endTime: ''
            },
            form: []
        };
    },

    methods: {
        addNewInterval() {
            this.setPropertyData('dayAvailabilities', [
                ...this.dayAvailabilitiesData,
                ...[{ ...this.exampleAvailability }]
            ]);
        },
        cancel() {
            this.setPropertyData('visibleDayAvailabilitiesDialog', false);
        },
        apply() {
            let result = {};
            result[this.data.selectDay.date] = this.dayAvailabilitiesData;
            this.changeEventTypeProperty('availabilities', {
                ...this.data.availabilities,
                ...result
            });
            this.setPropertyData('visibleDayAvailabilitiesDialog', false);
        }
    },
    computed: {
        ...mapGetters('eventType', {
            dayAvailabilities: eventTypeGetters.GET_DAY_AVAILABILITIES,
            visibleDayAvailabilitiesDialog:
                eventTypeGetters.GET_VISIBLE_DAY_AVAILABILITIES_DIALOG
        }),
        dayAvailabilitiesData() {
            return this.dayAvailabilities;
        },
        isUnavailable() {
            let result = false;
            if (
                this.dayAvailabilitiesData[0] &&
                this.dayAvailabilitiesData[0]['type']
            ) {
                result =
                    this.dayAvailabilitiesData[0]['type'] === 'unavailable';
            }
            return result;
        },
        visible() {
            return this.visibleDayAvailabilitiesDialog;
        }
    }
};
</script>
<style lang="scss" scoped>
.day-availabilities {
    .unavailable {
        box-sizing: border-box;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 46px;
        border: 1px dashed #d0d0d0;
        span {
            color: #a8a8a8;
            font-size: 16px;
        }
    }
    .new-interval {
        background: none;
        padding: 5px 10px;
        border-radius: 3px;
        border: 1px solid #281ac8;
        color: #281ac8;
        width: 42%;
    }
}
::v-deep .v-dialog {
    overflow-x: hidden;
}
</style>
