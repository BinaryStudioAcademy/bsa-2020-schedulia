<template>
    <VContainer class="container-content">
        <VCol cols="6">
            <VCard>
                <VCardText>
                    <VForm>
                        <VContainer>
                            <VRow>
                                <VCol cols="12">
                                    {{ lang.YOU_LOG_IN_WITH_AN_EMAIL_ADDRESS_AND_PASSWORD }}
                                </VCol>
                                <VCol cols="12">
                                    <VSubheader>{{ lang.EMAIL }}</VSubheader>
                                    <VTextField
                                            :value="email"
                                            :rules="[validEmail]"
                                            :label="lang.EMAIL"
                                            readonly
                                            solo
                                            outlined
                                    ></VTextField>
                                </VCol>
                                <VCol cols="12">
                                    <VSubheader>{{ lang.PASSWORD }}</VSubheader>
                                    <VTextField
                                            :value="password"
                                            :type="showPassword ? 'text' : 'password'"
                                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                            @click:append="showPassword = !showPassword"
                                            :label="lang.PASSWORD"
                                            readonly
                                            solo
                                            outlined
                                    ></VTextField>
                                </VCol>
                                <VCol>
                                    <ChangePasswordForm />
                                </VCol>
                            </VRow>
                        </VContainer>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
import ChangePasswordForm from './ChangePasswordForm.vue';

export default {
    name: 'LoginForm',
    components: {
        ChangePasswordForm
    },
    data: () => ({
        lang: enLang,
        email: 'john.doe@gmail.com',
        password: 'password',
        showPassword: false
    }),

    methods: {
        validEmail(value) {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern.test(value) || this.lang.INVALID_EMAIL;
        }
    }
};
</script>
