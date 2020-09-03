<template>
    <LayoutMainPage>
        <Error404></Error404>
    </LayoutMainPage>
</template>

<script>
import LayoutMainPage from '../components/auth/LayoutMainPage';
import Error404 from '../components/common/Error404';
export default {
    name: 'Error404View',
    components: {
        LayoutMainPage,
        Error404
    }
};
</script>

<style scoped></style>
