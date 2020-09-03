<template>
    <RouterView></RouterView>
</template>

<script>
import routersTesterService from '../../services/routersTester/routersTesterService';

export default {
    name: 'UseExistGuard',

    async beforeRouteEnter(to, from, next) {
        try {
            await routersTesterService.checkNickname(to.params.nickname);
            next();
        } catch (e) {
            next({ name: 'Error404' });
        }
    }
};
</script>

<style scoped></style>
