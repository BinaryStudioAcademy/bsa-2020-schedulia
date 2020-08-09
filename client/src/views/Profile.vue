<template>
    <GeneralLayout>
        <UserProfile />

        <template v-slot:title>
            User Profile
        </template>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import UserProfile from '@/components/profile/UserProfile.vue';

export default {
    name: 'Profile',
    components: {
        GeneralLayout,
        UserProfile
    }
};
</script>
