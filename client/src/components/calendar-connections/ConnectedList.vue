<template>
    <VCol v-if="connected.lenght" md="6" lg="6" sm="12"> </VCol>
    <VCol v-else class="text-h5 text-center">
        {{ lang.YOU_DONT_HAVE_ANY_CONNECTED_CALENDARS }}
    </VCol>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'CalendarsList',
    data: () => ({
        lang: enLang,
        connected: []
    })
};
</script>

<style scoped></style>
