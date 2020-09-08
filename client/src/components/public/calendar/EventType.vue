<template>
    <VRow class="ma-0 pa-0" v-if="isReady">
        <VSpacer class="hidden-md-and-down"></VSpacer>
        <VCol :class="colEventInfoClass">
            <EventInfo
                :brandingLogo="eventType.owner.brandingLogo"
                :avatar="eventType.owner.avatar"
                :name="eventType.owner.name"
                :eventName="eventType.name"
                :duration="eventType.duration"
                :locationType="eventType.locationType"
                :coordinates="eventType.coordinates"
                :address="eventType.address"
                :description="eventType.description"
                :lang="lang"
            />
        </VCol>
        <VSpacer class="hidden-md-and-down"></VSpacer>

        <VDivider vertical class="hidden-md-and-down"></VDivider>

        <VCol
            sm="12"
            md="6"
            lg="5"
            class="calendar-container col-12 pa-0 mt-0 ml-0"
        >
            <div class="calendar-content">
                <h3>{{ lang.SELECT_DATE_AND_TIME }}</h3>
                <VDatePicker
                    v-model="date"
                    :min="minDate"
                    :first-day-of-week="1"
                    :weekday-format="getDay"
                    :header-date-format="dateFormat"
                    :allowed-dates="availableDates"
                    no-title
                    :full-width="true"
                    color="primary"
                    flat
                    is-inline
                ></VDatePicker>
                <VSelect
                    class="timezone-selector"
                    v-model="currentTimezone"
                    :items="filterTimezones"
                    solo
                    prepend-icon="mdi-earth"
                >
                    <template v-slot:prepend-item>
                        <VListItem>
                            <VListItemContent>
                                <VListItemTitle>
                                    {{ lang.CHOOSE_YOUR_TIMEZONE }}
                                </VListItemTitle>
                                <VTextField
                                    v-model="timezoneFieldSearch"
                                    label="Enter timezone"
                                ></VTextField>
                            </VListItemContent>
                        </VListItem>
                        <VDivider></VDivider>
                    </template>
                </VSelect>
            </div>
        </VCol>

        <VDivider v-if="show" vertical class="hidden-md-and-down"></VDivider>

        <VSpacer class="hidden-md-and-down"></VSpacer>
        <VCol
            v-if="show"
            sm="12"
            md="4"
            lg="3"
            class="select-time-container col-12 pa-0 mt-0"
        >
            <h3>{{ formattedDate }}</h3>
            <div class="time-items-container">
                <div
                    v-for="(time, i) in currentDayAvailableTimes"
                    :key="i"
                    text
                >
                    <div v-if="selectedTime === i">
                        <div class="confirm-event">
                            <VCard
                                outlined
                                class="selected-time-card align-center"
                            >
                                <VCardText
                                    dense
                                    class="text-center pa-0 justify-center primary--text font-weight-bold"
                                    >{{ time }}</VCardText
                                >
                            </VCard>
                            <VBtn
                                class="select-time-btn text-capitalize"
                                depressed
                                color="primary"
                                dark
                                @click="onConfirmDate(time)"
                                >{{ lang.CONFIRM_DATE }}</VBtn
                            >
                        </div>
                    </div>
                    <VBtn
                        class="select-time-item"
                        color="primary"
                        outlined
                        @click="selectTime(i)"
                        v-else
                        >{{ time }}</VBtn
                    >
                </div>
            </div>
        </VCol>
        <VSpacer class="hidden-md-and-down"></VSpacer>
    </VRow>
</template>

