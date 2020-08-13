<template>
    <VAvatar :size="avatarSize">
        <VImg v-if="avatar" :src="avatar"></VImg>
        <VIcon v-else dark :size="avatarSize" :color="color">
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
        disabled: {
            required: false
        },
        size: {
            required: false
        }
    },
    computed: {
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        }),
        avatar() {
            return this.user.avatar;
        },
        color() {
            return this.disabled ? '#e5e5e5' : 'black';
        },
        avatarSize() {
            return this.size ? this.size : 36;
        }
    }
};
</script>

<style scoped>
.v-avatar::v-deep {
    margin-right: 15px;
}
</style>
