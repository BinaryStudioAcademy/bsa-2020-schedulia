<template>
    <VForm>
        <VContainer>
            <Vrow>
                <Vcol cols="12">
                    You log in with an email address and password.
                </Vcol>
                <Vcol cols="12">
                    <VSubheader>Email</VSubheader>
                </Vcol>
                <VCol cols="12">
                    <VTextField
                        v-bind:value="email"
                        :rules="[rules.email]"
                        label="E-mail"
                        readonly
                        solo
                        outlined
                    ></VTextField>
                </VCol>
                <Vcol cols="12">
                    <VSubheader>Password</VSubheader>
                </Vcol>
                <VCol cols="12">
                    <VTextField
                        v-bind:value="password"
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
                    <VBtn depressed color="primary">
                        Change password
                    </VBtn>
                </VCol>
            </Vrow>
        </VContainer>
    </VForm>
</template>

<script>
export default {
    name: 'LoginForm',
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
