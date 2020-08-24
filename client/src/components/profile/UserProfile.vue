<template>
    <Tabs :tabs="tabs"></Tabs>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import Tabs from '@/components/tabs/Tabs.vue';
import ProfileForm from './ProfileForm.vue';
import BrandingForm from './BrandingForm.vue';
import LoginForm from './LoginForm.vue';
import { mapGetters } from 'vuex';

export default {
    name: 'UserProfile',
    components: {
        Tabs
    },
    data: () => ({}),

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        tabs() {
            return [
                { title: this.lang.PROFILE, component: ProfileForm },
                { title: this.lang.BRANDING, component: BrandingForm },
                { title: this.lang.CHANGE_PASSWORD, component: LoginForm }
            ];
        }
    }
};
</script>

<style scoped>
/deep/ .v-subheader {
    padding: 0;
    color: #2c2c2c;
    font-size: 13px;
    line-height: 16px;
    height: 38px;
}
</style>