<script>
import moment from 'moment';
import momentTimezones from 'moment-timezone';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import EventInfo from '@/components/public/calendar/EventInfo';
import * as actions from '@/store/modules/publicEvent/types/actions';
import * as getters from '@/store/modules/publicEvent/types/getters';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'EventType',
    components: {
        EventInfo
    },
    async mounted() {
        const eventType = await this.getEventTypeBySlugAndNickname({
            slug: this.$route.params.slug,
            nickname: this.$route.params.nickname
        });

        eventType &&
            eventType.disabled &&
            this.$router.push({
                name: 'DisabledEvent'
            });
        this.currentTimezoneTime = this.getFormattedTimezoneTime(
            this.currentTimezone
        );
    },
    watch: {
        currentTimezone() {
            this.date = '';
            this.selectedTime = null;
            this.currentTimezoneTime = this.getFormattedTimezoneTime(
                this.currentTimezone
            );
        },
        eventType() {
            this.isReady = true;
        },
        async currentMonth() {
            this.currentMonthAvailabilities = await this.getAvailabilitiesByMonth(
                {
                    id: this.eventType.id,
                    date: `${this.currentMonth.slice(
                        0,
                        4
                    )}-${this.currentMonth.slice(5)}`
                }
            );
        },
        date() {
            if (this.date) {
                for (let date of this.currentTimezoneAvailabilities) {
                    if (date.startDate.includes(this.date)) {
                        this.currentDayUnavailibilities = date.unavailable.map(
                            time =>
                                moment
                                    .tz(
                                        `2010-10-10 ${time}`,
                                        this.eventType.timezone
                                    )
                                    .clone()
                                    .tz(this.currentTimezone)
                                    .format('HH:mm')
                        );
                        break;
                    }
                }

                this.currentDayAvailableTimes = this.availableTimes;
            }
        }
    },
    data: () => ({
        isReady: false,
        currentMonth: null,
        currentMonthAvailabilities: null,
        currentDayUnavailibilities: null,
        currentDayAvailableTimes: null,
        currentTimezone: momentTimezones.tz.guess(),
        currentTimezoneTime: null,
        timezoneFieldSearch: '',
        date: '',
        selectedTime: null
    }),

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('publicEvent', {
            eventType: getters.GET_EVENT_TYPE
        }),
        currentTimezoneStartTime() {
            return moment
                .tz(this.eventType.startDate, this.eventType.timezone)
                .clone()
                .tz(this.currentTimezone)
                .format();
        },
        minDate() {
            return moment()
                .tz(this.currentTimezone)
                .format('YYYY-MM-DD');
        },
        currentTimezoneAvailabilities() {
            const formatTime = time => {
                return moment
                    .tz(time, this.eventType.timezone)
                    .clone()
                    .tz(this.currentTimezone)
                    .format('YYYY-MM-DD HH:mm:ss');
            };

            let allTimes = [];

            for (let date in this.currentMonthAvailabilities) {
                for (let availability of this.currentMonthAvailabilities[
                    date
                ]) {
                    allTimes.push({
                        startDate: `${date} ${availability.start_time.slice(
                            0,
                            5
                        )}`,
                        endDate: `${date} ${
                            availability.end_time.slice(0, 5) === '00:00'
                                ? '24:00'
                                : availability.end_time.slice(0, 5)
                        }`,
                        unavailable: availability.unavailable
                    });
                }
            }

            allTimes = allTimes.map(availability => ({
                startDate: formatTime(availability.startDate),
                endDate:
                    formatTime(availability.endDate) ===
                    formatTime(availability.startDate)
                        ? moment(
                              formatTime(availability.endDate),
                              'YYYY-MM-DD HH:mm:ss'
                          )
                              .add(1, 'days')
                              .format('YYYY-MM-DD HH:mm:ss')
                              .replace('00:00:00', '24:00:00')
                        : moment(
                              formatTime(availability.endDate),
                              'YYYY-MM-DD HH:mm:ss'
                          )
                              .format('YYYY-MM-DD HH:mm:ss')
                              .replace('00:00:00', '24:00:00'),
                unavailable: availability.unavailable
            }));

            return allTimes;
        },
        normalizedRemainderTimes() {
            const getHours = date => {
                return date.slice(11, 13);
            };

            const getMinutes = date => {
                return date.slice(14, 16);
            };

            const getDate = date => {
                return date.slice(0, 10);
            };

            let normalizedTimes = [];
            for (let availability of this.currentTimezoneAvailabilities) {
                if (
                    +getHours(availability.startDate) >
                        +getHours(availability.endDate) ||
                    (+moment(availability.endDate).format('DD') >
                        +moment(availability.startDate).format('DD') &&
                        +getHours(availability.startDate) >=
                            +getHours(availability.endDate))
                ) {
                    let start =
                        availability.startDate.slice(11, 16).split(':')[0] *
                            60 +
                        +availability.startDate.slice(11, 16).split(':')[1];

                    let end =
                        availability.endDate.slice(11, 16).split(':')[0] * 60 +
                        +availability.endDate.slice(11, 16).split(':')[1] +
                        24 * 60;

                    let computeNextInterval = true;
                    let maxTimePrevDay = start;
                    let minTimeNextDay;
                    let nextDayWasVisited = false;

                    while (computeNextInterval) {
                        maxTimePrevDay = start;

                        if (
                            start + this.eventType.duration < 24 * 60 &&
                            start + this.eventType.duration <= end
                        ) {
                            if (!nextDayWasVisited) {
                                let [startHours, startMinutes] = [
                                    Math.trunc(start / 60),
                                    start % 60
                                ];

                                let endTime = start + this.eventType.duration;

                                let [endHours, endMinutes] = [
                                    Math.trunc(endTime / 60),
                                    endTime % 60
                                ];
                                normalizedTimes.push({
                                    startDate: `${getDate(
                                        availability.startDate
                                    )} ${this.normalizeTime(
                                        startHours
                                    )}:${this.normalizeTime(startMinutes)}:00`,
                                    endDate: `${getDate(
                                        availability.startDate
                                    )} ${this.normalizeTime(
                                        endHours
                                    )}:${this.normalizeTime(endMinutes)}:00`
                                });
                            }
                            start += this.eventType.duration;
                        } else if (
                            start + this.eventType.duration >= 24 * 60 &&
                            start + this.eventType.duration <= end
                        ) {
                            nextDayWasVisited = true;
                            if (start < 24 * 60) {
                                maxTimePrevDay = start;
                                let [maxHours, maxMinutes] = [
                                    Math.trunc(maxTimePrevDay / 60),
                                    maxTimePrevDay % 60
                                ];
                                minTimeNextDay =
                                    start + this.eventType.duration;
                                const unformattedMinTimeNextDay = minTimeNextDay;
                                minTimeNextDay -= 24 * 60;

                                let [minHours, minMinutes] = [
                                    Math.trunc(minTimeNextDay / 60),
                                    minTimeNextDay % 60
                                ];
                                if (
                                    getHours(availability.startDate) !==
                                        this.normalizeTime(maxHours) &&
                                    getMinutes(availability.startDate) !==
                                        this.normalizeTime(maxMinutes)
                                ) {
                                    normalizedTimes.push({
                                        startDate: `${getDate(
                                            availability.startDate
                                        )} ${getHours(
                                            availability.startDate
                                        )}:${getMinutes(
                                            availability.startDate
                                        )}:00`,
                                        endDate: `${getDate(
                                            availability.startDate
                                        )} ${this.normalizeTime(
                                            maxHours
                                        )}:${this.normalizeTime(maxMinutes)}:00`
                                    });
                                }
                                normalizedTimes.push({
                                    startDate: `${getDate(
                                        availability.startDate
                                    )} ${this.normalizeTime(
                                        maxHours
                                    )}:${this.normalizeTime(maxMinutes)}:00`,
                                    endDate: `${getDate(
                                        availability.endDate
                                    )} ${this.normalizeTime(
                                        minHours
                                    )}:${this.normalizeTime(minMinutes)}:00`
                                });
                                if (
                                    unformattedMinTimeNextDay +
                                        this.eventType.duration <=
                                    end
                                ) {
                                    normalizedTimes.push({
                                        startDate: `${getDate(
                                            availability.endDate
                                        )} ${this.normalizeTime(
                                            minHours
                                        )}:${this.normalizeTime(
                                            minMinutes
                                        )}:00`,
                                        endDate: `${getDate(
                                            availability.endDate
                                        )} ${getHours(
                                            availability.endDate
                                        )}:${getMinutes(
                                            availability.endDate
                                        )}:00`
                                    });
                                }
                            } else if (start > 24 * 60) {
                                start -= 24 * 60;
                                end -= 24 * 60;
                                let [startHours, startMinutes] = [
                                    Math.trunc(start / 60),
                                    start % 60
                                ];

                                let endTime = start + this.eventType.duration;

                                let [endHours, endMinutes] = [
                                    Math.trunc(endTime / 60),
                                    endTime % 60
                                ];

                                if (
                                    !normalizedTimes.some(
                                        interval =>
                                            `${getDate(
                                                availability.endDate
                                            )} ${this.normalizeTime(
                                                endHours
                                            )}:${this.normalizeTime(
                                                endMinutes
                                            )}:00` === interval.endDate
                                    )
                                ) {
                                    normalizedTimes.push({
                                        startDate: `${getDate(
                                            availability.endDate
                                        )} ${this.normalizeTime(
                                            startHours
                                        )}:${this.normalizeTime(
                                            startMinutes
                                        )}:00`,
                                        endDate: `${getDate(
                                            availability.endDate
                                        )} ${this.normalizeTime(
                                            endHours
                                        )}:${this.normalizeTime(endMinutes)}:00`
                                    });
                                }
                            }
                            start += this.eventType.duration;
                        } else {
                            computeNextInterval = false;
                        }
                    }
                } else {
                    normalizedTimes.push(availability);
                }
            }
            return normalizedTimes;
        },
        filterTimezones() {
            return momentTimezones.tz.names().filter(zone => {
                return zone
                    .toLowerCase()
                    .includes(this.timezoneFieldSearch.toLowerCase());
            });
        },
        colEventInfoClass() {
            const base = 'pa-0 col-md-5 col-sm-12 col-12';
            let lgSize;
            if (this.show) {
                lgSize = 'col-lg-3';
            } else {
                lgSize = 'col-lg-5';
            }
            return [lgSize, base];
        },
        show() {
            return this.date === '' ? false : true;
        },
        formattedDate() {
            return moment(this.date).format('dddd, MMMM D');
        },
        availableTimesRange() {
            let availableTimes = [];
            let i = 0;
            for (let availability of this.normalizedRemainderTimes) {
                if (availability.startDate.includes(this.date)) {
                    availableTimes.push({
                        startTime: availability.startDate.slice(11, 16),
                        endTime: availability.endDate.slice(11, 16)
                    });

                    if (
                        +availability.startDate.slice(11, 13) >
                        +availability.endDate.slice(11, 13)
                    ) {
                        availableTimes[
                            i
                        ].endTime = `${+availability.endDate.slice(11, 13) +
                            24}:${availability.endDate.slice(14, 16)}`;
                    }

                    i++;
                }
            }
            return availableTimes;
        },
        availableTimes() {
            let times = [];

            for (let timeRange of this.availableTimesRange) {
                let start =
                    timeRange.startTime.split(':')[0] * 60 +
                    +timeRange.startTime.split(':')[1];

                let end =
                    timeRange.endTime.split(':')[0] * 60 +
                    +timeRange.endTime.split(':')[1];

                while (end - start >= this.eventType.duration) {
                    let [hours, minutes] = [Math.trunc(start / 60), start % 60];
                    hours = String(hours).length === 2 ? hours : '0' + hours;
                    minutes =
                        String(minutes).length === 2 ? minutes : '0' + minutes;
                    times.push(`${hours}:${minutes}`);
                    start += this.eventType.duration;
                }
            }
            times.sort(
                (prev, next) =>
                    prev.split(':')[0] * 60 +
                    +prev.split(':')[1] -
                    next.split(':')[0] * 60 +
                    +next.split(':')[1]
            );

            times = times.filter(
                time => !this.currentDayUnavailibilities.includes(time)
            );

            if (
                moment()
                    .tz(this.currentTimezone)
                    .format('YYYY-MM-DD')
                    .includes(this.date)
            ) {
                times = times.filter(
                    time =>
                        moment.duration(time).asMinutes() >
                        moment
                            .duration(
                                moment()
                                    .tz(this.currentTimezone)
                                    .format('HH:mm')
                            )
                            .asMinutes()
                );
            }

            return this.convertToUserFormat([...new Set(times)]);
        }
    },
    methods: {
        ...mapActions('publicEvent', {
            getEventTypeByIdAndNickname:
                actions.GET_EVENT_TYPE_BY_ID_AND_NICKNAME,
            getEventTypeBySlugAndNickname:
                actions.GET_EVENT_TYPE_BY_SLUG_AND_NICKNAME,
            setPublicEvent: actions.SET_PUBLIC_EVENT,
            getAvailabilitiesByMonth: actions.GET_AVAILABILITIES_BY_MONTH
        }),
        getStartDate(time) {
            const timeNormalized = moment(time, 'h:mm A').format('HH:mm');
            return `${moment
                .tz(
                    `${this.date} ${timeNormalized}`,
                    'YYYY-MM-DD HH:mm',
                    this.currentTimezone
                )
                .format()}`;
        },
        onConfirmDate(time) {
            const timeNormalized = moment(time, 'h:mm A').format('HH:mm');
            this.setPublicEvent({
                eventTypeId: this.eventType.id,
                startDate: moment
                    .tz(
                        `${this.date} ${timeNormalized}`,
                        'YYYY-MM-DD HH:mm',
                        this.currentTimezone
                    )
                    .format('YYYY-MM-DD HH:mm'),
                timezone: this.currentTimezone
            });
            this.$router.push({
                path: `/${this.eventType.owner.nickname}/${
                    this.eventType.slug
                }/${this.getStartDate(time)}`
            });
        },
        getFormattedTimezoneTime(timezone) {
            return (
                timezone +
                ' ' +
                momentTimezones()
                    .tz(timezone)
                    .format('HH:mm')
            );
        },
        convertToUserFormat(times) {
            if (!this.eventType.owner.timeFormat12h) {
                return times;
            } else {
                return times.map(time =>
                    moment(time, 'HHmm').format('hh:mm A')
                );
            }
        },
        dateFormat(date) {
            const [year, month] = date.split('-');
            const months = [
                this.lang.JAN,
                this.lang.FEB,
                this.lang.MAR,
                this.lang.APR,
                this.lang.MAY,
                this.lang.JUN,
                this.lang.JUL,
                this.lang.AUG,
                this.lang.SEP,
                this.lang.OCT,
                this.lang.NOV,
                this.lang.DEC
            ];

            if (month) {
                this.currentMonth = year + '-' + month;
                return months[month - 1] + ' ' + year;
            } else {
                return year;
            }
        },
        selectTime(index) {
            this.selectedTime = index;
        },
        getDay(date) {
            const weekDays = [
                this.lang.SUN,
                this.lang.MON,
                this.lang.TUE,
                this.lang.WED,
                this.lang.THU,
                this.lang.FRI,
                this.lang.SAT
            ];
            let i = new Date(date).getDay(date);
            return weekDays[i];
        },
        normalizeTime(time) {
            return String(time).length === 2 ? time : '0' + time;
        },
        availableDates(date) {
            let datePresent = false;
            let availableTimesPresent = false;
            for (let day of this.currentTimezoneAvailabilities) {
                if (
                    day.startDate.includes(date) &&
                    day.unavailable.length <
                        this.numberOfIntervals(day.startDate, day.endDate)
                ) {
                    availableTimesPresent = true;

                    if (
                        moment()
                            .tz(this.currentTimezone)
                            .add(this.eventType.duration, 'minutes')
                            .isAfter(moment(day.endDate))
                    ) {
                        availableTimesPresent = false;
                    }
                }
            }
            for (let normalizedDate of this.normalizedRemainderTimes) {
                if (normalizedDate.startDate.includes(date)) {
                    datePresent = true;
                }
            }
            return availableTimesPresent && datePresent;
        },
        numberOfIntervals(startDate, endDate) {
            let duration = moment.duration(
                moment(endDate).diff(moment(startDate))
            );
            let minutes = duration.asMinutes();

            let numberOfIntervals = minutes / this.eventType.duration;

            return numberOfIntervals;
        }
    }
};
</script>

