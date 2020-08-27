<template>
    <VRow>
        <img
            :src="require('@/assets/images/google.png')"
            class="social-button mr-2"
            @click="socialLogin('google')"
        />
        <img
            :src="require('@/assets/images/facebook.png')"
            class="social-button"
            @click="socialLogin('facebook')"
        />
    </VRow>
</template>

<script>
export default {
    name: 'SocialLogin',

    methods: {
        socialLogin(provider) {
            window.location.href =
                process.env.VUE_APP_SOCIAL_AUTH_URL + `/auth/${provider}`;
        }
    }
};
</script>

<style scoped>
.social-button {
    cursor: pointer;
}
</style>
