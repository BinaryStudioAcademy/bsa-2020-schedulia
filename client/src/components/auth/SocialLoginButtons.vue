<template>
    <VRow>
        <VIcon @click="socialLogin('google')">mdi-google</VIcon>
        <VIcon>mdi-facebook</VIcon>
    </VRow>
</template>

<script>
export default {
    name: "SocialLogin",

    methods: {
        socialLogin(provider) {
            window.location.href = process.env.VUE_APP_API_URL + `/auth/${provider}`;
        }
    }
};
</script>

<style scoped>

</style>