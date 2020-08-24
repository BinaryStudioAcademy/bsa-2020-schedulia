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
import { mapGetters } from 'vuex';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    name: 'ExportButton',

    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped>
.export-button::v-deep {
    width: 120px;
    text-transform: none;
    color: var(--v-primary-base);
}
</style>
