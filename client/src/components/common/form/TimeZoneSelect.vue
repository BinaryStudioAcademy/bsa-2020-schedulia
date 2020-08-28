<template>
    <div>
        <VSubheader>{{ lang.TIME_ZONE }}</VSubheader>
        <VSelect
            :value="inputValue"
            :items="timeZones"
            :placeholder="lang.TIME_ZONE"
            @change="onChange"
            dense
            required
            outlined
        ></VSelect>
    </div>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import momentTimezone from 'moment-timezone';
import { mapGetters } from 'vuex';

export default {
    name: 'TimeZoneSelect',
    props: {
        value: {},
        defaultValue: {}
    },

    data: () => ({
        timeZones: null
    }),

    created() {
        const timeZones = momentTimezone.tz.names();
        const offsetTimemZones = timeZones.map(timeZone => {
            return {
                value: timeZone,
                text: `(GMT ${momentTimezone
                    .tz(timeZone)
                    .format('Z')}) ${timeZone}`
            };
        });

        this.timeZones = offsetTimemZones;
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        inputValue() {
            return this.value || this.defaultValue;
        }
    },

    methods: {
        onChange(value) {
            this.$emit('change', value);
        }
    }
};
</script>

<style scoped></style>
