<template>
    <NoEvents>{{ lang.NO_PENDING_EVENTS }}</NoEvents>
</template>

<script>
import NoEvents from '../NoEvents';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'Pending',

    data: () => ({}),

    components: { NoEvents },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped></style>
