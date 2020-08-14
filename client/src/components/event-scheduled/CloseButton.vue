<template>
    <VBtn class="close-button primary" depressed>
        <VRow>
            <VCol class="text-left" align-self="center">
                Close
            </VCol>
            <VSpacer></VSpacer>
            <VCol class="text-right">
                <VIcon small>mdi-close</VIcon>
            </VCol>
        </VRow>
    </VBtn>
</template>

<script>
export default {
    name: 'CloseButton'
};
</script>

<style scoped>
.close-button::v-deep {
    width: 120px;
    text-transform: none;
    margin-right: 14px;
}
</style>
