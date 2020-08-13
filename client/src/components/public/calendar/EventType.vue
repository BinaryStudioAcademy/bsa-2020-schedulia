<template>
  <VContainer>
    <VRow class="main">
      <VCol :class="colEventInfoClass">
        <DatailLayout>
          <div class="event-info">
            <VIcon dark color="primary">mdi-clock-outline</VIcon>
            15 {{ lang.ET_MIN }}
          </div>
          <div class="event-info">
            <VIcon dark color="primary">mdi-map-marker</VIcon>Scranton,
            Pennsylvania
          </div>
        </DatailLayout>
      </VCol>

      <VCol class="calendar-container col-sm-7 col-md-5">
        <div class="calendar-content">
          <h3>{{ lang.ET_SELECT_DATE_AND_TIME }}</h3>
          <VDatePicker
            v-model="date"
            min="2020-08-10"
            :first-day-of-week="1"
            :weekday-format="getDay"
            :header-date-format="dateFormat"
            no-title
            width="390"
            color="primary"
            flat
            is-inline
          ></VDatePicker>
        </div>
      </VCol>

      <VCol v-if="show" sm="12" md="3" class="select-time-container">
        <h3>{{ formatteddDate }}</h3>
        <div class="time-itms-container">
          <div v-for="(item, i) in times" :key="i" text>
            <div v-if="selectedTime === i">
              <div class="confirm-event">
                <VCard elevation="0" class="selected-time-card align-center">
                  <VCardText dense class="text-center pa-0 justify-center">
                    {{ item }}
                  </VCardText>
                </VCard>
                <VBtn class="select-time-btn" depressed color="primary" dark>
                  {{ lang.ET_CONFIRM_DATE }}
                </VBtn>
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
  </VContainer>
</template>

<script>
import moment from "moment";
import enLang from "@/store/modules/i18n/en";
import DatailLayout from "./DatailLayout";

const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

export default {
  name: "EventType",
  components: {
    DatailLayout,
  },
  data: () => ({
    lang: enLang,
    date: "",
    selectedTime: null,
    times: [
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
    colEventInfoClass() {
      const base = "event-info-container";
      let size;
      if (this.show) {
        size = "col-md-3 col-sm-12";
      } else {
        size = "col-md-6 col-sm-12";
      }
      return [base, size];
    },
    show() {
      return this.date === "" ? false : true;
    },
    formatteddDate() {
      return moment(this.date).format("dddd, MMMM DD");
    },
  },
  methods: {
    dateFormat(date) {
      console.log("dateFormat", date);
      const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ];
      const [year, month] = date.split("-");
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
      let i = new Date(date).getDay(date);
      return daysOfWeek[i];
    },
  },
};
</script>

<style>
.main {
  box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
  background-color: #fff;
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

.event-info-container {
  padding: 0;
  border-right: 2px solid rgb(243, 247, 247);
}

.calendar-container {
  border-right: 2px solid rgb(243, 247, 247);
  min-width: 420px;
  margin: 0 !important;
}

.calendar-content {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  justify-content: center;
}

.calendar-container h3 {
  margin: 50px 0 10px 70px;
  min-width: 420px;
}

.select-time-container {
  margin: 0 auto !important;
}

.select-time-container h3 {
  margin: 50px 0 10px 0;
}

.time-itms-container {
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
  border: 1px solid #281ac8;
  color: #281ac8;
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
  border: 1px solid #281ac8 !important;
  padding: 6px;
}

.selected-time-card div {
  color: #281ac8 !important;
  font-weight: bold !important;
}

.v-date-picker-header {
  justify-content: flex-start !important;
  margin-bottom: 20px;
}

.v-date-picker-header__value {
  flex: none !important;
}

.v-date-picker-header__value button {
  font-weight: normal !important;
  color: #636363 !important;
}

.mdi-chevron-right {
  color: #281ac8 !important;
}
.mdi-chevron-left {
  color: #281ac8 !important;
}

::-webkit-scrollbar {
  width: 3px;
}

::-webkit-scrollbar-thumb {
  background: #281ac8;
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
  .event-header button {
    margin-left: 20px;
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
  .calendar-container h3 {
    margin-left: 20px;
  }
}

@media (max-width: 415px) {
  .calendar-container {
    margin: 20px 0;
  }
}
</style>
