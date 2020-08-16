<template>
    <RouterView></RouterView>
</template>

<script>
import authService from '@/services/auth/authService';
import store from '@/store';
import * as actions from '@/store/modules/auth/types/actions';

export default {
    name: 'UserDataProvider',
    async beforeRouteEnter(to, from, next) {
        if (!store.state.auth.user && authService.hasToken()) {
            await store.dispatch('auth/' + actions.FETCH_LOGGED_USER);
        } else {
            next();
        }
    }
};
</script>

<style scoped></style>
