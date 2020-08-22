<template>
    <VAvatar :size="avatarSize">
        <VImg v-if="this.user.avatar" :src="this.user.avatar"></VImg>
        <VIcon v-else :size="size" :color="color">
            mdi-account-circle
        </VIcon>
    </VAvatar>
</template>

<script>
import { mapGetters } from 'vuex';
import * as getters from '@/store/modules/auth/types/getters';
export default {
    name: 'Avatar',
    props: {
        size: {
            required: false,
            default: 36
        },
        color: {
            required: false,
            default: 'white'
        }
    },
    computed: {
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        })
    }
};
</script>

<style scoped>
.v-avatar::v-deep {
    margin-right: 15px;
}
</style>
