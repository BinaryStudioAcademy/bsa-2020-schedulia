<template>
  <div class="main">
    <div class="confirm-container">
      <VRow>
        <VCol sm="12" md="4" class="event-datail">
          <DatailLayout>
            <div class="event-info">
              <VIcon dark color="primary">mdi-clock-outline</VIcon>
              15 {{ lang.ET_MIN }}
            </div>
            <div class="event-info">
              <VIcon dark color="primary">mdi-map-marker</VIcon>Scranton,
              Pennsylvania
            </div>
            <div class="event-info">
              <VIcon dark color="primary">mdi-calendar-blank</VIcon>10:00-10:15,
              Monday, July 20, 2020
            </div>
            <div class="event-info">
              <VIcon dark color="primary">mdi-earth</VIcon>Eastern European Time
            </div>
          </DatailLayout>
        </VCol>
        <VCol sm="7" class="event-confirm-field">
          <h3>Enter Details</h3>

          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
          <h4>something else</h4>
        </VCol>
      </VRow>
    </div>
  </div>
</template>

<script>
import enLang from "@/store/modules/i18n/en";
import DatailLayout from "./DatailLayout";

export default {
  name: "ConfirmEventType",
  components: {
    DatailLayout,
  },
  data: () => ({
    lang: enLang,
  }),
};
</script>

<style>
.main {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: flex-start;
}

.confirm-container {
  margin-top: 50px;
  box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
  background-color: #fff;
  width: 70%;
  height: 70%;
  max-width: 1000px;
  max-height: 900px;
}

.confirm-container > div {
  margin: 0;
  padding: 0;
}

.event-datail {
  min-width: 250px;
  margin: 0;
  padding: 0;
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

.event-confirm-field {
  min-width: 300px;
  margin: 0;
  padding: 50px;
}

@media screen and (max-width: 960px) {
  .confirm-container {
    width: 90%;
    height: 80%;
  }
  .event-confirm-field {
    min-width: 290px;
  }
  .event-datail {
    min-width: 290px;
  }
}
</style>
