<template>
    <VBtn class="export-button" outlined>
        <VRow>
            <VCol class="text-left" align-self="center">
                {{ lang.EXPORT }}
            </VCol>
            <VCol class="text-right">
                <VIcon small>mdi-export</VIcon>
            </VCol>
        </VRow>
    </VBtn>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'ExportButton',

    data: () => ({
        lang: enLang
    })
};
</script>

<style scoped>
.export-button::v-deep {
    width: 120px;
    text-transform: none;
    color: var(--v-primary-base);
}
</style>
