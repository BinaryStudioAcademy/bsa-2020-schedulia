<template>
    <VRow class="fill-height">
        <VCol>
            <VSheet height="64">
                <VToolbar flat color="white">
                    <VBtn fab text small @click="prev">
                        <img
                            :src="
                                require('@/assets/images/chevrons/chevron_left.png')
                            "
                            alt=""
                        />
                    </VBtn>
                    <VToolbarTitle v-if="calendarTitle" class="pa-4">
                        {{ calendarTitle }}
                    </VToolbarTitle>
                    <VBtn fab text small @click="next">
                        <img
                            :src="
                                require('@/assets/images/chevrons/chevron_right.png')
                            "
                            alt=""
                        />
                    </VBtn>
                    <VMenu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <VBtn
                                v-model="date"
                                label="Picker in menu"
                                v-bind="attrs"
                                v-on="on"
                                text
                                color="white"
                            >
                                <VImg
                                    :src="
                                        require('@/assets/images/calendar_dates.svg')
                                    "
                                    alt=""
                                    width="24"
                                    height="24"
                                >
                                </VImg>
                            </VBtn>
                        </template>
                        <VDatePicker v-model="date" no-title scrollable>
                            <VSpacer></VSpacer>
                            <VBtn text color="primary" @click="menu = false">
                                Cancel
                            </VBtn>
                            <VBtn
                                text
                                color="primary"
                                @click="$refs.menu.save(date)"
                            >
                                OK
                            </VBtn>
                        </VDatePicker>
                    </VMenu>
                    <VSpacer></VSpacer>
                </VToolbar>
            </VSheet>
            <VSheet height="600">
                <VCalendar
                    ref="calendar"
                    color="primary"
                    v-model="focus"
                    :value="data.selectDay.date"
                    :type="type"
                    :show-month-on-first="false"
                    @click:day="viewEventDialog"
                >
                    <template v-slot:day="data">
                        <div
                            :class="[
                                availability.type === 'date_range'
                                    ? 'default-availability'
                                    : 'custom-availability'
                            ]"
                            v-for="(availability,
                            index) in getDayAvailabilities(data)"
                            :key="index"
                        >
                            <div v-if="availability.type !== 'unavailable'">
                                <div v-if="index < 2">
                                    {{ availability.startTime }} -
                                    {{ availability.endTime }}
                                </div>
                                <div class="more-availability" v-else>
                                    + {{ index - 1 }} {{ lang.MORE }}...
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-slot:day-label="{ present }">
                        <p v-if="present" class="title-wrapper">
                            <span @click="viewEventDialog" class="title-today">
                                {{ lang.TODAY }}
                            </span>
                        </p>
                    </template>
                </VCalendar>
                <DayAvailabilitiesDialog></DayAvailabilitiesDialog>
            </VSheet>
        </VCol>
    </VRow>
</template>

