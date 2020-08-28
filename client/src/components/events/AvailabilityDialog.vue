<template>
    <VDialog :value="visible" max-width="380" persistent>
        <VCard>
            <VRow justify="center">
                <VCol cols="9">
                    <VRow justify="center">
                        <VCardTitle class="headline">
                            {{ lang.AVAILABILITY }}
                        </VCardTitle>
                        <VRow>
                            <VCol cols="12">
                                <label class="availability-label">
                                    {{ lang.WHEN_CAN_EVENTS_BE_SCHEDULED }}
                                </label>
                            </VCol>
                        </VRow>

                        <VSelect
                            :value="scheduleType"
                            :items="availabilityItems"
                            @change="changeRangeScheduleType"
                            item-value="value"
                            item-text="label"
                            outlined
                            placeholder="Option"
                            dense
                            class="app-select"
                        >
                        </VSelect>

                        <VCardText class="px-0 pb-0" v-if="scheduleType !== availabilityItems[1]['value']">
                            <p>
                                {{ lang.YOUR_INVITEES_WILL_BE_OFFERED }}
                            </p>
                            <p class="mt-5" v-if="scheduleType === availabilityItems[0]['value']">
                                {{ lang.HOW_FAR_INTO_THE_FUTURE }}
                            </p>
                        </VCardText>

                        <VCardText class="px-0 pb-0" v-else>
                            <p>{{ lang.AVAILABILITY_RANGE }}</p>
                        </VCardText>

                        <VCol
                            cols="3"
                            class="px-0 py-0"
                            v-if="scheduleType === availabilityItems[0]['value']"
                        >
                            <VTextField
                                :value="value"
                                @change="changeRangeValue"
                                outlined
                                dense
                            >
                            </VTextField>
                        </VCol>
                        <VCol
                            cols="9"
                            class="px-0 py-0"
                            v-if="scheduleType === availabilityItems[0]['value']"
                        >
                            <VSelect
                                :value="subType"
                                :items="daysFormatItems"
                                @change="changeSubType"
                                item-value="value"
                                item-text="label"
                                outlined
                                placeholder="Option"
                                dense
                                class="mb-3 app-select"
                            >
                            </VSelect>
                        </VCol>
                        <VCol
                            cols="11"
                            class="px-0 py-0"
                            v-if="scheduleType === availabilityItems[1]['value']"
                        >
                            <VTextField
                                :value="datePeriod"
                                readonly
                            >
                            </VTextField>
                            <VDatePicker
                                :value="date"
                                :no-title="true"
                                :allowed-dates="allowedDates"
                                @input="changeRangeDate"
                                range
                            >
                            </VDatePicker>
                        </VCol>
                    </VRow>
                </VCol>
            </VRow>

            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="primary" text @click="changeDateRange">
                    {{ lang.APPLY }}
                </VBtn>
                <VBtn color="primary" text @click="cancel">
                    {{ lang.CANCEL }}
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import eventTypeMixin from "@/components/events/eventTypeMixin";
import {mapGetters} from "vuex";
import * as eventTypeGetters from "@/store/modules/eventType/types/getters";
import moment from 'moment';
import momentBusinessDays from 'moment-business-days';
export default {
    name: 'AvailabilityDialog',
    mixins: [eventTypeMixin],
    data() {
        return {
            form: {
                type: '',
                scheduleType: '',
                subType: '',
                value: 0,
                date: [],
                startDate: '',
                endDate: '',
                startTime: '09:00',
                endTime: '17:00'
            }
        };
    },

    methods: {
        changeRangeScheduleType(val) {
            switch (val) {
                case this.availabilityItems[0]['value']:
                    this.form.type = this.subType;
                    break;
                case this.availabilityItems[1]['value']:
                    this.form.type = this.daysFormatItems[0]['value'];
                    break;
                case this.availabilityItems[2]['value']:
                    this.form.type = this.subType + `_${this.availabilityItems[2]['value']}`;
                    break;
            }
            this.form.scheduleType = val;
            this.setEndDate();
        },
        changeRangeDate(date) {
            if (date.length === 1) {
                this.form.startDate = date[0];
                this.form.endDate = date[0];
                this.form.date = date;
            } else {
                if (moment(date[0]) < moment(date[1])) {
                    this.form.date = date;
                    this.form.startDate = date[0];
                    this.form.endDate = date[1];
                } else {
                    this.form.date = [date[1], date[0]];
                    this.form.startDate = date[1];
                    this.form.endDate = date[0];
                }
            }
        },
        changeRangeValue(value) {
            this.form.value = +value;
            this.setEndDate();
        },
        resetDateRange() {
            this.form.date = [];
            this.form.startDate = '';
            this.form.endDate = '';
            this.form.type = '';
            this.form.scheduleType = '';
            this.form.subType = '';
            this.form.value = 0;
        },
        changeDateRange() {
            this.setPropertyData('visibleAvailabilityDialog', false);
            this.changeEventTypeProperty('dateRange', {
                type: this.type,
                scheduleType: this.scheduleType,
                value: this.value,
                subType: this.subType,
                date: this.date,
                startDate: this.startDate,
                endDate: this.endDate,
                startTime: this.form.startTime,
                endTime: this.form.endTime
            });
        },
        changeSubType(value) {
            this.form.subType = this.form.type = value;
            if (this.form.scheduleType === this.availabilityItems[2]['value']) {
                this.form.type += `_${this.availabilityItems[2]['value']}`;
            }
            this.setEndDate();
        },
        cancel() {
            this.setPropertyData('visibleAvailabilityDialog', false);
            this.resetDateRange();
        },
        setEndDate() {
            if (this.subType === this.daysFormatItems[1]['value']) {
                this.form.endDate = momentBusinessDays(moment().format('YYYY-MM-DD'), 'YYYY-MM-DD')
                    .businessAdd(+this.value - 1)._d;
                return;
            }
            this.form.endDate = moment()
                .add(+this.value - 1, 'days')
                .format('YYYY-MM-DD');
        },
        allowedDates(value) {
            return moment(value) >= moment(this.startDate);
        }
    },

    computed: {
        ...mapGetters('eventType', {
            visibleAvailabilityDialog: eventTypeGetters.GET_VISIBLE_AVAILABILITY_DIALOG,
        }),
        scheduleType() {
            return this.form.scheduleType || this.data.dateRange.scheduleType;
        },
        type() {
            return this.form.type || this.data.dateRange.type;
        },
        subType() {
            return this.form.subType || this.data.dateRange.subType;
        },
        date() {
            return this.form.date || this.data.dateRange.date;
        },
        value() {
            return this.form.value || this.data.dateRange.value;
        },
        availabilityItems() {
            return [
                {
                    value: 'period',
                    label: this.lang.AVAILABILITY_ITEMS_PERIOD
                },
                {
                    value: 'range',
                    label: this.lang.AVAILABILITY_ITEMS_RANGE
                },
                {
                    value: 'indefinite',
                    label: this.lang.AVAILABILITY_ITEMS_INDEFINITELY
                }
            ];
        },
        daysFormatItems() {
            return [
                {
                    value: 'date_range',
                    label: this.lang.DAYS_FORMAT_ITEMS_CALENDAR
                },
                {
                    value: 'date_range_weekdays',
                    label: this.lang.DAYS_FORMAT_ITEMS_BUSINESS
                }
            ];
        },
        visible() {
            return this.visibleAvailabilityDialog;
        },
        endDate() {
            return this.form.endDate || this.data.dateRange.endDate;
        },
        startDate() {
            return this.form.startDate || this.data.dateRange.startDate;
        },
        datePeriod() {
            let result = '';
            if (this.endDate && this.startDate) {
                if (this.date.length === 1) {
                    result = moment(this.startDate).format('MMM DD - MMM DD, YYYY');
                } else {
                    if (moment(this.startDate).isSame(this.endDate, 'year')) {
                        result = `${moment(this.startDate).format('MMM DD')} - ${moment(this.endDate).format('MMM DD, YYYY')}`;
                    } else {
                        result = `${moment(this.startDate).format('MMM DD, YYYY')} - ${moment(this.endDate).format('MMM DD, YYYY')}`;
                    }
                }
            }
            return result;
        }
    }
};
</script>
<style scoped>
/deep/ .v-dialog {
    overflow-x: hidden;
}
</style>
