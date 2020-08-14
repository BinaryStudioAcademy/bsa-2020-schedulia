<template>
    <VContainer class="container-content">
        <Tabs :tabs="tabs">
            <template v-slot:right-side>
                <CloseButton />
                <ExportButton />
            </template>
        </Tabs>
    </VContainer>
</template>

<script>
import Tabs from '@/components/tabs/Tabs.vue';
import Upcoming from './Upcoming/Upcoming';
import Pending from './Pending/Pending';
import Past from './Past/Past';
import enLang from '@/store/modules/i18n/en.js';
import CloseButton from './CloseButton';
import ExportButton from './ExportButton';

export default {
    name: 'EventScheduledList',

    components: {
        ExportButton,
        CloseButton,
        Tabs
    },
    data: () => ({
        tabs: [
            { title: enLang.UPCOMING, component: Upcoming },
            { title: enLang.PENDING, component: Pending },
            { title: enLang.PAST, component: Past },
            { title: enLang.DATE_RANGE }
        ]
    })
};
</script>

<style scoped></style>
