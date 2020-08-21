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
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'CalendarConnections',
    components: {
        GeneralLayout,
        ConnectedCalendars
    },

    data: () => ({
        lang: enLang
    })
};
</script>
