<template>
    <div></div>
</template>

<script>
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions } from 'vuex';
export default {
    name: 'VerifiedEmailComponent',

    methods: {
        ...mapActions('auth',{
            verifyEmail: actions.VERIFY_EMAIL
        }),
    },

    created() {
        this.verifyEmail(this.$route.query);
        this.$router.push({ name: 'SignIn' });
    }
};
</script>

<style scoped>

</style>