<template>
    <VContainer>
        <Tabs :tabs="tabs"></Tabs>
    </VContainer>
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
            { title: enLang.LOGIN, component: LoginForm }
        ]
    })
};
</script>
