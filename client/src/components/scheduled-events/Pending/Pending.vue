<template>
    <NoEvents>{{ lang.NO_PENDING_EVENTS }}</NoEvents>
</template>

<script>
    import NoEvents from '../NoEvents';
    import enLang from '@/store/modules/i18n/en.js';

    export default {
        name: 'Pending',

        data: () => ({
            lang: enLang
        }),

        components: { NoEvents }
    };
</script>

<style scoped></style>
