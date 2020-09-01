<template>
    <VRow>
        <img
            :src="require('@/assets/images/google.svg')"
            class="social-button mr-2"
            @click="socialLogin('google')"
        />
        <img
            :src="require('@/assets/images/facebook.svg')"
            class="social-button mr-2"
            @click="socialLogin('facebook')"
        />
        <img
            :src="require('@/assets/images/linkedin.svg')"
            class="social-button"
            @click="socialLogin('linkedin')"
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
