<template>
    <RouterView></RouterView>
</template>

<script>
import store from '@/store';

export default {
    name: 'LoginGuard',
    beforeRouteEnter(to, from, next) {
        if (store.state.auth.user) {
            next();
        } else {
            next({ name: 'SignIn' });
        }
    }
};
</script>

<style scoped></style>
