<template>
    <Tabs :tabs="tabs"></Tabs>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
import Tabs from '@/components/tabs/Tabs.vue';
import ProfileForm from './ProfileForm.vue';
import BrandingForm from './BrandingForm.vue';
import LoginForm from './LoginForm.vue';

export default {
    name: 'UserProfile',
    components: {
        Tabs
    },
    data: () => ({
        tabs: [
            { title: enLang.PROFILE, component: ProfileForm },
            { title: enLang.BRANDING, component: BrandingForm },
            { title: enLang.CHANGE_PASSWORD, component: LoginForm }
        ]
    })
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
