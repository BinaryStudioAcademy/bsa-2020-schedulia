<template>
  <VRow class="ma-0 pa-0">
    <VCol :class="colEventInfoClass">
      <DetailLayout
        :companyLogo="owner.companyLogo"
        :avatar="owner.avatar"
        :name="owner.name"
        :eventName="meetingData.name"
      >
        <div class="event-info">
          <VIcon dark color="primary">mdi-clock-outline</VIcon>
          {{ meetingData.duration }} {{ lang.DURATION_MIN }}
        </div>
        <div class="event-info">
          <VIcon dark color="primary">mdi-map-marker</VIcon>
          {{ meetingData.location }}
        </div>
        <div class="event-info">{{ meetingData.description }}</div>
      </DetailLayout>
    </VCol>

    <VDivider vertical class="hidden-md-and-down"></VDivider>

    <VCol sm="12" md="6" lg="5" class="calendar-container col-12 ma-0">
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
          attach
          solo
          prepend-icon="mdi-earth"
          label="Timezone"
        >
          <template v-slot:prepend-item>
            <VListItem>
              <VListItemContent>
                <VListItemTitle>Choose your timezone</VListItemTitle>
                <VTextField
                  v-model="timezoneFieldSearch"
                  label="Enter timezone"
                ></VTextField>
              </VListItemContent>
            </VListItem>
            <VDivider></VDivider>
          </template>
        </VSelect>
        {{ date }}
        <br />
        {{ availableTimesRange }}
        <br />
        {{ currentTimezoneStartTime }}
        <br />
        {{ currentTimezoneAvailabilities }}
        <br />
        {{ availableTimesRange.startTime }} | {{ availableTimesRange.endTime }}
      </div>
    </VCol>
    <VDivider v-if="show" vertical class="hidden-md-and-down"></VDivider>
    <VCol
      v-if="show"
      sm="12"
      md="4"
      lg="3"
      class="select-time-container col-12"
    >
      <h3>{{ formattedDate }}</h3>
      <div class="time-items-container">
        <div v-for="(item, i) in getAllTimes" :key="i" text>
          <div v-if="selectedTime === i">
            <div class="confirm-event">
              <VCard outlined class="selected-time-card align-center">
                <VCardText
                  dense
                  class="text-center pa-0 justify-center primary--text font-weight-bold"
                  >{{ item }}</VCardText
                >
              </VCard>
              <VBtn
                class="select-time-btn"
                depressed
                color="primary"
                dark
                :to="{ path: 'confirm-event' }"
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
            >{{ item }}</VBtn
          >
        </div>
      </div>
    </VCol>
  </VRow>
</template>

<script>
import moment from "moment";
import momentTimezones from "moment-timezone";
import enLang from "@/store/modules/i18n/en";
import DetailLayout from "./DetailLayout";

/* const timezones = moment.tz.names(); */
console.log(momentTimezones.tz.guess()); /* delete */

