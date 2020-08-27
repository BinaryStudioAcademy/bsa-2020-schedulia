<template>
    <VCard elevation="0" :flat="true" tile class="secondary">
        <VCardTitle class="title-of-card ">{{ lang.WELCOME }}</VCardTitle>
        <VCardSubtitle class="info-text-in-title mt-1">
            <span>{{ lang.NEW_HERE }} </span>
            <RouterLink :to="{ name: 'SignUp' }">
                {{ lang.CREATE_AN_ACCOUNT }}
            </RouterLink>
            <VSpacer class="pa-2"></VSpacer>
        </VCardSubtitle>

        <SocialLoginButtons />

        <VForm v-model="formValid" ref="form">
            <VCardText>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="email">{{ lang.EMAIL }}*</label>
                    <VTextField
                        id="email"
                        placeholder="Email address"
                        :value="loginData.email"
                        :error-messages="emailErrors"
                        @input="setEmailOnInput"
                        @blur="setEmail"
                        outlined
                        dense
                        type="email"
                    >
                    </VTextField>
                </VCol>
                <VSpacer class="pa-2"></VSpacer>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <VRow no-gutters justify="space-between">
                        <label for="password">{{ lang.PASSWORD }}*</label>
                        <RouterLink
                            :to="{ name: 'ForgotPassword' }"
                            class="forgot-password "
                        >
                            {{ lang.FORGOT_PASSWORD }}
                        </RouterLink>
                    </VRow>
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <VTextField
                        id="password"
                        outlined
                        dense
                        :value="loginData.password"
                        :error-messages="passwordErrors"
                        @input="setPasswordOnInput"
                        @blur="setPassword"
                        :type="showPassword ? 'text' : 'password'"
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                    >
                    </VTextField>
                </VCol>
            </VCardText>
            <VCardActions>
                <VCol cols="12" sm="12" md="9" class="pa-0">
                    <VRow no-gutters align="center" justify="space-between">
                        <VCol>
                            <VBtn
                                width="158"
                                height="44"
                                class="login-button  primary"
                                depressed
                                @click="onSignIn"
                                >{{ lang.LOG_IN }}
                            </VBtn>
                        </VCol>
                        <VCol class="ma-1"> </VCol>
                        <VCol> </VCol>
                    </VRow>
                </VCol>
            </VCardActions>
        </VForm>
    </VCard>
</template>

<script>
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions, mapGetters } from 'vuex';
import * as notificationActions from '@/store/modules/notification/types/actions';
import { validationMixin } from 'vuelidate';
import { required, email, minLength } from 'vuelidate/lib/validators';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import SocialLoginButtons from '@/components/auth/SocialLoginButtons';

export default {
    name: 'SingIn',
    mixins: [validationMixin],
    validations: {
        loginData: {
            email: { required, email },
            password: { required, minLength: minLength(8) }
        }
    },
    components: {
        SocialLoginButtons
    },
    data: () => ({
        formValid: false,
        showPassword: false,
        loginData: {
            email: '',
            password: ''
        },
        alert: {
            visible: false,
            message: '',
            type: ''
        }
    }),
    methods: {
        ...mapActions('auth', {
            signIn: actions.SIGN_IN,
            fetchLoggedUser: actions.FETCH_LOGGED_USER
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
        setEmail(e) {
            this.loginData.email = e.target.value;
            this.$v.loginData.email.$touch();
        },
        setEmailOnInput(value) {
            this.loginData.email = value;
            this.$v.loginData.email.$touch();
        },
        setPassword(e) {
            this.loginData.password = e.target.value;
            this.$v.loginData.password.$touch();
        },
        setPasswordOnInput(value) {
            this.loginData.password = value;
            this.$v.loginData.password.$touch();
        },
        async onSignIn() {
            try {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    throw new Error(this.lang.PLEASE_ENTER_CORRECT_DATA);
                }
                await this.signIn(this.loginData);
                await this.fetchLoggedUser();
                this.$router.push({ name: 'EventTypes' });
            } catch (error) {
                this.setErrorNotification(error.message);
            }
        }
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        emailErrors() {
            const errors = [];
            if (!this.$v.loginData['email'].$dirty) {
                return errors;
            }
            !this.$v.loginData['email'].email &&
                errors.push(this.lang.MUST_BE_VALID_EMAIL);
            !this.$v.loginData['email'].required &&
                errors.push(this.lang.EMAIL_IS_REQUIRED);
            return errors;
        },
        passwordErrors() {
            const errors = [];
            if (!this.$v.loginData['password'].$dirty) {
                return errors;
            }
            !this.$v.loginData['password'].required &&
                errors.push(this.lang.PASSWORD_IS_REQUIRED);
            !this.$v.loginData['password'].minLength &&
                errors.push(
                    this.lang.PASSWORD_MUST_BE_AT_LEAST_8_CHARACTERS_LONG
                );
            return errors;
        }
    }
};
</script>
<style scoped>
.title-of-card {
    color: var(--v-primary-base);
    font-weight: 900;
    font-size: 34px;
    line-height: 44px;
    letter-spacing: -0.44px;
}
.info-text-in-title {
    font-style: normal;
    font-weight: 500;
    font-size: small;
    line-height: 16px;
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
.forgot-password {
    font-size: x-small;
    letter-spacing: 0.4px;
    color: var(--v-primary-base);
}
.login-button {
    text-transform: none;
}
</style>
