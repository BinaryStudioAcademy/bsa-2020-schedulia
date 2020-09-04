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
        :location="'Vyacheslav Chornovol Avenue, 59, Lviv'"
        :description="eventType.description"
        :lang="lang"
      />
    </VCol>
    <AutoFillSpacer />

    <VDivider vertical class="hidden-md-and-down"></VDivider>

    <VCol sm="12" md="6" lg="5" class="calendar-container col-12 pa-0 mt-0 ml-0">
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
                <VListItemTitle>
                  {{
                  lang.CHOOSE_YOUR_TIMEZONE
                  }}
                </VListItemTitle>
                <VTextField v-model="timezoneFieldSearch" label="Enter timezone"></VTextField>
              </VListItemContent>
            </VListItem>
            <VDivider></VDivider>
          </template>
        </VSelect>
      </div>
    </VCol>

    <VDivider v-if="show" vertical class="hidden-md-and-down"></VDivider>

    <VSpacer class="hidden-md-and-down"></VSpacer>
    <VCol v-if="show" sm="12" md="4" lg="3" class="select-time-container col-12 pa-0 mt-0">
      <h3>{{ formattedDate }}</h3>
      <div class="time-items-container">
        <div v-for="(time, i) in availableTimes" :key="i" text>
          <div v-if="selectedTime === i">
            <div class="confirm-event">
              <VCard outlined class="selected-time-card align-center">
                <VCardText
                  dense
                  class="text-center pa-0 justify-center primary--text font-weight-bold"
                >{{ time }}</VCardText>
              </VCard>
              <VBtn
                class="select-time-btn text-capitalize"
                depressed
                color="primary"
                dark
                @click="onConfirmDate(time)"
              >{{ lang.CONFIRM_DATE }}</VBtn>
            </div>
          </div>
          <VBtn
            class="select-time-item"
            color="primary"
            outlined
            @click="selectTime(i)"
            v-else
          >{{ time }}</VBtn>
        </div>
      </div>
    </VCol>
    <VSpacer class="hidden-md-and-down"></VSpacer>
  </VRow>
</template>

<script>
import moment from "moment";
import momentTimezones from "moment-timezone";
import * as i18nGetters from "@/store/modules/i18n/types/getters";
import EventInfo from "./EventInfo";
import AutoFillSpacer from "./AutoFillSpacer";
import * as actions from "@/store/modules/publicEvent/types/actions";
import * as getters from "@/store/modules/publicEvent/types/getters";
import { mapActions, mapGetters } from "vuex";

