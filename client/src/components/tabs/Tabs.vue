<template>
    <div class="tabs">
        <div class="tabs__list">
            <VContainer class="tabs__container">
                <VToolbar color="white" flat>
                    <VTabs v-model="tab">
                        <VTab v-for="item in tabs" :key="item.tab">
                            {{ item.title }}
                        </VTab>
                    </VTabs>
                </VToolbar>
            </VContainer>
        </div>
        <BorderBottom />
        <VContainer>
            <VTabsItems v-model="tab">
                <VTabItem v-for="item in tabs" :key="item.tab">
                    <VCol cols="6">
                        <VCard>
                            <VCardText>
                                <Component
                                    v-bind:is="item.component"
                                ></Component>
                            </VCardText>
                        </VCard>
                    </VCol>
                </VTabItem>
            </VTabsItems>
        </VContainer>
    </div>
</template>

<script>
import BorderBottom from '../common/GeneralLayout/BorderBottom';

export default {
    name: 'Tabs',
    components: {
        BorderBottom
    },
    props: {
        tabs: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        tab: null
    })
};
</script>

<style lang="scss" scoped>
.tabs {
    &__list {
        width: 100%;
        background: var(--v-background-lighten1);
    }

    &__container {
        padding: 0;
    }
}
</style>
