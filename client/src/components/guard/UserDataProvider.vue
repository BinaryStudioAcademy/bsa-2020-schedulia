<template>
    <div>
        <RouterView></RouterView>
    </div>
</template>

<script>
import authService from '@/services/auth/authService';
import store from '@/store';

export default {
    name: 'UserDataProvider',
    async beforeRouteEnter(to, from, next) {
        if (!store.state.auth.user && authService.getToken()) {
            try {
                await store.dispatch('auth/fetchLoggedUser');
                next({ path: to });
            } catch (error) {
                console.log(error.message);
                next(false);
            }
        }
    }
};
</script>

<style scoped></style>
