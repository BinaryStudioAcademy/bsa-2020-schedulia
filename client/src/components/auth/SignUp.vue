<template>
    <div class="signup container">
        <div class="col-md-6">
            <h1 class="header">{{ lang.CREATE_AN_ACCOUNT }}</h1>
            <p class="hint">
                {{ lang.ALREADY_REGISTERED }}
                <RouterLink :to="{ path: 'login' }">
                    {{ lang.LOG_IN }}
                </RouterLink>
            </p>
            <VForm v-model="formValid" ref="form">
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="full-name">{{ lang.FULL_NAME }}</label>
                    <VTextField
                        id="full-name"
                        :placeholder="lang.NAME"
                        outlined
                        dense
                        type="text"
                        v-model="registerData.name"
                        :rules="nameRules"
                    ></VTextField>
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="email">{{ lang.EMAIL }}</label>
                    <VTextField
                        id="email"
                        placeholder="name@gmail.com"
                        outlined
                        dense
                        type="email"
                        v-model="registerData.email"
                        :rules="emailRules"
                    ></VTextField>
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="password">{{ lang.PASSWORD }}</label>
                    <VTextField
                        id="password"
                        :type="passVisible ? 'text' : 'password'"
                        :append-icon="passVisible ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="passVisible = !passVisible"
                        solo
                        outlined
                        dense
                        v-model="registerData.password"
                        :rules="passwordRules"
                    ></VTextField>
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="password_confirmation">
                        {{ lang.CONFIRM_PASSWORD }}
                    </label>
                    <VTextField
                        id="password_confirmation"
                        :type="passConfirmVisible ? 'text' : 'password'"
                        :append-icon="
                            passConfirmVisible ? 'mdi-eye' : 'mdi-eye-off'
                        "
                        @click:append="passConfirmVisible = !passConfirmVisible"
                        solo
                        outlined
                        dense
                        v-model="registerData.password_confirmation"
                        :rules="passwordConfirmationRules"
                        ref="password_confirmation"
                        :error-messages="passConfirmationError"
                    ></VTextField>
                </VCol>
            </VForm>
            <VBtn
                depressed
                large
                color="primary"
                @click="onSignUp"
                class="pa-8 text-white"
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
import { mapActions } from 'vuex';
import enLang from '@/store/modules/i18n/en';
import Alert from '@/components/alert/Alert';

export default {
    name: 'SignUp',
    components: {
        Alert
    },
    data: () => ({
        lang: enLang,
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
        nameRules: [
            v => !!v || enLang.FIELD_IS_REQUIRED.replace('field', enLang.NAME),
            v =>
                v.length >= 2 ||
                enLang.NAME +
                    enLang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 2),
            v =>
                v.length <= 100 ||
                enLang.EMAIL +
                    enLang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 100)
        ],
        emailRules: [
            v => !!v || enLang.FIELD_IS_REQUIRED.replace('field', enLang.EMAIL),
            v =>
                /([a-zA-Z0-9_.-]+)@(.+)[.](.+)/.test(v) ||
                enLang.WRONG_EMAIL_FORMAT,
            v =>
                v.length <= 50 ||
                enLang.EMAIL +
                    enLang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 50)
        ],
        passwordRules: [
            v => !!v || enLang.FIELD_IS_REQUIRED.replace('field', 'Password'),
            v =>
                v.length >= 8 ||
                enLang.PASSWORD +
                    enLang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 8)
        ],
        passwordConfirmationRules: [
            v =>
                !!v ||
                enLang.FIELD_IS_REQUIRED.replace(
                    'field',
                    enLang.CONFIRM_PASSWORD
                ),
            v =>
                v.length >= 8 ||
                enLang.PASSWORD +
                    enLang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 8)
        ],
        alert: {
            visible: false,
            message: '',
            type: ''
        }
    }),
    methods: {
        ...mapActions('auth', {
            signUp: actions.SIGN_UP
        }),
        async onSignUp() {
            this.$refs.form.validate();
            if (this.formValid) {
                try {
                    this.registerData.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                    await this.signUp(this.registerData);
                    this.showMessage(
                        this.lang.SUCCESSFULLY_REGISTERED,
                        'success.login'
                    );
                    setTimeout(
                        () => this.$router.push({ path: '/login' }),
                        2000
                    );
                } catch (error) {
                    this.showMessage(error, 'error');
                }
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
        passConfirmationError() {
            return this.registerData.password ===
                this.registerData.password_confirmation
                ? ''
                : this.lang.PASSWORDS_DONT_MATCH;
        }
    }
};
</script>

<style scoped>
* {
    font-family: 'Inter', sans-serif;
    font-style: normal;
}
.header {
    color: var(--v-primary-base);
    font-weight: 900;
    font-size: 34px;
    line-height: 44px;
}
.hint {
    color: var(--v-secondary-darken4);
    font-weight: bold;
}
.hint a {
    color: var(--v-primary-base);
    text-decoration: none;
}
.v-btn {
    border-radius: 5px;
    text-transform: none;
    font-size: 20px;
}
.v-snack__content a {
    color: #fff;
    font-weight: bold;
}
</style>