<script>
import eventTypeMixin from '@/components/events/eventTypeMixin';
import moment from 'moment';
import DayAvailabilitiesDialog from '@/components/events/DayAvailabilitiesDialog';
import _ from 'lodash';
export default {
    name: 'Calendar',
    components: { DayAvailabilitiesDialog },
    mixins: [eventTypeMixin],
    data() {
        return {
            focus: '',
            menu: false,
            type: 'month',
            date: new Date().toISOString().substr(0, 10),
            firstCalendarDay: '',
            lastCalendarDay: ''
        };
    },
    methods: {
        prev() {
            this.$refs.calendar.prev();
            this.firstCalendarDay = '';
            this.lastCalendarDay = '';
        },
        next() {
            this.$refs.calendar.next();
            this.firstCalendarDay = '';
            this.lastCalendarDay = '';
        },
        viewEventDialog(data) {
            let dayAvailabilities = _.cloneDeep(
                this.getDayAvailabilities(data, true)
            );
            if (dayAvailabilities.length > 0) {
                this.changeEventTypeProperty('selectDay', data);
                this.setPropertyData('dayAvailabilities', dayAvailabilities);
                this.setPropertyData('visibleDayAvailabilitiesDialog', true);
            }
        },
        setCalendarDays(day) {
            if (!this.firstCalendarDay) {
                this.firstCalendarDay = day.date;
                this.lastCalendarDay = moment(this.firstCalendarDay)
                    .add(30, 'days')
                    .format('YYYY-MM-DD');
            } else if (moment(this.lastCalendarDay) < moment(day.date)) {
                this.lastCalendarDay = day.date;
            }
        },
        getDayAvailabilities(day, isExactDate = false) {
            let result = [];
            this.setCalendarDays(day);
            if (
                !this.data.dateRange.type.includes('indefinite') &&
                !moment(day.date).isBetween(
                    this.data.dateRange.startDate,
                    this.data.dateRange.endDate,
                    undefined,
                    '[]'
                )
            ) {
                return result;
            }

            if (
                this.data.dateRange.type.includes('indefinite') &&
                moment(day.date) < moment(this.data.dateRange.startDate)
            ) {
                return result;
            }

            let weekDayName = moment(day.date)
                .format('dddd')
                .toLowerCase();
            let params = {};
            if (
                this.data.availabilities_week_days[weekDayName] &&
                !this.data.availabilities[day.date]
            ) {
                let result = [
                    ...this.data.availabilities_week_days[weekDayName]
                ];
                return result;
            } else if (this.data.availabilities[day.date]) {
                let result = [...this.data.availabilities[day.date]];
                return result;
            } else {
                params = {
                    ...this.data.dateRange,
                    ...{
                        startDate:
                            day.date +
                            ' ' +
                            this.data.dateRange.startTime +
                            ':00',
                        endDate:
                            day.date + ' ' + this.data.dateRange.endTime + ':00'
                    }
                };
            }

            if (this.data.dateRange.type.includes('weekdays')) {
                if (day.weekday > 0 && day.weekday < 6) {
                    result.push(params);
                }
            } else {
                result.push(params);
            }

            if (isExactDate) {
                result[0]['type'] = 'exact_date';
            }

            return result;
        }
    },
    computed: {
        calendarTitle() {
            let result = '';

            if (!this.firstCalendarDay && !this.lastCalendarDay) {
                return result;
            }
            if (
                moment(this.firstCalendarDay).isSame(
                    this.lastCalendarDay,
                    'year'
                )
            ) {
                result = `${moment(this.firstCalendarDay).format(
                    'MMMM DD'
                )} - ${moment(this.lastCalendarDay).format('MMMM DD, YYYY')}`;
            } else {
                result = `${moment(this.firstCalendarDay).format(
                    'MMMM DD, YYYY'
                )} - ${moment(this.lastCalendarDay).format('MMMM DD, YYYY')}`;
            }

            return result;
        }
    }
};
</script>
<style lang="scss" scoped>
.title-wrapper {
    .title-today {
        font-size: 12px;
        font-weight: bold;
        color: #666a73;
    }
}
.default-availability {
    font-size: 12px;
    text-align: center;
    border: 1px solid #d0d0d0;
    border-radius: 2px;
    margin: 0 3px;
    padding: 5px 0;
    position: relative;
    &:before {
        content: '';
        position: absolute;
        top: -2.4px;
        right: 5px;
        width: 10px;
        height: 4px;
        background-color: white;
        z-index: 1;
        border-style: solid;
        border-width: 2px 0 2px 6px;
        border-color: transparent transparent transparent #d0d0d0;
    }
    &:after {
        content: '';
        position: absolute;
        bottom: -2.4px;
        left: 5px;
        width: 10px;
        height: 4px;
        background-color: white;
        z-index: 1;
        border-style: solid;
        border-width: 2px 6px 2px 0;
        border-color: transparent #d0d0d0 transparent transparent;
    }
}
.custom-availability {
    font-size: 10px;
    text-align: center;
    margin: 0 3px;
}
.more-availability {
    font-size: 9px;
    text-align: center;
    font-weight: bold;
    color: #666a73;
}
::v-deep .v-calendar-weekly__day {
    &:hover {
        border: 1px double #281ac8;
        box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
    }
}
</style>
