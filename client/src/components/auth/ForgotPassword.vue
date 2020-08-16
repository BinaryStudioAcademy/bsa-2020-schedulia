<template>
    <div>
        <h4 class="title-of-card pb-4">Reset your password</h4>
        <p class="info-text-p">{{ lang.ENTER_YOUR_EMAIL_ADDRESS }}</p>
        <VForm>
            <VCol cols="11" sm="11" md="8" class="pa-0 py-4">
                <label for="email">{{ lang.EMAIL }}*</label>
                <VTextField
                    id="email"
                    v-bind:value="email"
                    :error-messages="emailErrors"
                    @blur="setEmail($event.target.value)"
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
                        @click="onSignIn"
                        >{{ lang.SEND_RESET_INSTRUCTION }}
                    </VBtn>
                    <RouterLink
                        :to="{ name: 'SignIn' }"
                        class="remembered-password-a "
                    >
                        {{ lang.REMEMBERED_PASSWORD }}
                    </RouterLink>
                </VRow>
            </VCol>
        </VForm>
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
import { validationMixin } from 'vuelidate';
import { required, email } from 'vuelidate/lib/validators';

export default {
    name: 'ForgotPassword',
    mixins: [validationMixin],
    components: {},
    data: () => ({
        lang: enLang,
        email: ''
    }),
    validations: {
        email: { required, email }
    },
    methods: {
        setEmail(value) {
            this.email = value;
            this.$v.email.$touch();
        }
    },
    computed: {
        emailErrors() {
            const errors = [];
            if (!this.$v.email.$dirty) {
                return errors;
            }
            !this.$v.email.email && errors.push('Must be valid e-mail');
            !this.$v.email.required && errors.push('E-mail is required');
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
.info-text-p {
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
.remembered-password-a {
    font-size: 0.875rem;
    color: var(--v-primary-base);
}
.login-button {
    text-transform: none;
}
</style>
