<template>
    <VRow>
        <VDialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
                <VBtn
                    class="ma-2"
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
                    {{ lang.CHANGE_PASSWORD }}
                </VBtn>
            </template>
            <VCard>
                <VCardTitle>
                    <span class="headline">{{ lang.CHANGE_PASSWORD }}</span>
                </VCardTitle>
                <VCardText>
                    <VContainer>
                        <VRow>
                            <VCol cols="12">
                                <VSubheader
                                    >{{ lang.CURRENT_PASSWORD }}*
                                </VSubheader>
                                <VTextField
                                    :placeholder="lang.CURRENT_PASSWORD"
                                    :error-messages="passwordErrors"
                                    @input="setPasswordOnInput"
                                    @blur="setPassword"
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-icon="
                                        showPassword ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                                    @click:append="showPassword = !showPassword"
                                    dense
                                    outlined
                                ></VTextField>
                                <VSubheader>
                                    {{ lang.NEW_PASSWORD }}*
                                </VSubheader>
                                <VTextField
                                    :placeholder="lang.NEW_PASSWORD"
                                    :error-messages="newPasswordErrors"
                                    @input="setNewPasswordOnInput"
                                    @blur="setNewPassword"
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-icon="
                                        showPassword ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                                    @click:append="showPassword = !showPassword"
                                    dense
                                    outlined
                                ></VTextField>
                                <VSubheader>
                                    {{ lang.CONFIRM_NEW_PASSWORD }}*
                                </VSubheader>
                                <VTextField
                                    :placeholder="lang.REPEAT_NEW_PASSWORD"
                                    :error-messages="matchPasswordErrors"
                                    @input="setMatchPasswordOnInput"
                                    @blur="setMatchPassword"
                                    :type="showPassword ? 'text' : 'password'"
                                    :append-icon="
                                        showPassword ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                                    @click:append="showPassword = !showPassword"
                                    dense
                                    outlined
                                ></VTextField>
                            </VCol>
                        </VRow>
                    </VContainer>
                    <small>* {{ lang.INDICATES_REQUIRED_FIELD }}</small>
                </VCardText>
                <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn
                        color="primary"
                        :disabled="!validateForm"
                        @click="onChangePassword"
                        >{{ lang.SAVE }}
                    </VBtn>
                    <VBtn
                        class="text cancel v-btn--flat v-btn--outlined"
                        @click="dialog = false"
                        >{{ lang.CLOSE }}
                    </VBtn>
                </VCardActions>
            </VCard>
        </VDialog>
    </VRow>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapActions, mapGetters } from 'vuex';
import { validationMixin } from 'vuelidate';
import { required, minLength, sameAs } from 'vuelidate/lib/validators';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'LoginForm',
    mixins: [validationMixin],
    validations: {
        password: { required, minLength: minLength(8) },
        newPassword: { required, minLength: minLength(8) },
        matchPassword: {
            required,
            sameAsPassword: sameAs('newPassword')
        }
    },
    data: () => ({
        password: '',
        newPassword: '',
        matchPassword: '',
        dialog: false,
        showPassword: false,
        errorMessage: ''
    }),

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        passwordErrors() {
            const errors = [];
            if (!this.$v.password.$dirty) {
                return errors;
            }
            !this.$v.password.required &&
                errors.push(this.lang.PASSWORD_IS_REQUIRED);
            !this.$v.password.minLength &&
                errors.push(
                    this.lang.PASSWORD_MUST_BE_AT_LEAST_8_CHARACTERS_LONG
                );
            return errors;
        },
        newPasswordErrors() {
            const errors = [];
            if (!this.$v.newPassword.$dirty) {
                return errors;
            }
            !this.$v.newPassword.required &&
                errors.push(this.lang.PASSWORD_IS_REQUIRED);
            !this.$v.newPassword.minLength &&
                errors.push(
                    this.lang.PASSWORD_MUST_BE_AT_LEAST_8_CHARACTERS_LONG
                );
            return errors;
        },

        matchPasswordErrors() {
            const errors = [];
            if (!this.$v.matchPassword.$dirty) {
                return errors;
            }
            !this.$v.matchPassword.required &&
                errors.push(this.lang.PASSWORD_IS_REQUIRED);
            !this.$v.matchPassword.sameAsPassword &&
                errors.push(this.lang.PASSWORDS_DONT_MATCH);
            return errors;
        },

        validateForm() {
            return !this.$v.$invalid;
        }
    },

    methods: {
        ...mapActions('profile', ['updatePassword']),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION,
            setSuccessNotification: notificationActions.SET_SUCCESS_NOTIFICATION
        }),

        setPassword(e) {
            this.password = e.target.value;
            this.$v.password.$touch();
        },
        setPasswordOnInput(value) {
            this.password = value;
            this.$v.password.$touch();
        },
        setNewPassword(e) {
            this.newPassword = e.target.value;
            this.$v.newPassword.$touch();
        },
        setNewPasswordOnInput(value) {
            this.newPassword = value;
            this.$v.newPassword.$touch();
        },
        setMatchPassword(e) {
            this.matchPassword = e.target.value;
            this.$v.matchPassword.$touch();
        },
        setMatchPasswordOnInput(value) {
            this.matchPassword = value;
            this.$v.matchPassword.$touch();
        },

        async onChangePassword() {
            try {
                if (this.validateForm) {
                    await this.updatePassword({
                        password: this.newPassword,
                        oldPassword: this.password
                    });
                    this.setSuccessNotification(
                        this.lang.PASSWORD_WAS_SUCCESSFULLY_CHANGED
                    );
                    this.dialog = false;
                }
            } catch (error) {
                this.setErrorNotification(error?.message);
            }
        },

        showErrorMessage(message) {
            this.errorMessage = message;
        }
    }
};
</script>

<style lang="scss" scoped>
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
    padding: 0;
    color: var(--v-customDark-base);
    font-size: 13px;
    line-height: 16px;
}
</style>
