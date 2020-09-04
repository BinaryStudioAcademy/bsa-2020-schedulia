<template>
    <VDialog v-model="visible" width="380" persistent>
        <VTabs
            v-model="tab"
            background-color="deep-purple accent-4"
            class="day-availabilities"
            dark
        >
            <VTabsSlider></VTabsSlider>
            <VTabItem value="tab-edit-availability">
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
                        <VRow class="button-wrapper">
                            <VCol class="new-interval-wrapper">
                                <div
                                    class="new-interval"
                                    @click="addNewInterval"
                                >
                                    + {{ lang.NEW_INTERVAL }}
                                </div>
                            </VCol>
                            <VCol class="button-unavailablev">
                                <div
                                    class="button-unavailable"
                                    @click="addUnavailable"
                                >
                                    {{ lang.I_AM_UNAVAILABLE }}
                                </div>
                            </VCol>
                            <VCol class="apply-wrapper">
                                <VBtn
                                    color="primary"
                                    text
                                    @click="applyDay"
                                    class="button-apply-only"
                                >
                                    {{ nameApplyButton }}
                                </VBtn>
                            </VCol>
                            <VCol class="apply-week-wrapper">
                                <VBtn
                                    color="primary"
                                    text
                                    @click="applyDayWeek"
                                    class="button-apply-week"
                                >
                                    {{ nameApplyWeekDayButton }}
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VRow>
                    <VCardActions class="action-button">
                        <VBtn
                            color="primary"
                            text
                            @click="applyOrMultiple"
                            class="button-apply-multiple"
                        >
                            {{ lang.OR_APPLY_MULTIPLE }}
                        </VBtn>
                        <VBtn
                            color="primary"
                            text
                            @click="cancel"
                            class="button-cancel"
                        >
                            {{ lang.CANCEL }}
                        </VBtn>
                    </VCardActions>
                </VCard>
            </VTabItem>
            <VTabItem value="tab-multiple">
                <VCard>
                    <VRow justify="center">
                        <VIcon @click="tab = 'tab-edit-availability'"
                            >mdi-arrow-left</VIcon
                        >
                        <VCardTitle class="headline">
                            {{ lang.APPLY_MULTIPLE }}
                        </VCardTitle>
                    </VRow>
                    <VRow class="radio-group-wrapper">
                        <VRadioGroup :value="radio" @change="changeRadio">
                            <VRadio
                                :label="lang.SPECIFIC_DATES"
                                value="specific-dates"
                            ></VRadio>
                            <VRadio
                                :label="lang.REPEATING_DAYS"
                                value="repeat-days"
                            ></VRadio>
                        </VRadioGroup>
                    </VRow>
                    <VRow v-if="radio === 'specific-dates'" class="date-picker">
                        <VDatePicker
                            :allowed-dates="allowedDates"
                            :value="dates"
                            @input="changeSelectDate"
                            multiple
                            no-title
                            scrollable
                        >
                        </VDatePicker>
                    </VRow>
                    <VRow v-else class="checkbox-weekdays">
                        <VCheckbox
                            v-for="(day, id) in weekdays"
                            :key="id"
                            @change="changeWeekDays(day)"
                            :value="day"
                            :disabled="day === weekDayName"
                            :input-value="selectedWeekDays"
                            :label="day"
                        >
                        </VCheckbox>
                    </VRow>
                    <VCardActions class="action-button-multiple">
                        <VBtn
                            color="primary"
                            text
                            @click="applyMultiple"
                            class="button-apply"
                        >
                            {{ lang.APPLY }}
                        </VBtn>
                        <VBtn
                            color="primary"
                            text
                            @click="cancel"
                            class="button-cancel"
                        >
                            {{ lang.CANCEL }}
                        </VBtn>
                    </VCardActions>
                </VCard>
            </VTabItem>
        </VTabs>
    </VDialog>
</template>

