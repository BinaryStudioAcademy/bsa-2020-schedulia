<template>
    <GeneralLayout>
        <template v-slot:title>
            {{ lang.ACCOUNT_SETTING }}
        </template>
        <UserProfile />
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import UserProfile from '@/components/profile/UserProfile.vue';
import enLang from '@/store/modules/i18n/en.js';

export default {
    name: 'Profile',
    components: {
        GeneralLayout,
        UserProfile
    },

    data: () => ({
        lang: enLang
    })
};
</script>
