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
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'Header',

    data: () => ({
        menuItems: ['ET_MENU_HOME', 'ET_MENU_EDIT_EVENT_TYPE']
    }),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
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
