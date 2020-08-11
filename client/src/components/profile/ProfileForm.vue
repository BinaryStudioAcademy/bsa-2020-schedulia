<template>
    <VForm>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    <VRow justify="center" align="center">
                        <VAvatar color="indigo" size="144">
                            <VImg v-if="newAvatar" :src="newAvatar"></VImg>
                            <VIcon size="144" v-else dark
                                >mdi-account-circle
                            </VIcon>
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
            language: 'en',
            dateFormat: 'american',
            timeFormat: '12',
            country: '',
            timeZone: null
        },

        languages: [
            { value: 'en', text: enLang.ENGLISH },
            { value: 'de', text: enLang.GERMAN },
            { value: 'ua', text: enLang.UKRAINIAN }
        ],
        dateFormats: [
            { value: 'american', text: 'MM/DD/YYYY' },
            { value: 'european_standard', text: 'DD/MM/YYYY' }
        ],
        timeFormats: [
            { value: '12', text: '12h' },
            { value: '24', text: '24h' }
        ],
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
                    this.userProfile.avatar = avatar;
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
