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
import enLang from '@/store/modules/i18n/en';
import momentTimezone from 'moment-timezone';

export default {
    name: 'TimeZoneSelect',
    props: {
        value: {},
        defaultValue: {}
    },

    data: () => ({
        lang: enLang,
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