export default {
  name: "EventType",
  components: {
    DetailLayout,
  },
  data: () => ({
    lang: enLang,
    /* timezones: filterTimezones, */
    currentTimezone: momentTimezones.tz.guess(),
    timezoneFieldSearch: "",
    /* availableTimesTemp: {
      startTime: null,
      endTime: null
    }, */
    date: "",
    selectedTime: null,
    meetingData: {
      name: "Sales manager",
      duration: 50,
      location: "Scranton, Pennsylvania",
      description: "",
      timezone: "Europe/Kiev",
      startDate: "2020-09-08 11:00:00",
      color: "red",
      slug: "collaboration-with-binary-studio",
      availabilities: [
        {
          type: "one to many",
          startDate: "2020-09-08 11:00:00",
          endDate: "2020-09-18 17:00:00",
        },
        {
          type: "one to many",
          startDate: "2020-09-20 09:00:00",
          endDate: "2020-09-23 19:00:00",
        },
      ],
    },

    owner: {
      name: "Michael Scott | Dunder Mifflin",
      avatar: "https://avatars0.githubusercontent.com/u/9064066?v=4&s=460",
      companyLogo:
        "https://i.etsystatic.com/16438614/r/il/c31bd2/1806659071/il_570xN.1806659071_pn8j.jpg",
    },
    availableTimes: [
      "9:00",
      "9:30",
      "10:00",
      "10:30",
      "11:00",
      "11:30",
      "12:00",
      "12:30",
      "13:00",
      "13:30",
      "14:00",
      "14:30",
      "15:00",
      "15:30",
      "16:00",
    ],
  }),

  computed: {
    currentTimezoneStartTime() {
      return moment
        .tz(this.meetingData.startDate, this.meetingData.timezone)
        .clone()
        .tz(this.currentTimezone)
        .format();
    },
    currentTimezoneAvailabilities() {
      const formatTime = (time) => {
        return moment
          .tz(time, this.meetingData.timezone)
          .clone()
          .tz(this.currentTimezone)
          .format("YYYY-MM-DD HH:mm:ss");
      };

      return this.meetingData.availabilities.map((availability) => ({
        startDate: formatTime(availability.startDate),
        endDate: formatTime(availability.endDate),
      }));
    },
    filterTimezones() {
      return momentTimezones.tz.names().filter((zone) => {
        //console.log(zone);
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
      const getCurrentDate = (d) => {
        return moment(d)
          .tz(this.currentTimezone)
          .format();
      };
      const currentDate = moment(this.date).format();

      let availableTime = {};

      console.log(
        "this.currentTimezoneAvailabilities",
        this.currentTimezoneAvailabilities
      );

      for (let availability of this.currentTimezoneAvailabilities) {
        const currentShortStartDate = getCurrentDate(
          availability.startDate.slice(0, 10)
        );
        const currentShortEndDate = getCurrentDate(
          availability.endDate.slice(0, 10)
        );
        /* console.log(
          "availability.endDate.slice(0, 10)",
          availability.endDate.slice(0, 10)
        );
        console.log("availability.endDate", availability.endDate);
        console.log("currentDate", currentDate);
        console.log(
          "currentShortEndDate",
          moment(currentShortEndDate).format("HH:mm")
        ); */
        if (
          currentDate >= currentShortStartDate &&
          currentDate <= currentShortEndDate
        ) {
          //console.log("startDate", availability.startDate);
          availableTime.startTime = moment(availability.startDate)
            //.tz(this.currentTimezone)
            .format("HH:mm");
          //console.log("endDate", availability.endDate);
          availableTime.endTime = moment(availability.endDate)
            //.tz(this.currentTimezone)
            .format("HH:mm");
          console.log(availableTime);
          break;
        }
      }

      return availableTime;
    },
    getAllTimes() {
      let startTime = this.availableTimesRange.startTime;
      let endTime = this.availableTimesRange.endTime;
      let duration = this.meetingData.duration;
      let times = [];
      duration = +duration;
      let start = startTime.split(":")[0] * 60 + +startTime.split(":")[1];
      let end = endTime.split(":")[0] * 60 + +endTime.split(":")[1];
      while (end - start >= duration /* || (end - start <= 0 && end < 10) */) {
        /* if (end - start <= 0) {
          start = 0;
        } */
        let [hours, minutes] = [Math.trunc(start / 60), start % 60];
        hours = String(hours).length === 2 ? hours : "0" + hours;
        minutes = String(minutes).length === 2 ? minutes : minutes + "0";
        times.push(`${hours}:${minutes}`);
        start += duration;
      }
      console.log(times);
      return times;
    },
  },
  methods: {
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
        this.lang.DEC,
      ];

      if (month) {
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
        this.lang.SAT,
      ];
      let i = new Date(date).getDay(date);
      return weekDays[i];
    },
    availableDates(date) {
      const getCurrentDate = (d) => {
        return moment(d).format();
        /* return (
          moment.tz(d, this.meetingData.timezone)
          .clone()
            .tz(this.currentTimezone)
            .format()
        ); */
        /* return (
          moment(d)
            .tz(this.currentTimezone)
            .format()
        ); */
      };
      const currentDate = moment(date)
        //.tz(this.currentTimezone)
        .format();

      let present = false;

      for (let availability of this.currentTimezoneAvailabilities) {
        /* const currentShortStartDate = getCurrentDate(
          //delete
          availability.startDate.slice(0, 10)
        ); */
        const currentShortEndDate = getCurrentDate(
          //delete
          availability.endDate.slice(0, 10)
        );

        //console.log("currentShortStartDate", currentShortStartDate);

        if (
          currentDate >= getCurrentDate(availability.startDate.slice(0, 10)) &&
          currentDate <= getCurrentDate(availability.endDate.slice(0, 10))
        ) {
          /* console.log("ok currentShortEndDate", currentShortEndDate);
          console.log("ok currentDate", currentDate); */
          present = true;
          break;
        } /* else {
          console.log("false currentShortEndDate", currentShortEndDate);
          console.log("false currentDate", currentDate);
        } */
      }

      return present;
    },
  },
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

.event-info {
  display: flex;
  padding: 6px 0 6px 0;
  margin-top: 20px;
}

.event-info ~ .event-info {
  margin-top: 0px;
}

.event-info i {
  margin-right: 10px;
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
  margin: 50px 0 10px 0;
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

@media (max-width: 960px) {
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
