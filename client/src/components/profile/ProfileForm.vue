<template>
    <VForm>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <VRow justify="center" align="center">
                        <VAvatar color="indigo" size="144">
                            <VImg v-if="newAvatar" :src="newAvatar"></VImg>
                            <VIcon v-else dark>mdi-account-circle</VIcon>
                        </VAvatar>
                        <label for="fileAvatar" class="updateAvatar pointer">
                            {{ lang.UPDATE }}
                        </label>

                        <input
                            v-show="false"
                            id="fileAvatar"
                            type="file"
                            accept="image/*"
                            @change="updateImage"
                        />
                    </VRow>
                </VCol>
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
                    <VSelect
                        v-model="userProfile.language"
                        :items="languages"
                        :label="lang.LANGUAGE"
                        solo
                    ></VSelect>
                </VCol>
                <VCol cols="6">
                    <VSubheader>{{ lang.DATE_FORMAT }}</VSubheader>
                    <VSelect
                        v-model="userProfile.dateFormat"
                        :items="dateFormats"
                        :label="lang.DATE_FORMAT"
                        solo
                    ></VSelect>
                </VCol>
                <VCol cols="6">
                    <VSubheader>{{ lang.TIME_FORMAT }}</VSubheader>
                    <VSelect
                        v-model="userProfile.timeFormat"
                        :items="timeFormats"
                        :label="lang.TIME_FORMAT"
                        solo
                    ></VSelect>
                </VCol>
                <VCol cols="12">
                    <VSubheader>{{ lang.COUNTRY }}</VSubheader>
                    <VTextField
                        v-model="userProfile.country"
                        :placeholder="lang.COUNTRY"
                        required
                        solo
                        outlined
                    ></VTextField>
                </VCol>
                <VCol cols="12">
                    <VSubheader>{{ lang.TIME_ZONE }}</VSubheader>
                    <VSelect
                        v-model="userProfile.timeZone"
                        :items="timeZones"
                        :label="lang.TIME_ZONE"
                        solo
                        outlined
                        required
                    ></VSelect>
                </VCol>
                <VCol cols="12">
                    <VSpacer></VSpacer>
                    <VSpacer></VSpacer>
                </VCol>
                <VAlert cols="12" type="error" v-if="errorMessage">
                    {{ errorMessage }}
                </VAlert>
                <VCol>
                    <div>
                        <VBtn class="ma2" @click="resetChanges">
                            {{ lang.CANCEL }}
                        </VBtn>
                        <VBtn
                            class="ma-2"
                            color="primary"
                            dark
                            @click="onSaveHandle"
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
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'ProfileForm',
    data: () => ({
        lang: enLang,
        file: null,
        newAvatar: null,
        errorMessage: '',
        userProfile: {
            name: '',
            welcome: '',
            language: enLang.ENGLISH,
            dateFormat: 'rcf-1123',
            timeFormat: '12h',
            country: '',
            timeZone: null
        },

        languages: [enLang.ENGLISH, enLang.GERMAN, enLang.UKRAINIAN],
        dateFormats: [
            { value: 'rcf-1123', text: 'Mon, 10 Aug 2020 14:38:15 +0000' },
            { utc: 'utc', text: '2020-08-10T14:38:15Z' },
            { value: 'iso-8601', text: '2020-08-10T14:38:15+0000' }
        ],
        timeFormats: ['12h', '24h'],
        timeZones: []
    }),

    created() {
        this.userProfile = {
            ...this.user
        };

        this.newAvatar = this.avatar;
    },

    computed: {
        ...mapGetters('profile', {
            avatar: 'getAvatar'
        }),

        ...mapGetters('auth', {
            user: 'getLoggedUser'
        }),

        avatarIsNew() {
            return this.avatar === this.newAvatar;
        }
    },

    methods: {
        ...mapActions('profile', ['updateAvatar', 'updateProfile']),

        updateImage(event) {
            this.file = event.target.files[0];
            this.newAvatar = URL.createObjectURL(this.file);
        },

        async onSaveHandle() {
            try {
                if (this.avatarIsNew) {
                    const response = await this.updateAvatar(this.avatar);
                    const avatar = response?.avatar?.url;
                    this.userProfile = avatar;
                }

                await this.updateProfile(this.userProfile);
            } catch (error) {
                this.showErrorMessage(error.message);
            }
        },

        resetChanges() {
            this.userProfile = {
                ...this.user
            };
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

.updateAvatar {
    padding-left: 10px;
}
</style>
