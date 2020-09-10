<template>
    <VContainer class="container-content">
        <VRow>
            <VCol md="6" lg="9" sm="12">
                <VCardTitle>
                    {{ lang.MY_ZOOM_ACCOUNT }}
                    <img
                        :src="require('@/assets/images/active.png')"
                        class="ml-5"
                        v-if="user.zoom_active"
                    />
                </VCardTitle>
                <VCardSubtitle>
                    {{ lang.INCLUDE_ZOOM_MEETING }}
                </VCardSubtitle>
            </VCol>
            <VSpacer></VSpacer>
            <VCol>
                <VBtn
                    v-if="user.zoom_active"
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
                    class="mt-2 mr-4 activate_zoom"
                    color="green"
                    v-bind="attrs"
                    v-on="on"
                    @click="activateAccount"
                >
                    <span class="activate-zoom">
                        {{ lang.ACTIVATE_ZOOM }}
                    </span>
                </VBtn>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import requestService from '../../services/requestService';
import { mapGetters, mapActions } from 'vuex';
import * as getters from '../../store/modules/auth/types/getters';
import * as actions from '@/store/modules/auth/types/actions';
export default {
    name: 'ZoomIntegration',

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
            changeZoomActivity: actions.CHANGE_ZOOM_STATUS_ACTIVITY
        }),
        async activateAccount() {
            await requestService.put('/zoom-status', { zoom_active: true });
            window.location.replace(
                process.env.VUE_APP_SOCIAL_AUTH_URL +
                    '/meetings/zoom/redirect?user=' +
                    this.user.id
            );
        },

        async deactivateAccount() {
            await this.changeZoomActivity({
                zoom_active: false
            });
        }
    }
};
</script>

<style scoped>
.activate-zoom {
    color: white;
}
</style>
