<template>
    <RouterView></RouterView>
</template>

<script>
import routersTesterService from '../../services/routersTester/routersTesterService';

export default {
    name: 'RoutersTesterGuard',
    async beforeRouteEnter(to, from, next) {
        try {
            await routersTesterService.checkNickname(to.params.nickname);
        } catch (e) {
            next({ name: 'SignUp' });
        }
        next();
    }
};
</script>

<style scoped></style>
