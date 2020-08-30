<template>
  <div>
    <div id="geocoder-cont"></div>
    <p>{{form.location}}</p>
  </div>
</template>

<script>
import mapboxgl from "mapbox-gl";
import MapboxGeocoder from "@mapbox/mapbox-gl-geocoder";
import "@mapbox/mapbox-gl-geocoder/dist/mapbox-gl-geocoder.css";

const VUE_APP_MAPBOX_TOKEN = process.env.VUE_APP_MAPBOX_TOKEN;

export default {
  name: "MapboxLocationGeocoder",
  data() {
    return {
      form: {
        location: ""
      },
      accessToken: VUE_APP_MAPBOX_TOKEN
    };
  },
  mounted() {
    this.createMap();
  },
  methods: {
    createMap: function() {
      mapboxgl.accessToken = this.accessToken;
      var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken
      });

      geocoder.addTo("#geocoder-cont");

      document
        .querySelector(".mapboxgl-ctrl-geocoder--input")
        .addEventListener("change", () => {
          this.form.location = document.querySelector(
            ".mapboxgl-ctrl-geocoder--input"
          ).value;
          console.log("this.form.location", this.form.location);
        });

      document
        .querySelector(".mapboxgl-ctrl-geocoder--button")
        .addEventListener("click", () => {
          this.form.location = "";
        });
    }
  }
};
</script>

<style scoped>
</style>