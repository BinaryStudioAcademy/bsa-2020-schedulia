<template>
    <div>
        <VSnackbar>
            Error

            <template>
                <VBtn color="pink" text>
                    Close
                </VBtn>
            </template>
        </VSnackbar>
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
            } catch (error) {
                console.log(error.message);
            }
            next({ path: to });
        }
    }
};
</script>

<style scoped></style>
