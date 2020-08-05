<template>
    <VContainer>
        <VToolbar color="white" flat>
            <VTabs v-model="tab">
                <VTab v-for="item in tabs" :key="item.tab">
                    {{ item.title }}
                </VTab>
            </VTabs>
        </VToolbar>

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
    </VContainer>
</template>

<script>
export default {
    name: 'Tabs',
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
