<template>
    <div>
        <h4 class="title-of-card pb-4">{{ lang.CHANGE_YOUR_PASSWORD }}</h4>
        <p class="info-text">
            {{ lang.PLEASE_ENTER_NEW_PASSWORD_FOR_USER_WITH_EMAIL }}
            <em>{{ $route.query.email }}</em>
        </p>
        <VForm>
            <VCol cols="11" sm="11" md="8" class="pa-0 py-4">
                <label>{{ lang.PASSWORD }}*</label>
                <VTextField
                    :type="showPassword ? 'text' : 'password'"
                    :value="password"
                    :error-messages="passwordErrors"
                    @input="setPasswordOnInput"
                    @blur="setPassword"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                    outlined
                    dense
                    class="rounded"
                />
            </VCol>
            <VCol cols="11" sm="11" md="8" class="pa-0 py-4">
                <label>{{ lang.PASSWORD }}*</label>
                <VTextField
                    :type="showPassword ? 'text' : 'password'"
                    :value="confirmPassword"
                    :error-messages="confirmPasswordErrors"
                    @input="setConfirmedPasswordOnInput"
                    @blur="setConfirmedPassword"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                    outlined
                    dense
                    class="rounded"
                />
            </VCol>
            <VCol cols="11" sm="11" md="8" class="pa-0">
                <VRow no-gutters align="center" justify="space-between">
                    <VBtn
                        height="44"
                        class="login-button  primary"
                        depressed
                        @click="onSubmit"
                        >{{ lang.SET_NEW_PASSWORD }}
                    </VBtn>
                    <RouterLink
                        :to="{ name: 'SignIn' }"
                        class="remembered-password "
                    >
                        {{ lang.REMEMBERED_PASSWORD }}
                    </RouterLink>
                </VRow>
            </VCol>
            <VSpacer class="pa-4" />
            <VCol cols="11" sm="11" md="8" class="pa-0">
                <VAlert
                    :type="typeResultOfResetPassword"
                    dense
                    outlined
                    text
                    dismissible
                    :value="helperVisibility"
                >
                    <h6>{{ resultOfResetPassword }}</h6>
                    <p>{{ explanation }}</p>
                </VAlert>
            </VCol>
        </VForm>
    </div>
</template>

<script>
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions } from 'vuex';
import enLang from '@/store/modules/i18n/en';
import { validationMixin } from 'vuelidate';
import { required, minLength, sameAs } from 'vuelidate/lib/validators';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'ResetPassword',
    mixins: [validationMixin],
    validations: {
        password: { required, minLength: minLength(8) },
        confirmPassword: { sameAsPassword: sameAs('password') }
    },
    components: {},
    data: () => ({
        lang: enLang,
        password: '',
        confirmPassword: '',
        showPassword: false,
        resultOfResetPassword: 'error',
        typeResultOfResetPassword: '',
        explanation: '',
        helperVisibility: false
    }),
    methods: {
        ...mapActions('auth', {
            resetPassword: actions.RESET_PASSWORD
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
        setPassword(e) {
            this.password = e.target.value;
            this.$v.password.$touch();
        },
        setPasswordOnInput(e) {
            this.password = e;
            this.$v.password.$touch();
        },
        setConfirmedPassword(e) {
            this.confirmPassword = e.target.value;
            this.$v.confirmPassword.$touch();
        },
        setConfirmedPasswordOnInput(e) {
            this.confirmPassword = e;
            this.$v.confirmPassword.$touch();
        },
        async onSubmit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                try {
                    const dataPasswordReset = {
                        email: this.$route.query.email,
                        password: this.password,
                        token: this.$route.query.token
                    };
                    const answer = await this.resetPassword(dataPasswordReset);
                    console.log(answer);
                    if ('error' in answer) {
                        this.typeResultOfResetPassword = 'error';
                        this.resultOfResetPassword = this.lang.THE_USER_WITH_THE_SPECIFIED_EMAIL_DOES_NOT_EXIST;
                        this.explanation = this.lang.LETTER_EXPLANATION_EMAIL_DONOT_EXIST;
                    } else if ('data' in answer && answer?.data?.code === 201) {
                        this.typeResultOfResetPassword = 'success';
                        this.resultOfResetPassword =
                            this.lang.LETTER_WITH_RESET_LINK_WAS_SENT +
                            ' ' +
                            answer?.data?.email;
                        this.explanation = this.lang.LETTER_EXPLANATION_EMAIL_EXIST;
                    }
                    this.helperVisibility = true;
                } catch (error) {
                    this.setErrorNotification(error);
                }
            } else {
                this.setErrorNotification(this.lang.PLEASE_ENTER_CORRECT_DATA);
            }
        }
    },
    computed: {
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
        confirmPasswordErrors() {
            const errors = [];
            if (!this.$v.confirmPassword.$dirty) {
                return errors;
            }
            !this.$v.confirmPassword.sameAsPassword &&
                errors.push(this.lang.PASSWORDS_DONT_MATCH);
            return errors;
        }
    }
};
</script>

<style scoped>
h4 {
    font-style: normal;
    font-weight: 900;
    font-size: 34px;
    line-height: 44px;
    letter-spacing: -0.44px;
}
.title-of-card {
    color: var(--v-primary-base);
}
.info-text {
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 16px;
    color: var(--v-info-base);
}
.v-text-field.error--text::v-deep .v-input__slot {
    background-color: var(--v-validationError-base);
}
.v-text-field.error--text::v-deep .v-text-field__slot input {
    color: var(--v-error-darken1);
}
a {
    text-decoration: none;
}
label {
    font-style: normal;
    font-weight: 500;
    font-size: small;
    color: #2c2c2c;
    display: block;
}
.remembered-password {
    font-size: 0.875rem;
    color: var(--v-primary-base);
}
.login-button {
    text-transform: none;
}
</style>
