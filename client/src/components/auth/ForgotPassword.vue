<template>
    <div>
        <h4 class="title-of-card pb-4">{{ lang.RESET_YOUR_PASSWORD }}</h4>
        <p class="info-text">{{ lang.ENTER_YOUR_EMAIL_ADDRESS }}</p>
        <VForm>
            <VCol cols="11" sm="11" md="8" class="pa-0 py-4">
                <label>{{ lang.EMAIL }}*</label>
                <VTextField
                    id="email"
                    :value="forgotPasswordData.email"
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
                    :type="forgotPasswordData.typeResultSubmitPassword"
                    dense
                    outlined
                    text
                    dismissible
                    :value="forgotPasswordData.helperVisibility"
                >
                    <h6>{{ forgotPasswordData.resultSubmitPassword }}</h6>
                    <p>{{ forgotPasswordData.explanation }}</p>
                </VAlert>
            </VCol>
        </VForm>
    </div>
</template>

<script>
import * as actions from '@/store/modules/auth/types/actions';
import * as mutations from '@/store/modules/auth/types/mutations';
import { mapActions, mapMutations, mapState } from 'vuex';
import enLang from '@/store/modules/i18n/en';
import { validationMixin } from 'vuelidate';
import { required, email } from 'vuelidate/lib/validators';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'ForgotPassword',
    mixins: [validationMixin],
    components: {},
    data: () => ({
        lang: enLang
    }),
    validations: {
        forgotPasswordData: {
            email: { required, email }
        }
    },
    methods: {
        ...mapMutations('auth', {
            changeHelperVisibilityForgot:
                mutations.CHANGE_HELPER_VISIBILITY_FORGOT,
            setEmailForgot: mutations.SET_EMAIL_FORGOT
        }),
        ...mapActions('auth', {
            forgotPassword: actions.FORGOT_PASSWORD
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
        setEmail(e) {
            this.setEmailForgot(e.target.value);
            this.$v.forgotPasswordData['email'].$touch();
        },
        setEmailOnInput(e) {
            this.setEmailForgot(e);
            this.$v.forgotPasswordData['email'].$touch();
            this.changeHelperVisibilityForgot(false);
        },
        async onSubmit() {
            try {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    throw new Error(this.lang.PLEASE_ENTER_CORRECT_DATA);
                }
                await this.forgotPassword();
            } catch (error) {
                this.setErrorNotification(error?.message);
            }
        }
    },
    computed: {
        ...mapState('auth', ['forgotPasswordData']),
        emailErrors() {
            const errors = [];
            if (!this.$v.forgotPasswordData['email'].$dirty) {
                return errors;
            }
            !this.$v.forgotPasswordData['email'].email &&
                errors.push(this.lang.MUST_BE_VALID_EMAIL);
            !this.$v.forgotPasswordData['email'].required &&
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
