<template>
    <LayoutMainPage>
        <ResetPassword />
    </LayoutMainPage>
</template>

<script>
import LayoutMainPage from '../components/auth/LayoutMainPage';
import ResetPassword from '../components/auth/ResetPassword';

export default {
    name: 'ResetPasswordView',
    components: {
        LayoutMainPage,
        ResetPassword
    }
};
</script>

<style scoped></style>