<style scoped>
.calendar-content::v-deep .v-date-picker-header {
    margin: 0 0 25px 0;
    justify-content: flex-start;
}
.calendar-content::v-deep
    .theme--light.v-date-picker-header
    .v-date-picker-header__value:not(.v-date-picker-header__value--disabled)
    button:not(:hover):not(:focus) {
    color: grey;
    font-weight: 500;
}
.calendar-content::v-deep .v-date-picker-header__value {
    flex: none;
    padding: 0 15px;
}
.calendar-content::v-deep .theme--light.v-btn.v-btn--icon {
    color: var(--v-primary-base);
}

.calendar-container {
    min-width: 350px;
}

.calendar-content {
    display: flex;
    width: 100%;
    flex-wrap: wrap;
    max-width: 400px;
    justify-content: center;
    margin: 0 auto;
}

.calendar-container h3 {
    margin: 50px 0 10px 0;
    width: 100%;
    padding-left: 30px;
}

.timezone-selector {
    padding: 10px 30px;
}

.select-time-container {
    margin: 0 auto;
}

.select-time-container h3 {
    margin: 50px 0 10px 5px;
}

.time-items-container {
    overflow-y: scroll;
    min-width: 200px;
    max-height: 600px;
    width: 100%;
    padding: 5px;
}

