<template>
    <VRow>
        <VCol cols="8">
            <div>{{ calendar.provider }}</div>
        </VCol>
        <VCol cols="4">
            <VBtn
                class="text v-btn--flat v-btn--outlined mr-4"
                color="primary"
                dark
                @click="onClickHandle(calendar.provider)"
            >
                {{ lang.DISCONNECT }}
            </VBtn>
        </VCol>
    </VRow>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'CalendarDetails',
    data: () => ({}),
    props: {
        calendar: {
            required: true
        }
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },

    methods: {
        ...mapActions('connectedCalendars', ['disconnect']),

        async onClickHandle(provider) {
            this.disconnect(provider);
        }
    }
};
</script>

<style lang="scss" scoped>
.v-btn {
    font-size: 13px;
    text-transform: none;

    &.cancel {
        border-color: rgba(0, 0, 0, 0.12);
        background: none;
        box-shadow: none;
    }
}
</style>
