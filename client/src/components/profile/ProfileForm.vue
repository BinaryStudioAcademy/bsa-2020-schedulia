<template>
    <VContainer class="container-content">
        <VRow>
            <VCol offset-md="3" md="6" lg="4" sm="12">
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

                                <ProfileTextField
                                    :label="lang.NICKNAME"
                                    :value="userProfile.nickname"
                                    :defaultValue="user.nickname"
                                    @change="onChangeHandle('nickname', $event)"
                                />

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

                                <ProfileSelect
                                    :label="lang.LANGUAGE"
                                    :value="userProfile.language"
                                    :defaultValue="user.language"
                                    :items="languages"
                                    @change="onChangeHandle('language', $event)"
                                />

                                <ProfileDisplayLanguage
                                    :label="lang.DISPLAY_LANGUAGE"
                                />
                            </VCol>

                            <VCol lg="6" md="12">
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

                            <VCol lg="6" md="12">
                                <ProfileSelect
                                    :label="lang.TIME_FORMAT"
                                    :value="userProfile.time_format_12h"
                                    :defaultValue="user.time_format_12h"
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

                                <TimeZoneSelect
                                    :value="userProfile.timezone"
                                    :defaultValue="user.timezone"
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
                            <VCol cols="12">
                                <VBtn
                                    class="text cancel v-btn--flat v-btn--outlined mr-4"
                                    @click="resetChanges"
                                >
                                    {{ lang.CANCEL }}
                                </VBtn>
                                <VBtn
                                    class="mr-4"
                                    color="primary"
                                    dark
                                    @click="onSaveHandle"
                                    >{{ lang.SAVE }}
                                </VBtn>
                            </VCol>
                            <VCol cols="12">
                                <ConfirmDialog
                                    :header="lang.DELETE_ACCOUNT"
                                    :content="lang.DELETE_ACCOUNT_WARNING_TEXT"
                                    :buttonText="lang.DELETE_ACCOUNT"
                                    @confirm="onDeleteHandle"
                                />
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
import TimeZoneSelect from '@/components/common/form/TimeZoneSelect.vue';
import ConfirmDialog from '@/components/confirm/ConfirmDialog.vue';
import ProfileDisplayLanguage from './ProfileDisplayLanguage';

export default {
    name: 'ProfileForm',
    components: {
        ProfileDisplayLanguage,
        ProfileTextField,
        ProfileTextArea,
        ProfileSelect,
        ConfirmDialog,
        TimeZoneSelect
    },
    data: () => ({
        lang: enLang,
        file: null,
        newAvatar: null,
        errorMessage: '',
        userProfile: {
            avatar: null,
            name: '',
            nickname: '',
            welcome_message: '',
            language: 'en',
            date_format: 'american',
            time_format_12h: true,
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
            { value: true, text: '12h' },
            { value: false, text: '24h' }
        ]
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
        ...mapActions('profile', [
            'updateAvatar',
            'updateProfile',
            'deleteProfile'
        ]),

        ...mapActions('auth', ['signOut']),

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
                    const url = await this.updateAvatar(this.file);
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

        async onDeleteHandle() {
            try {
                await this.deleteProfile();
                this.signOut();
                this.$router.push({ name: 'SignIn' });
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

.v-input {
    max-height: 32px;
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

.v-subheader {
    font-size: 13px;
    font-weight: 500;
    line-height: 16;
}

.updateAvatar {
    padding-left: 10px;
    font-weight: 500;
    font-size: 15px;
    line-height: 18px;
    color: #281ac8;
    cursor: pointer;
}
</style>
