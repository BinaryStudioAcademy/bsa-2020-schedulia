<template>
    <div>
        <VSubheader>{{ lang.TIME_ZONE }}</VSubheader>
        <VSelect
            :value="inputValue"
            :items="timeZones"
            :placeholder="label"
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
        let offsetTimemZones = [];

        for (let i in timeZones) {
            offsetTimemZones.push({
                value: timeZones[i],
                text: `(GMT ${momentTimezone.tz(timeZones[i]).format('Z')}) ${
                    timeZones[i]
                }`
            });
        }

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
