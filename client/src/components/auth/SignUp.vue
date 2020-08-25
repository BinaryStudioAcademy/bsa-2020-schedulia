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
                        placeholder="name@mail.loc"
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

export default {
    name: 'SignUp',
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
        nameRules: [
            v =>
                !!v ||
                this.lang.FIELD_IS_REQUIRED.replace('field', this.lang.NAME),
            v =>
                v.length >= 2 ||
                this.lang.NAME +
                    this.lang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 2),
            v =>
                v.length <= 100 ||
                this.lang.EMAIL +
                    this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                        'value',
                        100
                    )
        ],
        emailRules: [
            v =>
                !!v ||
                this.lang.FIELD_IS_REQUIRED.replace('field', this.lang.EMAIL),
            v =>
                /([a-zA-Z0-9_.-]+)@(.+)[.](.+)/.test(v) ||
                this.lang.WRONG_EMAIL_FORMAT,
            v =>
                v.length <= 50 ||
                this.lang.EMAIL +
                    this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 50)
        ],
        passwordRules: [
            v =>
                !!v || this.lang.FIELD_IS_REQUIRED.replace('field', 'Password'),
            v =>
                v.length >= 8 ||
                this.lang.PASSWORD +
                    this.lang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 8)
        ],
        passwordConfirmationRules: [
            v =>
                !!v ||
                this.lang.FIELD_IS_REQUIRED.replace(
                    'field',
                    this.lang.CONFIRM_PASSWORD
                ),
            v =>
                v.length >= 8 ||
                this.lang.PASSWORD +
                    this.lang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 8)
        ],
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
        async onSignUp() {
            this.$refs.form.validate();
            if (this.formValid) {
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
