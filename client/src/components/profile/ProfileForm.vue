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
                                    :errors="nameErrors"
                                />

                                <ProfileTextField
                                    :label="lang.NICKNAME"
                                    :value="userProfile.nickname"
                                    :defaultValue="user.nickname"
                                    @change="onChangeHandle('nickname', $event)"
                                    :errors="nicknameErrors"
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
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapActions, mapGetters } from 'vuex';
import ProfileTextField from './ProfileTextField.vue';
import ProfileTextArea from './ProfileTextArea.vue';
import ProfileSelect from './ProfileSelect.vue';
import TimeZoneSelect from '@/components/common/form/TimeZoneSelect.vue';
import ConfirmDialog from '@/components/confirm/ConfirmDialog.vue';
import ProfileDisplayLanguage from './ProfileDisplayLanguage';
import * as authActions from '@/store/modules/auth/types/actions';
import * as authGetters from '@/store/modules/auth/types/getters';
import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';

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
    mixins: [validationMixin],
    validations: {
        userProfile: {
            name: { required },
            nickname: { required }
        }
    },
    data: () => ({
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
        this.userProfile.name = this.user.name;
        this.userProfile.nickname = this.user.nickname;
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('auth', {
            user: authGetters.GET_LOGGED_USER
        }),
        languages() {
            return [
                { value: 'en', text: this.lang.ENGLISH },
                { value: 'de', text: this.lang.GERMAN },
                { value: 'ua', text: this.lang.UKRAINIAN }
            ];
        },
        avatarIsNew() {
            return this.newAvatar !== this.userProfile.avatar;
        },
        nameErrors() {
            const errors = [];
            if (!this.$v.userProfile.name.$dirty) {
                return errors;
            }
            !this.$v.userProfile.name.required &&
                errors.push(
                    this.lang.FIELD_IS_REQUIRED.replace('field', this.lang.NAME)
                );
            return errors;
        },
        nicknameErrors() {
            const errors = [];
            if (!this.$v.userProfile.name.$dirty) {
                return errors;
            }
            !this.$v.userProfile.nickname.required &&
                errors.push(
                    this.lang.FIELD_IS_REQUIRED.replace(
                        'field',
                        this.lang.NICKNAME
                    )
                );
            return errors;
        }
    },
    methods: {
        ...mapActions('profile', [
            'updateAvatar',
            'updateProfile',
            'deleteProfile'
        ]),
        ...mapActions('auth', {
            signOut: authActions.SIGN_OUT,
            updateUserProfile: authActions.UPDATE_PROFILE
        }),
        onChangeHandle(property, value) {
            this.userProfile[property] = value;
            if (!this.userProfile[property] && this.user[property]) {
                this.$v.userProfile[property].$touch();
            }
        },
        updateImage(event) {
            this.file = event.target.files[0];
            this.newAvatar = URL.createObjectURL(this.file);
        },
        async onSaveHandle() {
            try {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }
                if (this.avatarIsNew) {
                    const url = await this.updateAvatar(this.file);
                    this.userProfile.avatar = url;
                }
                const newUserData = {
                    ...this.user,
                    ...this.userProfile
                };
                if (this.userProfile.nickname === this.user.nickname) {
                    delete newUserData.nickname;
                }
                let filteredUserData = {};
                for (const propName in newUserData) {
                    if (newUserData[propName]) {
                        filteredUserData[propName] = newUserData[propName];
                    }
                }
                await this.updateUserProfile(filteredUserData);
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
