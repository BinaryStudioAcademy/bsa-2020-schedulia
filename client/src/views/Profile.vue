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
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'Profile',
    components: {
        GeneralLayout,
        UserProfile
    },

    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>
