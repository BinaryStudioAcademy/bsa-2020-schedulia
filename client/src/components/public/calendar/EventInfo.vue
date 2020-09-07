<template>
  <DetailLayout :brandingLogo="brandingLogo" :avatar="avatar" :name="name" :eventName="eventName">
    <div class="event-info">
      <VIcon dark color="primary">mdi-clock-outline</VIcon>
      {{ duration }} {{ lang.DURATION_MIN }}
    </div>
    <div v-if="showLocation" class="event-info">
      <VIcon dark color="primary">mdi-map-marker</VIcon>
      <VBtn @click="onOpenMap">open</VBtn>
      {{ location }}
    </div>
    <div v-if="startDate" class="event-info">
      <VIcon dark color="primary">mdi-calendar-blank</VIcon>
      {{ startDate }}
    </div>
    <div v-if="timezone" class="event-info">
      <VIcon dark color="primary">mdi-earth</VIcon>
      {{ timezone }}
    </div>
    <div class="event-info">{{ description }}</div>
    <VDialog :value="showMapDialog" width="380" persistent>
      <LocationMap :coordinates="coordinates" />
      <VBtn color="primary" class="white--text" width="114" @click="onCloseMap">{{ lang.OK }}</VBtn>
    </VDialog>
  </DetailLayout>
</template>

<script>
import DetailLayout from "@/components/public/calendar/DetailLayout";
import LocationMap from "@/components/public/calendar/LocationMap";

export default {
  name: "EventInfo",
  components: {
    DetailLayout,
    LocationMap
  },
  props: {
    lang: Object,
    brandingLogo: String,
    avatar: String,
    name: String,
    eventName: String,

    duration: Number,
    locationType: String,
    address: String,
    coordinates: Object,
    description: String,
    startDate: String,
    timezone: String
  },
  data: () => ({
    showMapDialog: false
  }),
  computed: {
    showLocation() {
      if (this.locationType === "address") {
        if (this.address) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    },
    location() {
      if (this.locationType === "address") {
        return this.address;
      }
      return "Zoom meeting";
    }
  },
  methods: {
    onOpenMap() {
      this.showMapDialog = true;
    },
    onCloseMap() {
      this.showMapDialog = false;
    }
  }
};
</script>

<style scoped>
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
</style>
