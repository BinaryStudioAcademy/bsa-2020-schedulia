<template>
    <VContainer class="container-content">
        <VRow justify="center">
            <VCol cols="6">
                <VForm>
                    <VContainer>
                        <VRow>
                            <VCol cols="12">
                                <VSubheader>
                                    {{ lang.LOGO }}
                                    <Tooltip>
                                        <p>
                                            {{
                                                lang.PROFILE_USE_THIS_SETTING_LOGO_TEXT
                                            }}
                                        </p>
                                        <p>
                                            {{
                                                lang.PROFILE_YOU_LOGO_WILL_APPEAR_TEXT
                                            }}
                                        </p>
                                    </Tooltip>
                                </VSubheader>
                            </VCol>
                            <VCol cols="12">
                                <div>
                                    <div v-if="newLogo">
                                        <VImg :src="newLogo"></VImg>
                                    </div>
                                    <div v-else>
                                        <VImg
                                            :src="
                                                require('@/assets/images/no-image.png')
                                            "
                                        ></VImg>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <label
                                        for="fileInput"
                                        class="ma-2 v-btn v-btn--contained v-btn--tile theme--light v-size--default blue darken-1 pointer"
                                    >
                                        {{ lang.UPDATE }}
                                    </label>

                                    <input
                                        v-show="false"
                                        id="fileInput"
                                        type="file"
                                        accept="image/*"
                                        @change="updateImage"
                                    />

                                    <VBtn
                                        class="ma2"
                                        :disabled="!newLogo"
                                        tile
                                        @click="removeImage"
                                        >{{ lang.REMOVE }}
                                    </VBtn>
                                    <VAlert
                                        cols="12"
                                        type="error"
                                        v-if="errorMessage"
                                    >
                                        {{ errorMessage }}
                                    </VAlert>
                                </div>
                            </VCol>
                            <VCol cols="12">
                                <VSpacer></VSpacer>
                                <VDivider></VDivider>
                                <VSpacer></VSpacer>
                            </VCol>
                            <VCol>
                                <div class="text-center">
                                    <VBtn class="ma2" @click="resetChanges">
                                        {{ lang.CANCEL }}
                                    </VBtn>
                                    <VBtn
                                        :disabled="logoIsNew"
                                        class="ma-2 login-button  primary"
                                        depressed
                                        color="primary"
                                        dark
                                        @click="save"
                                        >{{ lang.SAVE }}
                                    </VBtn>
                                </div>
                            </VCol>
                        </VRow>
                    </VContainer>
                </VForm>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import enLang from '@/store/modules/i18n/en.js';
import Tooltip from '@/components/tooltip/TooltipIcon.vue';

export default {
    name: 'BrandingForm',
    components: {
        Tooltip
    },
    data: () => ({
        lang: enLang,
        file: null,
        newLogo: null,
        errorMessage: ''
    }),

    mounted() {
        this.newLogo = this.logo;
    },

    computed: {
        ...mapGetters('profile', {
            logo: 'getBrandingLogo'
        }),

        logoIsNew() {
            return this.logo === this.newLogo;
        }
    },

    methods: {
        ...mapActions('profile', ['uploadBrandingLogo', 'saveBranding']),

        resetChanges() {
            this.newLogo = this.logo;
        },

        removeImage() {
            this.newLogo = null;
        },

        updateImage(event) {
            this.file = event.target.files[0];
            this.newLogo = URL.createObjectURL(this.file);
        },

        async save() {
            try {
                await this.saveBranding(this.file);
            } catch (error) {
                this.showErrorMessage(error.message);
            }
        },

        showErrorMessage(msg) {
            this.errorMessage = msg;
        }
    }
};
</script>

<style lang="scss" scoped>
.pointer {
    cursor: pointer;
}
</style>
