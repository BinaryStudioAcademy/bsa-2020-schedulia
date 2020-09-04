<template>
    <div class="tabs">
        <div class="tabs__list">
            <VContainer class="tabs__container">
                <VToolbar color="white" dense flat>
                    <VRow align="end">
                        <VCol class="text-left">
                            <VTabs v-model="tab">
                                <VTab
                                    v-for="item in tabs"
                                    :key="item.tab"
                                    :to="{ name: item.routeName }"
                                >
                                    {{ item.title }}
                                </VTab>
                                <slot name="left-side"></slot>
                            </VTabs>
                        </VCol>
                        <VCol class="text-right" align-self="center">
                            <slot name="right-side"></slot>
                        </VCol>
                    </VRow>
                </VToolbar>
            </VContainer>
        </div>
        <BorderBottom />
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

    .v-tab--active[aria-selected='false'] {
        color: rgba(0, 0, 0, 0.54);
    }
}
.v-tab {
    text-transform: none;
}
</style>
