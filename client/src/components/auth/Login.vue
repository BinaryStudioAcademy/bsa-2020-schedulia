<template>
    <VCard width="380" elevation="0" flat="true" tile>
        <VCardTitle class="primary--text font-weight-black heading"
            >{{ lang.WELCOME }}</VCardTitle
        >
        <VCardSubtitle>
            <span class="info--text">{{ lang.NEW_HERE }}</span>
            <RouterLink :to="{ path: 'signup' }">{{ lang.CREATE_AN_ACCOUNT }} </RouterLink>
        </VCardSubtitle>
        <VCardText>
            <VTextField label="email" placeholder="user@gmail.com" outlined>
            </VTextField>
            <VTextField
                :label="lang.PASSWORD"
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
                {{ lang.OR_LOGIN_WITH }}</span
            >
            <VSpacer></VSpacer>
            <VBtn
                class="ma-1 primary--text font-weight-black"
                outlined
                small
                fab
            >
                {{ lang.GOOGLE_ICON }}
            </VBtn>
            <VBtn
                class="ma-1 primary--text font-weight-black"
                outlined
                small
                fab
            >
                {{ lang.FACEBOOK_ICON }}
            </VBtn>
        </VCardActions>
    </VCard>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
export default {
    name: 'Login',
    data: () => ({
        lang: enLang,
        showPassword: false
    })
};
</script>

<style scoped></style>
