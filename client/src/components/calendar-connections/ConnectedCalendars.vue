<template>
    <VContainer class="container-content">
        <VRow>
            <VCol md="6" lg="6" sm="12">
                <VCardTitle>
                    {{ lang.MY_CALENDAR_ACOOUNT }}
                </VCardTitle>
                <VCardSubtitle>
                    {{ lang.CONNECT_YOUR_CALENDAR_TEXT }}
                </VCardSubtitle>
            </VCol>
            <VCol md="6" lg="6" sm="12">
                <CalendarsList />
            </VCol>
        </VRow>
        <VRow>
            <VCol>
                <ConnectedList />
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
import CalendarsList from '@/components/calendar-connections/CalendarsList.vue';
import ConnectedList from '@/components/calendar-connections/ConnectedList.vue';

export default {
    name: 'ConnectedCalendars',
    components: {
        CalendarsList,
        ConnectedList
    },
    data: () => ({
        lang: enLang,
        connectedAccounts: []
    })
};
</script>

<style scoped></style>
