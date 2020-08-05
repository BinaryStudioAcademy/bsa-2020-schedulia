<template>
    <VContainer>
        <Tabs :tabs="tabs"></Tabs>
    </VContainer>
</template>

<script>
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
            { title: 'Profile', component: ProfileForm },
            { title: 'Branding', component: BrandingForm },
            { title: 'Login', component: LoginForm }
        ]
    })
};
</script>
