<template>
    <VApp>
        <RouterView />
        <AlertMessage />
    </VApp>
</template>

<script>
import AlertMessage from './components/common/AlertMessage/AlertMessage';

export default {
    name: 'App',

    components: {
        AlertMessage
    }
};
</script>

<style lang="scss" type="text/scss">
@import './scss/common.scss';
</style>
