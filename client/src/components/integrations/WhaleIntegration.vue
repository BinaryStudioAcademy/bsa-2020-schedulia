<template>
    <VContainer class="container-content">
        <VRow>
            <VCol md="6" lg="9" sm="12">
                <VCardTitle>
                    {{ lang.MY_WHALE_ACCOUNT }}
                </VCardTitle>
                <VCardSubtitle>
                    {{ lang.INCLUDE_WHALE_MEETING }}
                </VCardSubtitle>
            </VCol>
            <VSpacer></VSpacer>
            <VCol>
                <VBtn
                    class="mt-2 mr-4"
                    outlined
                    color="indigo"
                    v-bind="attrs"
                    v-on="on"
                    @click="activateAccount"
                >
                    {{ lang.ACTIVATE_WHALE_ACCOUNT }}
                </VBtn>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';
export default {
    name: 'WhaleIntegration',

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },

    methods: {
        activateAccount() {
            let win = window.open(
                'https://bsa2020-whale.westeurope.cloudapp.azure.com/',
                '_blank'
            );
            win.focus();
        }
    }
};
</script>

<style scoped></style>