.select-time-item {
    display: flex;
    width: 100%;
    justify-content: center;
    border-radius: 3px;
    border: 1px solid var(--v-primary-base);
    font-weight: bold;
    margin: 5px 0;
    cursor: pointer;
}

.confirm-event {
    display: flex;
    justify-content: space-between;
}

.select-time-btn {
    width: 48%;
}

.selected-time-card {
    width: 48%;
    border: 1px solid var(--v-primary-base);
    padding: 6px;
}

::-webkit-scrollbar {
    width: 3px;
}

::-webkit-scrollbar-thumb {
    background: var(--v-primary-base);
}

@media (max-width: 1263px) {
    .calendar-container {
        margin: 20px;
    }
    .select-time-container h3 {
        margin-top: 20px;
    }
    .calendar-container h3 {
        margin-top: 20px;
    }
}

@media (max-width: 959px) {
    .calendar-container {
        padding: 0;
    }
    .calendar-container h3 {
        padding-left: 20px;
    }
    .select-time-container {
        padding-left: 10px;
    }
    .select-time-container h3 {
        margin-left: 20px;
    }
    .calendar-content {
        justify-content: flex-start;
    }
}

@media (max-width: 600px) {
    .calendar-container {
        padding: 0;
    }
}

@media (max-width: 420px) {
    .calendar-container {
        min-width: 320px;
        margin: 20px 0;
    }
}
</style>
