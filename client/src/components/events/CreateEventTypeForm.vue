<template>
  <VContainer>
    <!-- <div id="geocoder"></div>
    <p>{{form.location}}</p>-->
    <VCard class="mt-7">
      <VRow align="center">
        <VCol cols="2" md="1" sm="1" lg="1">
          <div>
            <img
              :src="colorById[data.color].image"
              alt
              :class="{
                'pl-3': $vuetify.breakpoint.xs,
                'pl-10': $vuetify.breakpoint.smAndUp,
              }"
            />
          </div>
        </VCol>
        <VCol cols="10" class="pl-lg-5 pl-sm-10">
          <div>
            <VCardTitle>{{ lang.CREATE_EVENT_TYPE_TITLE }}</VCardTitle>
            <VCardSubtitle>{{ data.name }}</VCardSubtitle>
          </div>
        </VCol>
      </VRow>
      <VDivider class="mx-4"></VDivider>
      <VRow>
        <VCol
          cols="10"
          offset-sm="3"
          offset-md="3"
          md="6"
          sm="6"
          :class="{ 'ml-10': $vuetify.breakpoint.xs }"
        >
          <VForm class="mt-9 mb-16" ref="form">
            <div class="mb-2">
              <label>{{ lang.EVENT_NAME_LABEL }}*</label>
            </div>

            <VTextField
              :value="data.name"
              @change="changeName"
              :rules="nameRules"
              outlined
              class="app-textfield"
              dense
            ></VTextField>

            <div class="mb-2">
              <label>{{ lang.LOCATION_LABEL }}</label>
            </div>

            <div class="mb-3">
              <VSelect
                :value="data.locationType"
                :items="items"
                @change="changeLocationType"
                outlined
                :clearable="true"
                placeholder="Option"
                dense
              >
                <template slot="selection" slot-scope="data">
                  <VFlex xs2 md1>
                    <VIcon>{{ data.item.icon }}</VIcon>
                  </VFlex>
                  <VFlex>{{ data.item.title }}</VFlex>
                </template>

                <template slot="item" slot-scope="data">
                  <VFlex xs2 md1>
                    <VIcon>{{ data.item.icon }}</VIcon>
                  </VFlex>
                  <VFlex>{{ data.item.title }}</VFlex>
                </template>
              </VSelect>
              <MapboxLocationGeocoder v-if="showGeocoder" />
            </div>

            <div class="mb-2">
              <label>{{ lang.DESCRIPTION_LABEL }}</label>
            </div>

            <VTextarea
              :value="data.description"
              @change="changeDescription"
              :rules="descRules"
              placeholder="Placeholder"
              outlined
              class="mb-3"
            ></VTextarea>

            <div class="mb-2">
              <label>{{ lang.EVENT_LINK_LABEL }}*</label>
            </div>

            <VTextField
              :rules="eventLinkRules"
              outlined
              :value="data.slug"
              @input="changeSlug"
              dense
              class="mb-4 app-textfield"
            ></VTextField>

            <div class="mb-2">
              <p>{{ lang.EVENT_COLOR_LABEL }}</p>
            </div>
            <div class="mb-12">
              <VRow>
                <div class="d-flex">
                  <VImg
                    v-for="id in colors"
                    :key="id"
                    :src="colorById[id].image"
                    alt
                    class="image-circle"
                    :class="{
                      'mr-5': $vuetify.breakpoint.xs,
                      'mr-7 ml-3': $vuetify.breakpoint.smAndUp,
                    }"
                    v-on:click="setColor(id)"
                  >
                    <VOverlay
                      absolute
                      :value="data.color === id"
                      class="rounded-circle"
                      color="eventColor"
                    >
                      <img :src="require('@/assets/images/icon_check.png')" alt />
                    </VOverlay>
                  </VImg>
                </div>
              </VRow>
            </div>
            <div>
              <VBtn
                text
                outlined
                width="114"
                class="mr-3"
                @click.stop="cancelDialog = true"
              >{{ lang.CANCEL }}</VBtn>
              <VBtn
                @click="clickNext"
                color="primary"
                class="white--text"
                width="114"
              >{{ lang.NEXT }}</VBtn>
            </div>
          </VForm>
        </VCol>
      </VRow>
    </VCard>
    <VDialog v-model="cancelDialog" width="380">
      <VCard>
        <VCardTitle class="mb-5">
          <VRow justify="center">
            <h3>{{ lang.ARE_YOU_SURE }}</h3>
          </VRow>
        </VCardTitle>
        <VCardText>
          <VRow justify="center">
            <p>{{ lang.UNSAVE_CHANGES_WILL_BE_LOST }}</p>
          </VRow>
        </VCardText>
        <VCardActions class="justify-center">
          <div class="mb-5">
            <VBtn
              color="primary"
              class="white--text mr-3"
              width="114"
              :to="{ name: 'EventTypes' }"
            >{{ lang.YES }}</VBtn>
            <VBtn text outlined width="114" @click="cancelDialog = false">
              {{
              lang.NEVERMIND
              }}
            </VBtn>
          </div>
        </VCardActions>
      </VCard>
    </VDialog>
    <VDialog :value="showMapDialog" max-width="390" persistent>
      <div class="set-location-container">
        <h3 class="mb-4">{{ lang.SET_MEETING_LOCATION }}</h3>
        <!-- <div id="geocoder"></div> -->

        <!-- <pre id="output" class="ui-output"></pre>
        <input
          type="text"
          class="geoInput"
          id="geoInput"
          placeholder="Buscar lugares"
        />-->
        <!--  <div class="basemap"> -->
        <!-- <MglMap
                        :accessToken="accessToken"
                        :mapStyle="'mapbox://styles/mapbox/streets-v11'"
                        @click="onMapClick"
                    >
                        <MglNavigationControl position="top-right" />
                        <MglGeolocateControl position="top-right" />
                        <MglMarker
                            v-if="coordinates.length"
                            :coordinates="coordinates"
                            color="red"
                        />
        </MglMap>-->
        <!-- </div> -->
        <VBtn
          color="primary"
          class="white--text mt-4"
          width="114"
          @click="onCloseMapDialog"
        >{{ lang.OK }}</VBtn>
      </div>
    </VDialog>
    <VDialog :value="showZoomDialog" max-width="390" persistent>
      <div class="set-location-container">
        <h3 class="mb-4">{{ lang.SET_MEETING_LOCATION }}</h3>
        <VTextField
          :value="form.location"
          @change="changeLocation"
          :placeholder="lang.ZOOM_CONFERENCE_LINK"
          outlined
          dense
        ></VTextField>
        <VBtn
          color="primary"
          class="white--text"
          width="114"
          @click="onCloseZoomDialog"
        >{{ lang.OK }}</VBtn>
      </div>
    </VDialog>
    <VDialog :value="showSkypeDialog" max-width="390" persistent>
      <div class="set-location-container">
        <h3 class="mb-4">{{ lang.SET_MEETING_LOCATION }}</h3>
        <VTextField
          :value="form.location"
          @change="changeLocation"
          :placeholder="lang.SKYPE_CALL_DETAILS"
          outlined
          dense
        ></VTextField>
        <VBtn
          color="primary"
          class="white--text"
          width="114"
          @click="onCloseSkypeDialog"
        >{{ lang.OK }}</VBtn>
      </div>
    </VDialog>
  </VContainer>
