<template>
    <VApp>
        <RouterView />
        <Notification />
    </VApp>
</template>

<script>
import Notification from './components/common/Notification/Notification';

export default {
    name: 'App',

    components: {
        Notification
    }
};
</script>

<style lang="scss" type="text/scss">
@import './scss/common.scss';
</style>