<script>
import { mapGetters } from 'vuex';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import eventTypeMixin from '@/components/events/eventTypeMixin';
import TimeIntervalMenu from '@/components/events/TimeIntervalMenu';
import moment from 'moment';
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
            form: [],
            tab: 'tab-edit-availability',
            radio: 'repeat-days',
            weekdays: moment.weekdays(),
            dates: [],
            selectedWeekDays: []
        };
    },

    methods: {
        addNewInterval() {
            if (
                this.dayAvailabilitiesData.length === 1 &&
                this.dayAvailabilitiesData[0]['type'] === 'unavailable'
            ) {
                this.setPropertyData('dayAvailabilities', [
                    { ...this.exampleAvailability }
                ]);
            } else {
                this.setPropertyData('dayAvailabilities', [
                    ...this.dayAvailabilitiesData,
                    ...[{ ...this.exampleAvailability }]
                ]);
            }
        },
        addUnavailable() {
            let params = {
                type: 'unavailable',
                startDate: this.dayAvailabilitiesData[0]['startDate'],
                endDate: this.dayAvailabilitiesData[0]['endDate']
            };
            this.setPropertyData('dayAvailabilities', [params]);
        },
        applyDayWeek() {
            let params = {
                ...this.data.availabilities_week_days
            };
            let weekDayName = this.weekDayName.toLowerCase();
            params[weekDayName] = this.dayAvailabilitiesData.map(function(
                availability
            ) {
                availability.type = `every_${weekDayName}`;
                return availability;
            });
            this.changeEventTypeProperty('availabilities_week_days', {
                ...params
            });
            this.cancel();
        },
        applyOrMultiple() {
            this.tab = 'tab-multiple';
            this.selectedWeekDays.push(this.weekDayName);
            this.dates.push(this.data.selectDay.date);
        },
        applyMultiple() {
            if (this.radio === 'repeat-days') {
                let params = {
                    ...this.data.availabilities_week_days
                };

                for (let index in this.selectedWeekDays) {
                    let weekDay = this.selectedWeekDays[index].toLowerCase();
                    params[weekDay] = this.dayAvailabilitiesData.map(function(
                        availability
                    ) {
                        availability.type = `every_${weekDay}`;
                        return availability;
                    });
                }
                this.changeEventTypeProperty('availabilities_week_days', {
                    ...params
                });
                this.cancel();
            } else {
                let result = {};
                for (let index in this.dates) {
                    result[this.dates[index]] = this.dayAvailabilitiesData;
                }
                this.changeEventTypeProperty('availabilities', {
                    ...this.data.availabilities,
                    ...result
                });
                this.cancel();
            }
        },
        cancel() {
            this.setPropertyData('visibleDayAvailabilitiesDialog', false);
            this.tab = 'tab-edit-availability';
            this.selectedWeekDays = [];
            this.dates = [];
        },
        applyDay() {
            let result = {};
            result[this.data.selectDay.date] = this.dayAvailabilitiesData;
            this.changeEventTypeProperty('availabilities', {
                ...this.data.availabilities,
                ...result
            });
            this.cancel();
        },
        allowedDates(value) {
            let result = true;
            if (this.dayAvailabilities && this.dayAvailabilities[0]) {
                result =
                    moment(value) >=
                    moment(
                        moment(this.data.dateRange.startDate).format(
                            'YYYY-MM-DD'
                        )
                    );
            }

            return result;
        },
        changeRadio(value) {
            this.radio = value;
        },
        changeWeekDays(value) {
            if (this.selectedWeekDays.includes(value)) {
                let id = this.selectedWeekDays.indexOf(value);
                this.selectedWeekDays.splice(id, 1);
            } else {
                this.selectedWeekDays.push(value);
            }
        },
        changeSelectDate(value) {
            this.dates = value;
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
        },
        monthName() {
            return moment(this.data.selectDay.date).format('MMM');
        },
        weekDayName() {
            return moment(this.data.selectDay.date).format('dddd');
        },
        nameApplyButton() {
            return this.lang.APPLY_ONLY.replace(
                '_',
                `${this.monthName} ${this.data.selectDay.day}`
            );
        },
        nameApplyWeekDayButton() {
            return this.lang.APPLY_TO_ALL + this.weekDayName;
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
        color: #281ac8;
        width: 42%;
    }

    .button-unavailable {
        background: none;
        padding: 5px 10px;
        border-radius: 3px;
        border: 1px solid #281ac8;
        color: #281ac8;
        width: 42%;
    }

    .apply-wrapper,
    .apply-week-wrapper {
        display: flex;
        justify-content: center;
        .button-apply-only,
        .button-apply-week {
            text-transform: none;
        }
    }

    .button-wrapper {
        display: block;
        .new-interval-wrapper,
        .button-unavailablev {
            padding: 0 0 0 45px;
        }
    }

    .action-button {
        .button-apply-only,
        .button-apply-multiple,
        .button-cancel {
            text-transform: none;
        }
        .button-apply-multiple {
            padding: 0 95px 0 15px;
        }
        .button-cancel {
            .v-btn__content {
                color: #666a73;
            }
        }
    }

    .radio-group-wrapper,
    .date-picker {
        display: flex;
        justify-content: center;
        .v-input {
            padding: 30px 30px 10px 30px;
            flex: 0 1 auto;
            color: #666a73;
            border-radius: 3px;
            border: 1px solid #d0d0d0;
        }
    }

    .checkbox-weekdays {
        display: block;
        padding: 30px 0 0 60px;
        .v-input {
            padding: 0;
            margin: 0;
        }
    }

    .action-button-multiple {
        display: flex;
        justify-content: center;
        .button-apply,
        .button-cancel {
            text-transform: none;
        }
    }
}
::v-deep .v-dialog {
    overflow-x: hidden;
    .v-item-group.v-tabs-bar {
        display: none;
    }
}
</style>
