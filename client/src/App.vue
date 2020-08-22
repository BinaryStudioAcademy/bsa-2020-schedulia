<template>
    <VApp>
        <RouterView />
        <Notifications />
    </VApp>
</template>

<script>
import Notifications from './components/common/Notification/Notifications';
import { mapActions } from 'vuex';
import * as i18nActions from '@/store/modules/i18n/types/actions';

export default {
    name: 'App',
    components: {
        Notifications
    },
    methods: {
        ...mapActions('i18n', {
            changeLanguage: i18nActions.CHANGE_LANGUAGE
        })
    },
    created: function() {
        this.changeLanguage(this.$store.getters['i18n/getDefaultLanguage']);
    }
};
</script>

<style lang="scss" type="text/scss">
@import './scss/common.scss';
</style>
