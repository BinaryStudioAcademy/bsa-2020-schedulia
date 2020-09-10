<template>
    <VContainer class="container-content">
        <VRow>
            <VCol md="6" lg="9" sm="12">
                <VCardTitle>
                    {{ lang.MY_WHALE_ACCOUNT }}
                    <img
                        :src="require('@/assets/images/active.png')"
                        class="ml-5"
                        v-if="user.whale_active"
                    />
                </VCardTitle>
                <VCardSubtitle>
                    {{ lang.INCLUDE_WHALE_MEETING }}
                </VCardSubtitle>
            </VCol>
            <VSpacer></VSpacer>
            <VCol>
                <VBtn
                    v-if="user.whale_active"
                    class="mt-2 mr-4"
                    color="red"
                    v-on="on"
                    @click="deactivateAccount"
                >
                    {{ lang.DEACTIVATE }}
                    <VIcon right>mdi-window-close</VIcon>
                </VBtn>
                <VBtn
                    v-else
                    class="mt-2 mr-4"
                    color="green"
                    v-on="on"
                    @click="activateAccount"
                >
                    <span class="whale_account">{{
                        lang.ACTIVATE_WHALE_ACCOUNT
                    }}</span>
                </VBtn>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions, mapGetters } from 'vuex';
import * as getters from '../../store/modules/auth/types/getters';
export default {
    name: 'WhaleIntegration',

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        })
    },

    methods: {
        ...mapActions('auth', {
            changeWhaleActivity: actions.CHANGE_WHALE_STATUS_ACTIVITY
        }),
        async activateAccount() {
            await this.changeWhaleActivity({
                whale_active: true
            });
            let win = window.open(
                'https://bsa2020-whale.westeurope.cloudapp.azure.com/',
                '_blank'
            );
            win.focus();
        },

        async deactivateAccount() {
            await this.changeWhaleActivity({
                whale_active: false
            });
        }
    }
};
</script>

<style scoped>
.whale_account {
    color: white;
}
</style>
