<template>
    <VContainer class="container-content">
        <VRow>
            <VCol md="6" lg="9" sm="12">
                <VCardTitle>
                    {{ lang.MY_ZOOM_ACCOUNT }}
                </VCardTitle>
                <VCardSubtitle>
                    {{ lang.INCLUDE_ZOOM_MEETING }}
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
                    {{ lang.ACTIVATE_ZOOM }}
                    <VIcon right dark>mdi-plus</VIcon>
                </VBtn>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';

import { mapGetters } from 'vuex';
import * as getters from "../../store/modules/auth/types/getters";
export default {
    name: 'ZoomIntegration',

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        }),

    },

    methods: {
        activateAccount() {
            window.location.replace(
                process.env.VUE_APP_SOCIAL_AUTH_URL + '/meetings/zoom/redirect?user=' + this.user.id
            );
        }
    }
};
</script>

<style scoped></style>
