<template>
    <LayoutMainPage>
        <VerifiedEmailComponent />
    </LayoutMainPage>
</template>

<script>
import LayoutMainPage from '../components/auth/LayoutMainPage';
import VerifiedEmailComponent from '@/components/auth/VerifiedEmailComponent';

export default {
    name: 'VerifiedEmail',
    components: {
        LayoutMainPage,
        VerifiedEmailComponent
    }
};
</script>

<style scoped></style>
