<template>
    <VApp>
        <VMain class="main">
            <Header />
            <div>
                <slot></slot>
            </div>
        </VMain>
    </VApp>
</template>

<script>
import Header from '@/components/eventType/Header.vue';

export default {
    name: 'ETGeneralLayout',
    components: {
        Header
    }
};
</script>

<style lang="scss" scoped>
.main {
    background-color: var(--v-background-base);
    font-family: 'Inter', sans-serif;
}
</style>
