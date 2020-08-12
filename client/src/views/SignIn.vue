<template>
    <LayoutMainPage>
        <SignIn></SignIn>
    </LayoutMainPage>
</template>

<script>
import LayoutMainPage from '../components/auth/LayoutMainPage';
import SignIn from '../components/auth/SignIn';
export default {
    name: 'SignInView',
    components: {
        LayoutMainPage,
        SignIn
    }
};
</script>

<style scoped></style>
