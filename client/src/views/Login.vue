<template>
    <LayoutMainPage>
        <Login></Login>
    </LayoutMainPage>
</template>

<script>
import LayoutMainPage from '../components/auth/LayoutMainPage';
import Login from '../components/auth/Login';
export default {
    name: 'LoginView',
    components: {
        LayoutMainPage,
        Login
    }
};
</script>

<style scoped></style>
