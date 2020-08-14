<template>
    <VContainer class="container-content">
        <VRow justify="center">
            <VCol cols="6">
                <VForm>
                    <VContainer>
                        <VRow>
                            <VCol cols="12">
                                <VRow justify="center" align="center">
                                    <VAvatar color="indigo" size="144">
                                        <VImg
                                            v-if="newAvatar"
                                            :src="newAvatar"
                                        ></VImg>
                                        <VIcon size="144" v-else dark
                                            >mdi-account-circle
                                        </VIcon>
                                    </VAvatar>
                                    <label
                                        for="fileAvatar"
                                        class="updateAvatar pointer"
                                    >
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
                                <ProfileTextField
                                    :label="lang.NAME"
                                    :value="userProfile.name"
                                    :defaultValue="user.name"
                                    @change="onChangeHandle('name', $event)"
                                />
                            </VCol>

                            <VCol cols="12">
                                <ProfileTextArea
                                    :label="lang.WELCOME_MESSAGE"
                                    :value="userProfile.welcome_message"
                                    :defaultValue="user.welcome_message"
                                    @change="
                                        onChangeHandle(
                                            'welcome_message',
                                            $event
                                        )
                                    "
                                />
                            </VCol>

                            <VCol cols="12">
                                <ProfileSelect
                                    :label="lang.LANGUAGE"
                                    :value="userProfile.language"
                                    :defaultValue="user.language"
                                    :items="languages"
                                    @change="onChangeHandle('language', $event)"
                                />
                            </VCol>

                            <VCol cols="6">
                                <ProfileSelect
                                    :label="lang.DATE_FORMAT"
                                    :value="userProfile.date_format"
                                    :defaultValue="user.date_format"
                                    :items="dateFormats"
                                    @change="
                                        onChangeHandle('date_format', $event)
                                    "
                                />
                            </VCol>

                            <VCol cols="6">
                                <ProfileSelect
                                    :label="lang.TIME_FORMAT"
                                    :value="userProfile.time_format"
                                    :defaultValue="user.time_format"
                                    :items="timeFormats"
                                    @change="
                                        onChangeHandle('time_format', $event)
                                    "
                                />
                            </VCol>

                            <VCol cols="12">
                                <ProfileTextField
                                    :label="lang.COUNTRY"
                                    :value="userProfile.country"
                                    :defaultValue="user.country"
                                    @change="onChangeHandle('country', $event)"
                                ></ProfileTextField>
                            </VCol>

                            <VCol cols="12">
                                <ProfileSelect
                                    :label="lang.TIME_ZONE"
                                    :value="userProfile.timezone"
                                    :defaultValue="user.timezone"
                                    :items="timeZones"
                                    @change="onChangeHandle('timezone', $event)"
                                />
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
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
import { mapActions, mapGetters } from 'vuex';
import ProfileTextField from './ProfileTextField.vue';
import ProfileTextArea from './ProfileTextArea.vue';
import ProfileSelect from './ProfileSelect.vue';
import momentTimezone from 'moment-timezone';

export default {
    name: 'ProfileForm',
    components: {
        ProfileTextField,
        ProfileTextArea,
        ProfileSelect
    },
    data: () => ({
        lang: enLang,
        file: null,
        newAvatar: null,
        errorMessage: '',
        userProfile: {
            avatar: null,
            name: '',
            welcome_message: '',
            language: 'en',
            date_format: 'american',
            time_format: '12',
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
        timeZones: momentTimezone.tz.names()
    }),

    created() {
        this.newAvatar = this.user.avatar;
    },

    computed: {
        ...mapGetters('auth', {
            user: 'getLoggedUser'
        }),

        avatarIsNew() {
            return this.newAvatar !== this.userProfile.avatar;
        }
    },

    methods: {
        ...mapActions('profile', ['updateAvatar', 'updateProfile']),

        onChangeHandle(property, value) {
            this.userProfile[property] = value;
        },

        updateImage(event) {
            this.file = event.target.files[0];
            this.newAvatar = URL.createObjectURL(this.file);
        },

        async onSaveHandle() {
            try {
                if (this.avatarIsNew) {
                    const response = await this.updateAvatar(this.file);
                    const url = response?.avatar?.url;
                    this.userProfile.avatar = url;
                }

                const userData = await this.updateProfile({
                    ...this.user,
                    ...this.userProfile
                });

                this.userProfile = { ...userData };
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
