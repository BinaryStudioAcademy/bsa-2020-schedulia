<template>
    <RouterView></RouterView>
</template>

<script>
import routersTesterService from '../../services/routersTester/routersTesterService';

export default {
    name: 'UserSlugExistGuard',

    async beforeRouteEnter(to, from, next) {
        try {
            await routersTesterService.checkNicknameSlug(
                to.params.nickname,
                to.params.slug
            );
            next();
        } catch (e) {
            next({ name: 'Error404' });
        }
    }
};
</script>

<style scoped></style>