</template>

<script>
import * as i18nGetters from "@/store/modules/i18n/types/getters";
import { mapGetters, mapMutations } from "vuex";
import * as eventTypeMutations from "@/store/modules/eventType/types/mutations";
import * as eventTypeGetters from "@/store/modules/eventType/types/getters";
import MapboxLocationGeocoder from "./MapboxLocationGeocoder";

/* import mapboxgl from "mapbox-gl";
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";
import "@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css"; 

const VUE_APP_MAPBOX_TOKEN = process.env.VUE_APP_MAPBOX_TOKEN;*/

export default {
  name: "CreateEventTypeForm",
  components: {
    MapboxLocationGeocoder
  },
  /* created() {
    mapboxgl.accessToken = VUE_APP_MAPBOX_TOKEN;
    new mapboxgl.Map({
      container: "map",
      style: "mapbox://styles/mapbox/streets-v11", // stylesheet location
      center: [-74.5, 40], // starting position [lng, lat]
      zoom: 9, // starting zoom
    });

    var output = document.getElementById("output");
    var geoInput = document.getElementById("geoInput");
    // Initialize the geocoder control and add it to the map.
    var geocoderControl = mapboxgl.geocoder("mapbox.places");
    //geocoderControl.addTo(map);

    geoInput.onkeyup = function() {
      geocoderControl.query(geoInput.value, function(err, data) {
        output.innerHTML = "";
        for (var i = 0; i < 5; i++) {
          output.innerHTML +=
            JSON.stringify(data.results.features[i].place_name) + "<br>";
        }
      });
    }; 
  },*/
  /* mounted() {
    this.createMap();
  }, */

  data() {
    return {
      cancelDialog: false,
      showGeocoder: false,
      form: {
        name: "",
        location: "",
        locationType: "",
        description: "",
        slug: "",
        color: "yellow"
      },
      items: [
        {
          title: "address on the map",
          icon: "mdi-google-maps"
        },
        {
          title: "zoom",
          icon: "mdi-video-box"
        },
        {
          title: "skype",
          icon: "mdi-skype"
        }
      ],

      /* accessToken: VUE_APP_MAPBOX_TOKEN, */
      showMapDialog: false,
      coordinates: [],
      showZoomDialog: false,
      showSkypeDialog: false,
      colorById: {
        yellow: {
          id: "yellow",
          image: require("@/assets/images/yellow_circle.png")
        },
        red: {
          id: "red",
          image: require("@/assets/images/red_circle.png")
        },
        blue: {
          id: "blue",
          image: require("@/assets/images/blue_circle.png")
        },
        green: {
          id: "green",
          image: require("@/assets/images/green_circle.png")
        }
      },
      colors: ["yellow", "red", "blue", "green"],
      nameRules: [
        v => !!v || this.lang.PROVIDE_EVENT_NAME,
        v =>
          v.length >= 2 ||
          this.lang.EVENT_NAME_LABEL +
            " " +
            this.lang.FIELD_MUST_BE_VALUE_OR_MORE_THAN.replace("value", 2),
        v =>
          v.length <= 55 ||
          this.lang.EVENT_NAME_LABEL +
            " " +
            this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace("value", 55)
      ],
      eventLinkRules: [
        v => !!v || this.lang.PROVIDE_EVENT_LINK,
        v =>
          v.length <= 250 ||
          this.lang.EVENT_LINK_LABEL +
            " " +
            this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace("value", 250),
        v =>
          v.length >= 2 ||
          this.lang.EVENT_LINK_LABEL +
            " " +
            this.lang.FIELD_MUST_BE_VALUE_OR_MORE_THAN.replace("value", 2),

        v => /^([a-z0-9]|-|_)+$/.test(v) || this.lang.EVENT_LINK_VALID_SYMBOLS
      ],
      descRules: [
        v =>
          v.length <= 1000 ||
          this.lang.DESCRIPTION_LABEL +
            " " +
            this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace("value", 1000)
      ]
    };
  },

  /* watch: {
    placeName() {
      console.log(this.placeName);
    }
  }, */
  computed: {
    ...mapGetters("i18n", {
      lang: i18nGetters.GET_LANGUAGE_CONSTANTS
    }),
    ...mapGetters("eventType", {
      getEventTypeForm: eventTypeGetters.GET_EVENT_TYPE_FORM
    }),
    /* placeName() {
      return (
        document.querySelector(".mapboxgl-ctrl-geocoder--input") &&
        document.querySelector(".mapboxgl-ctrl-geocoder--input").value
      );
    }, */
    data() {
      return {
        ...this.getEventTypeForm,
        ...this.form
      };
    }
  },

  methods: {
    ...mapMutations("eventType", {
      setEventTypeForm: eventTypeMutations.SET_EVENT_TYPE_FORM
    }),
    /* createMap: function() {
      mapboxgl.accessToken = this.accessToken;
      var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        types: "country,region,place,postcode,locality,neighborhood,address"
      });

      geocoder.addTo("#geocoder");

      document
        .querySelector(".mapboxgl-ctrl-geocoder--input")
        .addEventListener("change", () => {
          this.form.location = document.querySelector(
            ".mapboxgl-ctrl-geocoder--input"
          ).value;
        });
      geocoder.on("clear", () => {
        console.log("clear");
        this.form.location = "";
      });
    }, */
    clickNext() {
      if (this.$refs.form.validate()) {
        this.setEventTypeForm(this.form);
        this.$router.push({ name: "newEventEdit" });
      }
    },
    setColor(id) {
      this.form.color = this.colorById[id].id;
    },
    changeName(val) {
      this.form.name = val;
      this.changeSlug(val);
    },
    changeLocationType(val) {
      this.form.locationType = val;
      this.form.location = "";
      if (!!val && val.title === "address on the map") {
        //this.showMapDialog = true;
        this.showGeocoder = true;
      } else if (!!val && val.title === "zoom") {
        this.showZoomDialog = true;
      } else if (!!val && val.title === "skype") {
        this.showSkypeDialog = true;
      }
    },
    changeLocation(val) {
      this.form.location = val;
    },
    changeDescription(val) {
      this.form.description = val;
    },
    changeSlug(val) {
      this.form.slug = val.replace(/\s/g, "-");
    },
    onMapClick(ev) {
      this.coordinates = [ev.mapboxEvent.lngLat.lng, ev.mapboxEvent.lngLat.lat];
      this.form.location = this.coordinates.toString();
    },
    onCloseMapDialog() {
      this.showMapDialog = false;
    },
    onCloseZoomDialog() {
      this.showZoomDialog = false;
    },
    onCloseSkypeDialog() {
      this.showSkypeDialog = false;
    }
  }
};
</script>

<style scoped>
/* @import "../../../node_modules/mapbox-gl/dist/mapbox-gl.css"; */
.v-text-field {
  width: 506px;
}
.v-btn {
  font-size: 13px;
  text-transform: none;
}

#map {
  width: 100px;
  height: 100px;
}

.app-textfield.error--text::v-deep .v-input__slot {
  background-color: var(--v-validationError-base);
}

.image-circle {
  cursor: pointer;
}

.image-circle:hover {
  opacity: 0.9;
}

.set-location-container {
  background-color: white;
  padding: 30px 20px 15px 20px;
}

.basemap {
  width: 350px;
  min-width: 250px;
  height: 250px;
}
</style>
