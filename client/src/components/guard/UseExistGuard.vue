<template>
    <RouterView></RouterView>
</template>

<script>
import routersTesterService from '../../services/routersTester/routersTesterService';
import requestService from '../../services/requestService';
export default {
    name: 'UseExistGuard',

    async beforeRouteEnter(to, from, next) {
        try {
            const nickname = await requestService.get('api/v1/users/email/' + to.params.nickname);
            this.$router.push({ path: `${nickname}` });
        } catch (e) {
            try {
                await routersTesterService.checkNickname(to.params.nickname);
                next();
            } catch (e) {
                next({ name: 'Error404' });
            }
        }

        // try {
        //     await routersTesterService.checkNickname(to.params.nickname);
        //     next();
        // } catch (e) {
        //     next({ name: 'Error404' });
        // }
    }
};
</script>

<style scoped></style>
