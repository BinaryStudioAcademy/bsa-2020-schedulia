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
        <VContainer class="container-content">
            <VTabsItems
                v-model="tab"
                :class="{ 'background-none': isEventTypesPage }"
            >
                <VTabItem v-for="item in tabs" :key="item.tab">
                    <VCol cols="12" v-if="isEventTypesPage">
                        <Component v-bind:is="item.component"></Component>
                    </VCol>
                    <VCol cols="6" v-else>
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
        },
        pageType: {
            type: String,
            required: false
        }
    },
    data: () => ({
        tab: null
    }),
    computed: {
        isEventTypesPage() {
            return this.pageType === 'event-types-page';
        }
    }
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
.v-tab {
    text-transform: none;
}
.background-none {
    background: none;
}
</style>
