<template>
    <VRow class="ma-0 pa-0" v-if="isReady">
        <AutoFillSpacer />
        <VCol :class="colEventInfoClass">
            <EventInfo
                :brandingLogo="eventType.owner.brandingLogo"
                :avatar="eventType.owner.avatar"
                :name="eventType.owner.name"
                :eventName="eventType.name"
                :duration="eventType.duration"
                :location="eventType.location"
                :description="eventType.description"
                :lang="lang"
            />
        </VCol>
        <AutoFillSpacer />

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
                    min="2020-08-10"
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
                                <VListItemTitle>{{
                                    lang.CHOOSE_YOUR_TIMEZONE
                                }}</VListItemTitle>
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
                <div v-for="(time, i) in availableTimes" :key="i" text>
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
import enLang from '@/store/modules/i18n/en';
import EventInfo from './EventInfo';
import AutoFillSpacer from './AutoFillSpacer';
import * as actions from '@/store/modules/publicEvent/types/actions';
import * as getters from '@/store/modules/publicEvent/types/getters';
import * as mutations from '@/store/modules/publicEvent/types/mutations';
import { mapActions, mapGetters, mapMutations } from 'vuex';

export default {
    name: 'EventType',
    components: {
        EventInfo,
        AutoFillSpacer
    },
    async mounted() {
        await this.getEventTypeById(5);

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
        date() {
            this.selectedTime = null;
        },
        eventType() {
            this.isReady = true;
        }
    },
    data: () => ({
        lang: enLang,
        isReady: false,
        currentTimezone: momentTimezones.tz.guess(),
        currentTimezoneTime: null,
        timezoneFieldSearch: '',
        date: '',
        selectedTime: null
    }),

    computed: {
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
        currentTimezoneAvailabilities() {
            const formatTime = time => {
                return moment
                    .tz(time, this.eventType.timezone)
                    .clone()
                    .tz(this.currentTimezone)
                    .format('YYYY-MM-DD HH:mm:ss');
            };

            return this.eventType.availabilities.map(availability => ({
                startDate: formatTime(availability.startDate),
                endDate: formatTime(availability.endDate)
            }));
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
            const getCurrentDate = d => {
                return moment(d).format();
            };

            const currentDate = getCurrentDate(this.date);

            let availableTime = {};

            for (let availability of this.currentTimezoneAvailabilities) {
                const currentShortStartDate = getCurrentDate(
                    availability.startDate.slice(0, 10)
                );
                const currentShortEndDate = getCurrentDate(
                    availability.endDate.slice(0, 10)
                );

                if (
                    currentDate >= currentShortStartDate &&
                    currentDate <= currentShortEndDate
                ) {
                    availableTime.startTime = moment(
                        availability.startDate
                    ).format('HH:mm');

                    availableTime.endTime = moment(availability.endDate).format(
                        'HH:mm'
                    );

                    break;
                }
            }
            return availableTime;
        },
        availableTimes() {
            let duration = this.eventType.duration;
            let times = [];

            let start =
                this.availableTimesRange.startTime.split(':')[0] * 60 +
                +this.availableTimesRange.startTime.split(':')[1];
            const initialStart = start;

            let end =
                this.availableTimesRange.endTime.split(':')[0] * 60 +
                +this.availableTimesRange.endTime.split(':')[1];

            if (start > end && 24 * 60 - start <= end) {
                while (start > end) {
                    let [hours, minutes] = [Math.trunc(start / 60), start % 60];

                    if (24 * 60 - start + duration >= 0) {
                        hours = hours > 23 ? hours - 24 : hours;
                    } else {
                        hours -= 24;
                        start -= 24 * 60;
                    }

                    hours = String(hours).length === 2 ? hours : '0' + hours;
                    minutes =
                        String(minutes).length === 2 ? minutes : minutes + '0';
                    times.push(`${hours}:${minutes}`);
                    start += duration;
                }
            }

            while (end - start >= duration) {
                let [hours, minutes] = [Math.trunc(start / 60), start % 60];
                hours = String(hours).length === 2 ? hours : '0' + hours;
                minutes =
                    String(minutes).length === 2 ? minutes : minutes + '0';
                times.push(`${hours}:${minutes}`);
                start += duration;
            }

            times.sort(
                (prev, next) =>
                    prev.split(':')[0] * 60 +
                    +prev.split(':')[1] -
                    next.split(':')[0] * 60 +
                    +next.split(':')[1]
            );

            times = this.appropriateTimes(times, initialStart, end);

            return this.convertToUserFormat(times);
        }
    },
    methods: {
        ...mapActions('publicEvent', {
            getEventTypeById: actions.GET_EVENT_TYPE_BY_ID
        }),
        ...mapMutations('publicEvent', {
            setPublicEvent: mutations.SET_PUBLIC_EVENT
        }),
        onConfirmDate(time) {
            this.setPublicEvent({
                eventTypeId: this.eventType.id,
                startDate: `${this.date} ${time}`,
                timezone: this.currentTimezone
            });
            this.$router.push({
                name: 'PublicEventConfirm'
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
        appropriateTimes(times, initialStart, end) {
            if (
                this.currentTimezoneAvailabilities.some(date =>
                    date.startDate.includes(this.date)
                )
            ) {
                return times.filter(
                    time => +time.split(':')[0] * 60 >= initialStart
                );
            } else if (
                this.currentTimezoneAvailabilities.some(date =>
                    date.endDate.includes(this.date)
                )
            ) {
                return times.filter(time => +time.split(':')[0] * 60 < end);
            } else {
                return times;
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
        availableDates(date) {
            const getCurrentDate = d => {
                return moment(d).format();
            };
            const currentDate = getCurrentDate(date);

            let present = false;

            for (let availability of this.currentTimezoneAvailabilities) {
                if (
                    currentDate >=
                        getCurrentDate(availability.startDate.slice(0, 10)) &&
                    currentDate <=
                        getCurrentDate(availability.endDate.slice(0, 10))
                ) {
                    present = true;
                    break;
                }
            }

            return present;
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
