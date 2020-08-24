<template>
    <div class="text-center pt-5">
        <h3>
            {{ lang.YOU_DONT_HAVE_ANY_EVENT_TYPES }}
        </h3>
        <br />
        <p>
            {{ lang.YOU_WILL_WANT_TO_ADD_EVENT_TYPE }}
        </p>
    </div>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';
export default {
    name: 'NoEventTypes',
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped></style>
