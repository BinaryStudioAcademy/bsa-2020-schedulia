<template>
    <VForm>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <VSubheader>{{ lang.NAME }}</VSubheader>
                    <VTextField
                        v-model="userProfile.name"
                        :placeholder="lang.NAME + ' *'"
                        required
                        solo
                        outlined
                    ></VTextField>
                </VCol>
                <VCol cols="12">
                    <VSubheader>{{ lang.WELCOME_MESSAGE }}</VSubheader>
                    <VTextarea
                        v-model="userProfile.welcome"
                        :placeholder="lang.WELCOME_MESSAGE + ' *'"
                        required
                        solo
                        outlined
                    ></VTextarea>
                </VCol>
                <VCol cols="12">
                    <VSubheader>{{ lang.LANGUAGE }}</VSubheader>
                    <VTextField
                        v-model="userProfile.language"
                        :placeholder="lang.LANGUAGE + ' *'"
                        required
                        solo
                        outlined
                    ></VTextField>
                </VCol>
                <VCol cols="6">
                    <VSubheader>{{ lang.DATE_FORMAT }}</VSubheader>
                    <VSelect
                        :items="dateFormats"
                        :label="lang.DATE_FORMAT"
                        solo
                    ></VSelect>
                </VCol>
                <VCol cols="6">
                    <VSubheader>{{ lang.TIME_FORMAT }}</VSubheader>
                    <VSelect
                        :items="timeFormats"
                        :label="lang.TIME_FORMAT"
                        solo
                    ></VSelect>
                </VCol>
                <VCol cols="12">
                    <VSubheader>{{ lang.COUNTRY }}</VSubheader>
                    <VTextField
                        v-model="userProfile.country"
                        :placeholder="lang.COUNTRY + ' *'"
                        required
                        solo
                        outlined
                    ></VTextField>
                </VCol>
                <VCol cols="12">
                    <VSubheader>{{ lang.TIME_ZONE }}</VSubheader>
                    <VTextField
                        v-model="userProfile.timeZone"
                        :placeholder="lang.TIME_ZONE + ' *'"
                        required
                        solo
                        outlined
                    ></VTextField>
                </VCol>
                <VCol cols="12">
                    <VSpacer></VSpacer>
                    <VSpacer></VSpacer>
                </VCol>
                <VCol>
                    <div>
                        <VBtn class="ma2 cancel" @click="resetChanges">
                            {{ lang.CANCEL }}
                        </VBtn>
                        <VBtn
                            class="ma-2 save"
                            tile
                            outlined
                            color="blue darken-1"
                            @click="save"
                            >{{ lang.SAVE }}
                        </VBtn>
                    </div>
                </VCol>
            </VRow>
        </VContainer>
    </VForm>
</template>

<script>
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'ProfileForm',
    data: () => ({
        lang: enLang,
        dateFormats: [],
        timeFormats: [],
        userProfile: {
            name: null,
            welcome: null,
            language: null,
            country: null,
            timeZone: null
        }
    }),

    methods: {
        save() {},

        resetChanges() {}
    }
};
</script>
