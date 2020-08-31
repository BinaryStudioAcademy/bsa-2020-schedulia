import moment from "moment";
const now = moment();
export default {
  eventTypes: {
    eventTypeById: {},
    eventTypes: [],
  },
  eventType: {
    name: "",
    location: "",
    coordinates: [],
    locationType: "",
    description: "",
    slug: "",
    color: "yellow",
    disabled: true,
    duration: 30,
    customDuration: 0,
    timezone: "",
    radioTimeZone: "Local",
    dateRange: {
      type: "date_range",
      scheduleType: "period",
      subType: "date_range",
      value: 60,
      date: [],
      startDate: now.format("YYYY-MM-DD"),
      endDate: now.add(59, "days").format("YYYY-MM-DD"),
      startTime: "09:00",
      endTime: "17:00",
    },
    availabilities: {},
    selectDay: "",
  },
  dayAvailabilities: [],
  visibleAvailabilityDialog: false,
  visibleTimeZoneDialog: false,
  visibleDayAvailabilitiesDialog: false,
};
