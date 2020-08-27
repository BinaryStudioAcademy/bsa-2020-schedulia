<template>
    <div class="signup container">
        <div class="col-md-12">
            <h4 class="color-primary">{{ lang.CREATE_AN_ACCOUNT }}</h4>
            <p class="label color-info-base">
                {{ lang.ALREADY_REGISTERED }}
                <RouterLink :to="{ name: 'SignIn' }">
                    {{ lang.LOG_IN }}
                </RouterLink>
            </p>
            <VForm @submit.prevent="onSignUp">
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="full-name">{{ lang.FULL_NAME }}*</label>
                    <VTextField
                        :error-messages="nameErrors"
                        :placeholder="lang.NAME"
                        :value="registerData.name"
                        @blur="setPropertyInRegisterData"
                        @input="setNameOnInput"
                        class="rounded"
                        dense
                        id="name"
                        outlined
                        type="text"
                    ></VTextField>
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="email">{{ lang.EMAIL }}*</label>
                    <VTextField
                        :error-messages="emailErrors"
                        :value="registerData.email"
                        @blur="setPropertyInRegisterData"
                        @input="setEmailOnInput"
                        class="rounded"
                        dense
                        id="email"
                        outlined
                        placeholder="name@mail.org"
                    />
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="password">{{ lang.PASSWORD }}*</label>
                    <VTextField
                        :append-icon="passVisible ? 'mdi-eye' : 'mdi-eye-off'"
                        :error-messages="passwordErrors"
                        :type="passVisible ? 'text' : 'password'"
                        :value="registerData.password"
                        @blur="setPropertyInRegisterData"
                        @click:append="passVisible = !passVisible"
                        @input="setPasswordOnInput"
                        dense
                        id="password"
                        outlined
                    />
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="password_confirmation">
                        {{ lang.CONFIRM_PASSWORD }}*
                    </label>
                    <VTextField
                        :append-icon="
                            passConfirmVisible ? 'mdi-eye' : 'mdi-eye-off'
                        "
                        :error-messages="passwordConfirmationErrors"
                        :type="passConfirmVisible ? 'text' : 'password'"
                        :value="registerData.password_confirmation"
                        @blur="setPropertyInRegisterData"
                        @click:append="passConfirmVisible = !passConfirmVisible"
                        @input="setPasswordConfirmationOnInput"
                        dense
                        id="password_confirmation"
                        outlined
                    />
                </VCol>
                <VBtn
                    height="44"
                    depressed
                    class="signup-button  primary"
                    type="submit"
                >
                    {{ lang.SIGN_UP }}
                </VBtn>
            </VForm>
            <VBtn
                height="44"
                depressed
                class="signup-button  primary"
                @click="onSignUp"
            >
                {{ lang.SIGN_UP }}
            </VBtn>
        </div>
        <Alert
            :type="alert.type"
            :message="alert.message"
            :visibility="alert.visible"
            @user-deleted="onAlertClose"
        />
    </div>
</template>

