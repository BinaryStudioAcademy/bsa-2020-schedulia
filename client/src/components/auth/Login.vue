<template>
    <VCard width="380" elevation="0" flat="true" tile>
        <VCardTitle class="primary--text font-weight-black heading"
            >Welcome</VCardTitle
        >
        <VCardSubtitle>
            <span class="info--text">New here? </span>
            <RouterLink :to="{ path: 'signup' }">Create an account </RouterLink>
        </VCardSubtitle>
        <VCardText>
            <VTextField label="email" placeholder="user@gmail.com" outlined>
            </VTextField>
            <VTextField
                label="Password"
                outlined
                placeholder="......."
                :type="showPassword ? 'text' : 'password'"
                :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append="showPassword = !showPassword"
            >
            </VTextField>
        </VCardText>
        <VCardActions>
            <VBtn width="158" height="44" class="primary" tile>Log in</VBtn>

            <span class="info--text x-small text-center">
                Or login in with</span
            >
            <VSpacer></VSpacer>
            <VBtn
                class="ma-1 primary--text font-weight-black"
                outlined
                small
                fab
            >
                G
            </VBtn>
            <VBtn
                class="ma-1 primary--text font-weight-black"
                outlined
                small
                fab
            >
                f
            </VBtn>
        </VCardActions>
    </VCard>
</template>

<script>
export default {
    name: 'Login',
    data: () => ({
        showPassword: false
    })
};
</script>

<style scoped></style>
