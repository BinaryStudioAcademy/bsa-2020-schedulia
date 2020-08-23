<template>
    <VApp>
        <RouterView />
        <Notifications />
        <Loader v-if="isLoading" />
    </VApp>
</template>

<script>
import Notifications from './components/common/Notification/Notifications';
import Loader from '@/components/loader/Loader';
import * as getters from '@/store/modules/loader/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'App',
    components: {
        Notifications,
        Loader
    },
    computed: {
        ...mapGetters('loader', {
            isLoading: getters.GET_IS_LOADING
        })
    }
};
</script>

<style lang="scss" type="text/scss">
@import './scss/common.scss';
</style>
