<template>
    <RouterView></RouterView>
</template>

<script>
    import store from '@/store';

    export default {
        name: 'AuthGuard',
        beforeRouteEnter(to, from, next) {
            if (!store.state.auth.user) {
                next();
            } else {
                next({ path: '/' });
            }
        }
    };
</script>

<style scoped></style>
