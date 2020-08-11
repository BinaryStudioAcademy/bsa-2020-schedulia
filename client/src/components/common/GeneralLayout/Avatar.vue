<template>
    <VAvatar size="36">
        <VImg v-if="avatar" :src="avatar"></VImg>
        <VIcon v-else dark size="36">mdi-account-circle</VIcon>
    </VAvatar>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'Avatar',

    computed: {
        ...mapGetters('profile', {
            avatar: 'getAvatar'
        })
    }
};
</script>

<style scoped>
.v-avatar::v-deep {
    margin-right: 15px;
}
</style>
