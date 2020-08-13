<template>
    <VApp>
        <VMain class="main">
            <div>
                <slot></slot>
            </div>
        </VMain>
    </VApp>
</template>

<script>
export default {
    name: 'GeneralLayout'
};
</script>

<style lang="scss" scoped>
.main {
    background-color: var(--v-background-base);
    font-family: $body-font-family;
}
</style>
