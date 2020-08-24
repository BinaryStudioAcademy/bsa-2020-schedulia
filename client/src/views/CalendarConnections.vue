<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.CALENDAR_CONNECTIONS }}
        </template>
        <ConnectedCalendars />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import ConnectedCalendars from '@/components/calendar-connections/ConnectedCalendars.vue';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'CalendarConnections',
    components: {
        GeneralLayout,
        ConnectedCalendars
    },
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>
