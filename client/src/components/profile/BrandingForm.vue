<template>
    <VForm>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <VSubheader>
                        {{ lang.LOGO }}
                        <Tooltip>
                            <p>{{ lang.PROFILE_USE_THIS_SETTING_LOGO_TEXT }}</p>
                            <p>{{ lang.PROFILE_YOU_LOGO_WILL_APPEAR_TEXT }}</p>
                        </Tooltip>
                    </VSubheader>
                </VCol>
                <VCol cols="12">
                    <div>
                        <div v-if="newLogo">
                            <VImg :src="newLogo"></VImg>
                        </div>
                        <div v-else>
                            <VImg src="@/assets/images/no-image.png"></VImg>
                        </div>
                    </div>
                    <div class="text-center">
                        <VBtn
                            class="ma-2"
                            tile
                            color="blue darken-1"
                            @click="$refs.inputUpload.click()"
                        >
                            {{ lang.UPDATE }}
                        </VBtn>

                        <label>
                            <input
                                v-show="false"
                                ref="inputUpload"
                                type="file"
                                accept="image/*"
                                @change="updateImage"
                            />
                        </label>

                        <VBtn class="ma2" v-if="logo" tile @click="removeImage"
                            >{{ lang.REMOVE }}
                        </VBtn>
                        <VAlert cols="12" type="error" v-if="errorMessage">
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
                        <VBtn
                            class="ma-2"
                            tile
                            outlined
                            color="blue darken-1"
                            @click="save"
                            :disabled=logoIsNew
                            >{{ lang.SAVE }}
                        </VBtn>
                        <VBtn class="ma2" tile outlined @click="resetChanges">
                            {{ lang.CANCEL }}
                        </VBtn>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
    </VForm>
</template>

<script>
import { mapActions } from 'vuex';
import enLang from '@/store/modules/i18n/en.js';
import uploadFileService from '@/services/upload/fileService';
import Tooltip from '@/components/tooltip/TooltipIcon.vue';

export default {
    name: 'BrandingForm',
    components: {
        Tooltip
    },
    data: () => ({
        lang: enLang,
        file: null,
        logo: null,
        newLogo: null,
        errorMessage: ''
    }),

    async mounted() {
        const response = await uploadFileService.getFile();
        this.logo = this.newLogo = response.data.file;
    },

    computed: {
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
                
                await this.uploadBrandingLogo(this.file);
                await this.saveBranding();
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
