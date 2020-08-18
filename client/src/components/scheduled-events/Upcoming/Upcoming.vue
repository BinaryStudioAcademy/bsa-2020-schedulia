<template>
    <NoEvents>{{ lang.NO_UPCOMING_EVENTS }}</NoEvents>
</template>

<script>
import NoEvents from '../NoEvents';
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'Upcoming',

    data: () => ({
        lang: enLang
    }),

    components: { NoEvents }
};
</script>

<style scoped></style>
