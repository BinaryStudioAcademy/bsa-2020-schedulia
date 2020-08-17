<template>
    <VBtn class="export-button" outlined>
        <VRow>
            <VCol class="text-left" align-self="center">
                Export
            </VCol>
            <VCol class="text-right">
                <VIcon small>mdi-export</VIcon>
            </VCol>
        </VRow>
    </VBtn>
</template>

<script>
export default {
    name: 'ExportButton'
};
</script>

<style scoped>
.export-button::v-deep {
    width: 120px;
    text-transform: none;
    color: var(--v-primary-base);
}
</style>
