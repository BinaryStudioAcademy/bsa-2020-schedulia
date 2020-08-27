<template>
    <VRow justify="end" class="mr-2">
        <VMenu bottom origin="center center" transition="scale-transition">
            <template v-slot:activator="{ on, attrs }">
                <VBtn
                    class="ma-2"
                    outlined
                    color="indigo"
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ lang.ADD_CALENDAR_ACCOUNT }}
                    <VIcon right dark>mdi-plus</VIcon>
                </VBtn>
            </template>

            <VList>
                <VListItem
                    v-for="(calendar, i) in calendars"
                    :key="i"
                    @click="onClickHandle(calendar.provider)"
                >
                    <VListItemTitle>
                        <VIcon>{{ calendar.ico }}</VIcon>
                        {{ calendar.title }}
                    </VListItemTitle>
                </VListItem>
            </VList>
        </VMenu>
    </VRow>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'CalendarsList',
    data: () => ({
        calendars: [
            {
                title: 'Google',
                provider: 'google',
                ico: 'mdi-google'
            },
            {
                title: 'iCal',
                provider: 'iCal',
                ico: 'mdi-apple'
            }
        ]
    }),

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },

    methods: {
        ...mapActions('connectedCalendars', ['connect']),

        async onClickHandle(provider) {
            const response = await this.connect(provider);

            if(response.url) {
                window.open(response.url);
            }
        }
    }
};
</script>

<style scoped></style>
