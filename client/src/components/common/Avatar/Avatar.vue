<template>
    <VAvatar :size="avatarSize">
        <VImg v-if="avatar" :src="avatar"></VImg>
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
        disabled: {
            required: false
        },
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
        }),

        avatar() {
            return this.user.avatar;
        }
    }
};
</script>

<style scoped>
.v-avatar::v-deep {
    margin-right: 15px;
}
</style>
