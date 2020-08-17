<template>
    <VContainer>
        <VRow class="event-header">
            <VBtn outlined color="primary">
                <VIcon>mdi-chevron-left</VIcon>
                {{ lang.ET_BACK }}
            </VBtn>
            <VSpacer></VSpacer>
            <VMenu :offset-y="true">
                <template v-slot:activator="{ on, attrs }">
                    <VBtn text v-bind="attrs" v-on="on">
                        <VIcon>mdi-menu</VIcon>
                        {{ lang.ET_MENU }}
                        <VIcon color="primary">mdi-menu-down</VIcon>
                    </VBtn>
                </template>
                <VList dense>
                    <VListItem v-for="(item, index) in menuItems" :key="index">
                        <VListItemTitle>{{ lang[item] }}</VListItemTitle>
                    </VListItem>
                </VList>
            </VMenu>
        </VRow>
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'Header',

    data: () => ({
        lang: enLang,
        menuItems: ['ET_MENU_HOME', 'ET_MENU_EDIT_EVENT_TYPE']
    })
};
</script>

<style scoped>
.header-container {
    width: 100%;
    padding: 0 20px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}
.event-header {
    padding: 10px 0 30px 0;
}
</style>
