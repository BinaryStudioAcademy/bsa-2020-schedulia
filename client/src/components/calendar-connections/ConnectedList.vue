<template>
    <VCol v-if="connected" md="6" lg="6" sm="12">
        <VCol
            cols="12"
            md="4"
            lg="3"
            sm="6"
            v-for="(calendar, index) in connected.calendars"
            :key="index"
        >
            <CalendarDetails :calendar="calendar" />
        </VCol>
    </VCol>
    <VCol v-else class="text-h5 text-center">
        {{ lang.YOU_DONT_HAVE_ANY_CONNECTED_CALENDARS }}
    </VCol>
</template>

<script>
import CalendarDetails from '@/components/calendar-connections/CalendarDetails';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as getters from '@/store/modules/connectedCalendars/types/getters';
import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'CalendarsList',
    components: {
        CalendarDetails
    },

    data: () => ({}),

    async mounted() {
        await this.fetchCalendars();
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),

        ...mapGetters('connectedCalendars', {
            connected: getters.GET_ALL_CALENDARS
        })
    },

    methods: {
        ...mapActions('connectedCalendars', ['fetchCalendars'])
    }
};
</script>

<style scoped></style>