export default {
  name: "EventType",
  components: {
    EventInfo,
    AutoFillSpacer
  },
  async mounted() {
    const eventType = await this.getEventTypeByIdAndNickname({
      id: this.$route.params.id,
      nickname: this.$route.params.nickname
    });

    eventType &&
      eventType.disabled &&
      this.$router.push({
        name: "DisabledEvent"
      });
    this.currentTimezoneTime = this.getFormattedTimezoneTime(
      this.currentTimezone
    );
  },
  watch: {
    currentTimezone() {
      this.date = "";
      this.selectedTime = null;
      this.currentTimezoneTime = this.getFormattedTimezoneTime(
        this.currentTimezone
      );
    },
    eventType() {
      this.isReady = true;
    },
    async currentMonth() {
      this.currentMonthAvailabilities = await this.getAvailabilitiesByMonth({
        id: this.eventType.id,
        date: `${this.currentMonth.slice(0, 4)}-${this.currentMonth.slice(5)}`
      });
    }
  },
  data: () => ({
    isReady: false,
    currentMonth: null,
    currentMonthAvailabilities: null,
    currentTimezone: momentTimezones.tz.guess(),
    currentTimezoneTime: null,
    timezoneFieldSearch: "",
    date: "",
    selectedTime: null,
    availabilities: {
      "2020-08-20": [],
      "2020-09-01": [
        {
          type: "date_range_weekdays",
          start_time: "09:00:00",
          end_time: "19:00:00",
          unavailable: ["15:00:00", "16:00:00"]
        }
      ],
      "2020-09-02": [
        {
          type: "date_range_weekdays",
          start_time: "05:00:00",
          end_time: "11:00:00",
          unavailable: ["15:00:00", "16:00:00"]
        }
      ],
      "2020-09-03": [
        {
          type: "date_range_weekdays",
          start_time: "00:00:00",
          end_time: "23:59:00",
          unavailable: []
        }
      ],
      "2020-09-14": [
        {
          type: "date_range_weekdays",
          start_time: "11:00:00",
          end_time: "14:00:00",
          unavailable: []
        },
        {
          type: "date_range_weekdays",
          start_time: "15:00:00",
          end_time: "22:00:00",
          unavailable: []
        }
      ]
    },
    dateRange: {
      type: "date_range",
      scheduleType: "period",
      subType: "date_range",
      value: 60,
      date: [],
      startDate: "2020-09-03",
      endDate: "2020-11-05",
      startTime: "09:00",
      endTime: "17:00"
    }
  }),

  computed: {
    ...mapGetters("i18n", {
      lang: i18nGetters.GET_LANGUAGE_CONSTANTS
    }),
    ...mapGetters("publicEvent", {
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
          .format("YYYY-MM-DD HH:mm:ss");
      };

      let allTimes = [];

      for (let date in this.currentMonthAvailabilities) {
        for (let availability of this.currentMonthAvailabilities[date]) {
          allTimes.push({
            startDate: `${date} ${availability.start_time.slice(0, 5)}`,
            endDate: `${date} ${availability.end_time.slice(0, 5)}`
          });
        }
      }

      allTimes = allTimes.map(availability => ({
        startDate: formatTime(availability.startDate),
        endDate: formatTime(availability.endDate)
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
          +getHours(availability.startDate) > +getHours(availability.endDate)
        ) {
          let start =
            availability.startDate.slice(11, 16).split(":")[0] * 60 +
            +availability.startDate.slice(11, 16).split(":")[1];

          let end =
            availability.endDate.slice(11, 16).split(":")[0] * 60 +
            +availability.endDate.slice(11, 16).split(":")[1] +
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
                  )} ${this.normalizeTime(startHours)}:${this.normalizeTime(
                    startMinutes
                  )}:00`,
                  endDate: `${getDate(
                    availability.startDate
                  )} ${this.normalizeTime(endHours)}:${this.normalizeTime(
                    endMinutes
                  )}:00`
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
                minTimeNextDay = start + this.eventType.duration;
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
                    startDate: `${getDate(availability.startDate)} ${getHours(
                      availability.startDate
                    )}:${getMinutes(availability.startDate)}:00`,
                    endDate: `${getDate(
                      availability.startDate
                    )} ${this.normalizeTime(maxHours)}:${this.normalizeTime(
                      maxMinutes
                    )}:00`
                  });
                }
                normalizedTimes.push({
                  startDate: `${getDate(
                    availability.startDate
                  )} ${this.normalizeTime(maxHours)}:${this.normalizeTime(
                    maxMinutes
                  )}:00`,
                  endDate: `${getDate(
                    availability.endDate
                  )} ${this.normalizeTime(minHours)}:${this.normalizeTime(
                    minMinutes
                  )}:00`
                });
                if (
                  unformattedMinTimeNextDay + this.eventType.duration <=
                  end
                ) {
                  normalizedTimes.push({
                    startDate: `${getDate(
                      availability.endDate
                    )} ${this.normalizeTime(minHours)}:${this.normalizeTime(
                      minMinutes
                    )}:00`,
                    endDate: `${getDate(availability.endDate)} ${getHours(
                      availability.endDate
                    )}:${getMinutes(availability.endDate)}:00`
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
                      `${getDate(availability.endDate)} ${this.normalizeTime(
                        endHours
                      )}:${this.normalizeTime(endMinutes)}:00` ===
                      interval.endDate
                  )
                ) {
                  normalizedTimes.push({
                    startDate: `${getDate(
                      availability.endDate
                    )} ${this.normalizeTime(startHours)}:${this.normalizeTime(
                      startMinutes
                    )}:00`,
                    endDate: `${getDate(
                      availability.endDate
                    )} ${this.normalizeTime(endHours)}:${this.normalizeTime(
                      endMinutes
                    )}:00`
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
      const base = "pa-0 col-md-5 col-sm-12 col-12";
      let lgSize;
      if (this.show) {
        lgSize = "col-lg-3";
      } else {
        lgSize = "col-lg-5";
      }
      return [lgSize, base];
    },
    show() {
      return this.date === "" ? false : true;
    },
    formattedDate() {
      return moment(this.date).format("dddd, MMMM D");
    },
    availableTimesRange() {
      let availableTimes = [];
      let i = 0;
      for (let availability of this.normalizedRemainderTimes) {
        if (availability.startDate.includes(this.date)) {
          availableTimes.push({
            startTime: moment(availability.startDate).format("HH:mm"),
            endTime: moment(availability.endDate).format("HH:mm")
          });

          if (
            +availability.startDate.slice(11, 13) >
            +availability.endDate.slice(11, 13)
          ) {
            availableTimes[i].endTime = `${+availability.endDate.slice(11, 13) +
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
          timeRange.startTime.split(":")[0] * 60 +
          +timeRange.startTime.split(":")[1];

        let end =
          timeRange.endTime.split(":")[0] * 60 +
          +timeRange.endTime.split(":")[1];

        while (end - start >= this.eventType.duration) {
          let [hours, minutes] = [Math.trunc(start / 60), start % 60];
          hours = String(hours).length === 2 ? hours : "0" + hours;
          minutes = String(minutes).length === 2 ? minutes : "0" + minutes;
          times.push(`${hours}:${minutes}`);
          start += this.eventType.duration;
        }
      }
      times.sort(
        (prev, next) =>
          prev.split(":")[0] * 60 +
          +prev.split(":")[1] -
          next.split(":")[0] * 60 +
          +next.split(":")[1]
      );

      return this.convertToUserFormat([...new Set(times)]);
    }
  },
  methods: {
    ...mapActions("publicEvent", {
      getEventTypeByIdAndNickname: actions.GET_EVENT_TYPE_BY_ID_AND_NICKNAME,
      setPublicEvent: actions.SET_PUBLIC_EVENT,
      getAvailabilitiesByMonth: actions.GET_AVAILABILITIES_BY_MONTH
    }),
    getStartDate(time) {
      return `${momentTimezones(`${this.date} ${time}`, "YYYY-MM-DD HH:mm")
        .tz(this.currentTimezone)
        .format()}`;
    },
    onConfirmDate(time) {
      this.setPublicEvent({
        eventTypeId: this.eventType.id,
        startDate: `${this.date} ${time}`,
        timezone: this.currentTimezone
      });
      this.$router.push({
        path: `/${this.eventType.owner.nickname}/${
          this.eventType.id
        }/${this.getStartDate(time)}`
      });
    },
    getFormattedTimezoneTime(timezone) {
      return (
        timezone +
        " " +
        momentTimezones()
          .tz(timezone)
          .format("HH:mm")
      );
    },
    convertToUserFormat(times) {
      if (!this.eventType.owner.timeFormat12h) {
        return times;
      } else {
        return times.map(time => moment(time, "HHmm").format("hh:mm A"));
      }
    },
    dateFormat(date) {
      const [year, month] = date.split("-");
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
        this.currentMonth = year + "-" + month;
        return months[month - 1] + " " + year;
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
      return String(time).length === 2 ? time : "0" + time;
    },
    availableDates(date) {
      let present = false;
      for (let normalizedDate of this.normalizedRemainderTimes) {
        if (normalizedDate.startDate.includes(date)) {
          present = true;
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
