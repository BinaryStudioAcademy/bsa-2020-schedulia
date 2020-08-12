<template>
    <VContainer>
        <VRow class="event-header">
            <VBtn outlined color="#281ac8">
                <VIcon>mdi-chevron-left</VIcon>
                {{ lang.ET_BACK }}
            </VBtn>
            <VSpacer></VSpacer>
            <VMenu :offset-y="true">
                <template v-slot:activator="{ on, attrs }">
                    <VBtn text v-bind="attrs" v-on="on">
                        <VIcon>mdi-menu</VIcon>
                        {{ lang.ET_MENU }}
                        <VIcon color="#281ac8">mdi-menu-down</VIcon>
                    </VBtn>
                </template>
                <VList dense>
                    <VListItem v-for="(item, index) in menuItems" :key="index">
                        <!-- add @onclick -->
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
    name: 'ETHeader',

    data: () => ({
        lang: enLang,
        menuItems: ['ET_MENU_HOME', 'ET_MENU_EDIT_EVENT_TYPE']
    })
};
</script>

<style scoped>
.event-header {
    padding: 10px 0 30px 0;
}
</style>
