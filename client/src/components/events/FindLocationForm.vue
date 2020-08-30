<template>
    <div />
</template>
<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import places from 'places.js';
import { mapMutations, mapGetters } from 'vuex';
import * as eventTypeMutations from '@/store/modules/eventType/types/mutations';

const VUE_APP_ALGOLIA_API_KEY = process.env.VUE_APP_ALGOLIA_API_KEY;
const VUE_APP_ALGOLIA_APP_ID = process.env.VUE_APP_ALGOLIA_APP_ID;

export default {
    name: 'FindLocationForm',
    data() {
        return {
            placesAutocomplete: null
        };
    },
    beforeDestroy() {
        this.placesAutocomplete.destroy();
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },
    mounted() {
        this.input = document.createElement('input');
        this.input.setAttribute('placeholder', this.lang.PICK_NEEDED_LOCATION);
        this.input.setAttribute('type', 'search');
        this.$el.appendChild(this.input);

        this.placesAutocomplete = places({
            appId: VUE_APP_ALGOLIA_APP_ID,
            apiKey: VUE_APP_ALGOLIA_API_KEY,
            container: this.input
        });
        this.placesAutocomplete.configure({
            language: 'en'
        });
        this.placesAutocomplete.on('change', e => {
            const [lat, lng] = [
                e.suggestion.latlng.lat,
                e.suggestion.latlng.lng
            ];
            this.setEventTypeFormLocation([lng, lat]);
        });
    },
    methods: {
        ...mapMutations('eventType', {
            setEventTypeFormLocation:
                eventTypeMutations.SET_EVENT_TYPE_FORM_LOCATION
        })
    }
};
</script>
<style scoped></style>
