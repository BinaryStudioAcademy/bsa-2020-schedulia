<template>
    <VContainer>
        <VCard class="mt-7">
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
                                <VCol cols="12">
                                    <VDivider></VDivider>
                                </VCol>
                                <div>
                                    <VBtn
                                            class="text mr-2 cancel v-btn--flat v-btn--outlined"
                                            :disabled="!newLogo"
                                            @click="removeImage"
                                    >{{ lang.REMOVE }}
                                    </VBtn>
                                    <label
                                        for="fileInput"
                                        class="mr-3 primary v-btn v-btn--depressed theme--light v-size--default pointer"
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
                                <div>
                                    <VBtn
                                            class="text cancel v-btn--flat v-btn--outlined"
                                            @click="resetChanges"
                                    >
                                        {{ lang.CANCEL }}
                                    </VBtn>
                                    <VBtn
                                        :disabled="logoIsNew"
                                        class="ma-2"
                                        depressed
                                        color="primary"
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
        </VCard>
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
        console.log(this.logo);
        this.newLogo = this.logo;
    },

    computed: {
        ...mapGetters('auth', {
            user: 'getLoggedUser'
        }),

        logo() {
            return this.user.branding_logo;
        },

        logoIsNew() {
            return this.logo === this.newLogo;
        }
    },

    methods: {
        ...mapActions('profile', ['saveBranding']),

        resetChanges() {
            this.newLogo = this.logo;
        },

        removeImage() {
            this.newLogo = '';
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
    .v-btn {
        font-size: 13px;
        text-transform: none;

        &.cancel {
            border-color: rgba(0, 0, 0, 0.12);
            background: none;
            box-shadow: none;
        }
    }


</style>
