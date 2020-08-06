<template>
    <LayoutMainPage>
        <SignUp></SignUp>
    </LayoutMainPage>
</template>

<script>
import LayoutMainPage from '../components/auth/LayoutMainPage';
import SignUp from '../components/auth/SignUp';
export default {
    name: 'Login',
    components: {
        LayoutMainPage,
        SignUp
    }
};
</script>

<style scoped></style>
