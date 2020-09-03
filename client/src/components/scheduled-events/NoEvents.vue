<template>
    <VContainer class="no-events">
        <VRow class="text-center">
            <VCol align-self="center" v-if="noFound">
                <img class="" :src="require('@/assets/images/no-found.svg')" />
                <div class="no-events-title">
                    {{ lang.NO_EVENTS_FOUND }}
                </div>
            </VCol>
            <VCol align-self="center" v-else>
                <img class="" :src="require('@/assets/images/no-events.svg')" />
                <div class="no-events-title">
                    <slot></slot>
                </div>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'NoEvents',

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },

    methods: {
        noFound() {
            if (
                    this.$route.query.event_types ||
                    this.$route.query.event_emails ||
                    this.$route.query.event_status ||
                    this.$route.query.tags ||
                    this.$route.query.search
            ) {
                return true;
            }
        }
    }
};
</script>

<style scoped></style>
