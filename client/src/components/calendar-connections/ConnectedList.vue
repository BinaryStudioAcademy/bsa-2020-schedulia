<template>
    <VCol v-if="connected.lenght" md="6" lg="6" sm="12"> </VCol>
    <VCol v-else class="text-h5 text-center">
        {{ lang.YOU_DONT_HAVE_ANY_CONNECTED_CALENDARS }}
    </VCol>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'CalendarsList',
    data: () => ({
        connected: []
    }),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped></style>
