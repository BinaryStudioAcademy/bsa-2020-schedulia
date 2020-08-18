<template>
    <div>
        <h4 class="title-of-card pb-4">{{ lang.RESET_YOUR_PASSWORD }}</h4>
        <p class="info-text">{{ lang.ENTER_YOUR_EMAIL_ADDRESS }}</p>
        <VForm>
            <VCol cols="11" sm="11" md="8" class="pa-0 py-4">
                <label>{{ lang.EMAIL }}*</label>
                <VTextField
                    id="email"
                    :value="emailForgot"
                    :error-messages="emailErrors"
                    @input="setEmailOnInput"
                    @blur="setEmail"
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
                        >{{ lang.SEND_RESET_INSTRUCTION }}
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
                    :type="typeResultSubmitForgotPassword"
                    dense
                    outlined
                    text
                    dismissible
                    :value="helperVisibilityForgot"
                >
                    <h6>{{ resultSubmitForgotPassword }}</h6>
                    <p>{{ explanationForgot }}</p>
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
import { required, email } from 'vuelidate/lib/validators';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'ForgotPassword',
    mixins: [validationMixin],
    components: {},
    data: () => ({
        lang: enLang,
        emailForgot: '',
        resultSubmitForgotPassword: '',
        typeResultSubmitForgotPassword: '',
        explanationForgot: '',
        helperVisibilityForgot: false
    }),
    validations: {
        emailForgot: { required, email }
    },
    methods: {
        ...mapActions('auth', {
            forgotPassword: actions.FORGOT_PASSWORD
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
        setEmail(e) {
            this.emailForgot = e.target.value;
            this.$v.emailForgot.$touch();
            this.helperVisibilityForgot = false;
        },
        setEmailOnInput(e) {
            this.emailForgot = e;
            this.$v.emailForgot.$touch();
            this.helperVisibilityForgot = false;
        },
        async onSubmit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                try {
                    const dataForgot = { email: this.emailForgot };
                    const response = await this.forgotPassword(dataForgot);
                    if ('error' in response) {
                        this.resultSubmitForgotPassword = 'error';
                        this.resultSubmitForgotPassword = this.lang.THE_USER_WITH_THE_SPECIFIED_EMAIL_DOES_NOT_EXIST;
                        this.explanationForgot = this.lang.LETTER_EXPLANATION_EMAIL_DONOT_EXIST;
                    } else if (
                        'data' in response &&
                        response?.data?.code === 201
                    ) {
                        this.resultSubmitForgotPassword = 'success';
                        this.typeResultSubmitForgotPassword =
                            this.lang.LETTER_WITH_RESET_LINK_WAS_SENT +
                            ' ' +
                            response?.data?.email;
                        this.explanationForgot = this.lang.LETTER_EXPLANATION_EMAIL_EXIST;
                    }
                    this.helperVisibilityForgot = true;
                } catch (error) {
                    this.setErrorNotification(error);
                }
            } else {
                this.setErrorNotification(this.lang.PLEASE_ENTER_CORRECT_DATA);
            }
        }
    },
    computed: {
        emailErrors() {
            const errors = [];
            if (!this.$v.emailForgot.$dirty) {
                return errors;
            }
            !this.$v.emailForgot.email &&
                errors.push(this.lang.MUST_BE_VALID_EMAIL);
            !this.$v.emailForgot.required &&
                errors.push(this.lang.EMAIL_IS_REQUIRED);
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
h6 {
    font-style: normal;
    font-weight: bold;
    font-size: 20px;
    line-height: 32px;
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
