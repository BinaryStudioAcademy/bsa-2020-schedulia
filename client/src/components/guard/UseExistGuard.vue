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
            const response = await requestService.get(
                '/users/email/' + to.params.nickname
            );
            next({ path: `${response.data}` });
        } catch (e) {
            try {
                await routersTesterService.checkNickname(to.params.nickname);
                next();
            } catch (e) {
                next({ name: 'Error404' });
            }
        }
    }
};
</script>

<style scoped></style>
