<template>
    <VForm>
        <VContainer>
            <VRow>
                <VCol cols="12">
                    You log in with an email address and password.
                </VCol>
                <VCol cols="12">
                    <VSubheader>Email</VSubheader>
                    <VTextField
                        :value="email"
                        :rules="[rules.email]"
                        label="E-mail"
                        readonly
                        solo
                        outlined
                    ></VTextField>
                </VCol>
                <VCol cols="12">
                    <VSubheader>Password</VSubheader>
                    <VTextField
                        :value="password"
                        :type="showPassword ? 'text' : 'password'"
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                        label="Password"
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
</template>

<script>
import ChangePasswordForm from './ChangePasswordForm.vue';

export default {
    name: 'LoginForm',
    components: {
        ChangePasswordForm
    },
    data: () => ({
        email: 'john.doe@gmail.com',
        password: 'password',
        showPassword: false,
        rules: {
            email: value => {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return pattern.test(value) || 'Invalid e-mail.';
            }
        }
    })
};
</script>
