<template>
    <div>
        <RouterView></RouterView>
    </div>
</template>

<script>
import authService from '@/services/auth/authService';
import store from '@/store';
import * as actions from '@/store/modules/auth/types/actions';

export default {
    name: 'UserDataProvider',
    async beforeRouteEnter(to, from, next) {
        if (!store.state.auth.user && authService.getToken()) {
            try {
                await store.dispatch('auth/' + actions.FETCH_LOGGED_USER);
            } catch (error) {
                console.log(error.message);
                next(false);
            }
        }
        next({ path: to });
    }
};
</script>

<style scoped></style>
