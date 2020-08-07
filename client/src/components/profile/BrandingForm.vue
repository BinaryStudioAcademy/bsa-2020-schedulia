<template>
    <VForm>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <VSubheader>
                        {{ lang.LOGO }}
                        <Tooltip>
                            <p>
                                Use this setting to add your logo to all of your
                                Calendly scheduling pages.
                            </p>
                            <p>
                                Your logo will appear in the top left corner of
                                your Event Type page. We recommend using an
                                image that is 440px x 220px for the best
                                display.
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
                                src="https://user-images.githubusercontent.com/194400/49531010-48dad180-f8b1-11e8-8d89-1e61320e1d82.png"
                            ></VImg>
                        </div>
                    </div>
                    <div class="text-center">
                        <VBtn
                                class="ma-2"
                                tile
                                color="blue darken-1"
                                @click="uploadImage"
                        >{{
                            lang.UPDATE
                        }}</VBtn>

                        <VFileInput
                            accept="image/*"
                            label="Logo"
                            prepend-icon="mdi-camera"
                            :hide-input=true
                        >
                        </VFileInput>

                        <VBtn
                                class="ma2"
                                v-if="logo"
                                tile
                                @click="removeImage"
                        >{{
                            lang.REMOVE
                        }}</VBtn>
                    </div>
                </VCol>
                <VCol cols="12">
                    <VSpacer></VSpacer>
                    <VDivider></VDivider>
                    <VSpacer></VSpacer>
                </VCol>
                <VCol>
                    <div class="text-center">
                        <VBtn class="ma-2" tile outlined color="blue darken-1">{{
                            lang.SAVE
                        }}</VBtn>
                        <VBtn class="ma2" @click="resetChanges" tile outlined>{{
                            lang.CANCEL
                        }}</VBtn>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
    </VForm>
</template>

<script>
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
        logo: null,
        newLogo: null
    }),

    async mounted() {
        const response = await uploadFileService.getFile();
        this.logo = this.newLogo = response.data.file;
    },

    methods: {
        resetChanges() {
            this.newLogo = this.logo;
        },

        removeImage() {
            this.newLogo = null;
        },

        async uploadImage() {
            try {
                const response = await uploadFileService.upload(this.newLogo);
                this.newLogo = response.data.file;
            } catch (e) {
                console.log(e);
            }
        },

        async save() {

        }
    }
};
</script>
