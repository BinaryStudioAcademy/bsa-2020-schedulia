<template>
    <div class="disabled-event-conteiner">
        <h1>{{ lang.SORRY_THIS_EVENT_IS_DISABLED }}</h1>
    </div>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'DisabledEvent',
    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped>
.disabled-event-conteiner {
    min-height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.disabled-event-conteiner h1 {
    display: inline;
    color: grey;
}
</style>
