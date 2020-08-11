<template>
    <VCard elevation="0" :flat="true" tile class="secondary">
        <VCardTitle class="title-of-card ">{{ lang.WELCOME }}</VCardTitle>
        <VCardSubtitle class="info-text-in-title ">
            <span class="info--text">{{ lang.NEW_HERE }} </span>
            <RouterLink :to="{ name: 'SignUp' }">
                {{ lang.CREATE_AN_ACCOUNT }}
            </RouterLink>
        </VCardSubtitle>
        <VSpacer class="pa-2"></VSpacer>
        <VForm v-model="formValid" ref="form">
            <VCardText>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <label for="email">{{ lang.EMAIL }}</label>
                    <VTextField
                        id="email"
                        placeholder="user@gmail.com"
                        outlined
                        dense
                        type="email"
                        v-model="loginData.email"
                        :rules="emailRules"
                    >
                    </VTextField>
                </VCol>
                <VSpacer class="pa-2"></VSpacer>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <VRow no-gutters justify="space-between">
                        <label for="password">{{ lang.PASSWORD }} </label>
                        <RouterLink
                            :to="{ path: 'restore' }"
                            class="forgot-password-a "
                        >
                            Forgot Password?
                        </RouterLink>
                    </VRow>
                </VCol>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <VTextField
                        id="password"
                        outlined
                        dense
                        v-model="loginData.password"
                        :type="showPassword ? 'text' : 'password'"
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                        :rules="passwordRules"
                    >
                    </VTextField>
                </VCol>
            </VCardText>
            <VCardActions>
                <VCol cols="12" sm="12" md="8" class="pa-0">
                    <VRow align="center" justify="space-between">
                        <VCol>
                            <VBtn
                                width="158"
                                height="44"
                                class="login-button  primary"
                                depressed
                                @click="onSignIn"
                                >Log in
                            </VBtn>
                        </VCol>
                        <VCol>
                            <span class="info--text  text-center">
                                {{ lang.OR_LOGIN_WITH }}</span
                            >
                        </VCol>
                        <VCol>
                            <VBtn class="ma-1 social-button" outlined fab>
                                {{ lang.GOOGLE_ICON }}
                            </VBtn>
                            <VBtn class="ma-1 social-button" outlined fab>
                                {{ lang.FACEBOOK_ICON }}
                            </VBtn>
                        </VCol>
                    </VRow>
                </VCol>
            </VCardActions>
        </VForm>
        <Alert
            :type="alert.type"
            :message="alert.message"
            :visibility="alert.visible"
            @user-deleted="onAlertClose"
        />
    </VCard>
</template>

<script>
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions } from 'vuex';
import enLang from '@/store/modules/i18n/en';
import Alert from '@/components/alert/Alert';
import * as getters from '@/store/modules/auth/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'SingIn',
    components: {
        Alert
    },
    data: () => ({
        lang: enLang,
        formValid: false,
        showPassword: false,
        loginData: {
            email: '',
            password: ''
        },
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid'
        ],
        passwordRules: [v => !!v || 'Password is required'],
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
        async onSignIn() {
            this.$refs.form.validate();
            if (this.formValid) {
                try {
                    await this.signIn(this.loginData);
                    await this.fetchLoggedUser();
                    this.$router.push({ name: 'Profile' });
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
    mounted() {
        console.log(this.$store.getters['auth/getLoggedUser']);
    },
    computed: {
        ...mapGetters('auth', {
            loggedUser: getters.GET_LOGGED_USER
        })
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
    font-size: 13px;
    line-height: 16px;
}
a {
    text-decoration: none;
}
label {
    font-style: normal;
    font-weight: 500;
    font-size: 13px;
    line-height: 16px;
    color: #2c2c2c;
    display: block;
}
.forgot-password-a {
    font-size: 9px;
    line-height: 16px;
    letter-spacing: 0.4px;
    color: var(--v-primary-base);
}
.login-button {
    text-transform: none;
}
.social-button {
    font-weight: 700;
    font-size: large;
    color: var(--v-primary-base);
    text-transform: none;
}
</style>
