<template>
    <VApp>
        <RouterView />
        <Notifications />
    </VApp>
</template>

<script>
import Notifications from './components/common/Notification/Notifications';

export default {
    name: 'App',

    components: {
        Notifications
    }
};
</script>

<style lang="scss" type="text/scss">
@import './scss/common.scss';
</style>