<script>
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions, mapGetters } from 'vuex';
import Alert from '@/components/alert/Alert';
import * as notificationActions from '@/store/modules/notification/types/actions';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { validationMixin } from 'vuelidate';
import {
    required,
    email,
    sameAs,
    minLength,
    maxLength,
    helpers
} from 'vuelidate/lib/validators';
const nameRequirements = helpers.regex(
    'symbols',
    /^[a-zA-Zа-яА-ЯЇїІіЄєҐґ /|,._\\]{2,50}$/
);
export default {
    name: 'SignUp',
    mixins: [validationMixin],

    validations: {
        registerData: {
            name: {
                required,
                minLength: minLength(2),
                maxLength: maxLength(50),
                nameRequirements
            },
            email: { required, email },
            password: { required, minLength: minLength(8) },
            password_confirmation: {
                required,
                sameAsPassword: sameAs('password')
            }
        }
    },
    components: {
        Alert
    },
    data: () => ({
        formValid: false,
        passVisible: false,
        passConfirmVisible: false,
        registerData: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            timezone: ''
        },
        alert: {
            visible: false,
            message: '',
            type: ''
        }
    }),
    methods: {
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
        ...mapActions('auth', {
            signUp: actions.SIGN_UP
        }),
        setPropertyInRegisterData(e) {
            this.registerData[e.target.id] = e.target.value;
            this.$v.registerData[e.target.id].$touch();
        },
        setEmailOnInput(value) {
            this.registerData.email = value;
            this.$v.registerData.email.$touch();
        },
        setNameOnInput(value) {
            this.registerData.name = value;
            this.$v.registerData.name.$touch();
        },
        setPasswordOnInput(value) {
            this.registerData.password = value;
            this.$v.registerData.password.$touch();
        },
        setPasswordConfirmationOnInput(value) {
            this.registerData.password_confirmation = value;
            this.$v.registerData.password_confirmation.$touch();
        },
        async onSignUp() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                try {
                    this.registerData.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                    await this.signUp(this.registerData);
                    this.showMessage(
                        this.lang.SEND_VERIFICATION_EMAIL,
                        'success'
                    );
                } catch (error) {
                    this.setErrorNotification(error);
                }
            } else {
                this.setErrorNotification(this.lang.PLEASE_ENTER_CORRECT_DATA);
            }
        },
        onAlertClose() {
            this.alert.visible = false;
        },
        showMessage(message, type = '') {
            this.alert.message = message;
            this.alert.type = type;
            this.alert.visible = true;
        }
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        nameErrors() {
            const errors = [];
            if (!this.$v.registerData.name.$dirty) {
                return errors;
            }
            !this.$v.registerData.name.required &&
                errors.push(this.lang.NAME_IS_REQUIRED);
            !this.$v.registerData.name.minLength &&
                errors.push(this.lang.NAME_MUST_BE_AT_LEAST_2_CHARACTERS_LONG);
            !this.$v.registerData.name.maxLength &&
                errors.push(
                    this.lang.NAME_MUST_BE_NO_MORE_THAN_50_CHARACTERS_LONG
                );
            !this.$v.registerData.name.nameRequirements &&
                errors.push(this.lang.ONLY_LETTER_AND_SYMBOLS_PERMITTED);
            return errors;
        },
        emailErrors() {
            const errors = [];
            if (!this.$v.registerData.email.$dirty) {
                return errors;
            }
            !this.$v.registerData.email.email &&
                errors.push(this.lang.MUST_BE_VALID_EMAIL);
            !this.$v.registerData.email.required &&
                errors.push(this.lang.EMAIL_IS_REQUIRED);
            return errors;
        },
        passwordErrors() {
            const errors = [];
            if (!this.$v.registerData.password.$dirty) {
                return errors;
            }
            !this.$v.registerData.password.required &&
                errors.push(this.lang.PASSWORD_IS_REQUIRED);
            !this.$v.registerData.password.minLength &&
                errors.push(
                    this.lang.PASSWORD_MUST_BE_AT_LEAST_8_CHARACTERS_LONG
                );
            return errors;
        },
        passwordConfirmationErrors() {
            const errors = [];
            if (!this.$v.registerData.password_confirmation.$dirty) {
                return errors;
            }
            !this.$v.registerData.password_confirmation.required &&
                errors.push(this.lang.PASSWORD_CONFIRMATION_IS_REQUIRED);
            !this.$v.registerData.password_confirmation.sameAsPassword &&
                errors.push(this.lang.PASSWORDS_DONT_MATCH);

            return errors;
        }
    }
};
</script>

<style scoped>
h4 {
    font-weight: 900;
    font-size: 34px;
    line-height: 44px;
    letter-spacing: -0.44px;
}
.color-primary {
    color: var(--v-primary-base);
}
.label {
    font-style: normal;
    font-weight: 500;
    font-size: 13px;
    line-height: 16px;
}
.color-info-base {
    color: var(--v-info-base);
}
.label a {
    color: var(--v-primary-base);
    text-decoration: none;
}

label {
    font-style: normal;
    font-weight: 500;
    font-size: 13px;
    line-height: 16px;
    color: var(--v-info-darken4);
}

.v-text-field.error--text::v-deep .v-input__slot {
    background-color: var(--v-validationError-base);
}
.v-text-field.error--text::v-deep .v-text-field__slot input {
    color: var(--v-error-darken1);
}
.signup-button {
    text-transform: none;
    font-style: normal;
    font-size: 15px;
    line-height: 18px;
    width: 146px;
}

.v-snack__content a {
    color: #fff;
    font-weight: bold;
}
</style>
