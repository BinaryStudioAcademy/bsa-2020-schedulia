<template>
    <LayoutMainPage>
        <ForgotPassword></ForgotPassword>
    </LayoutMainPage>
</template>

<script>
import LayoutMainPage from '../components/auth/LayoutMainPage';
import ForgotPassword from '../components/auth/ForgotPassword';

export default {
    name: 'ForgotPasswordView',
    components: {
        LayoutMainPage,
        ForgotPassword
    }
};
</script>

<style scoped></style>
