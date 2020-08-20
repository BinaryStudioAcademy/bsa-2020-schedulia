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
                    @click="() => {}"
                >
                    <VListItemTitle>
                        <VIcon>mdi-google</VIcon>
                        {{ calendar.title }}
                    </VListItemTitle>
                </VListItem>
            </VList>
        </VMenu>
    </VRow>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'CalendarsList',
    data: () => ({
        lang: enLang,
        calendars: [
            {
                title: 'Google'
            }
        ]
    })
};
</script>

<style scoped></style>
