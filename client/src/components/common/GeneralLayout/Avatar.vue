<template>
    <VAvatar size="36">
        <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
    </VAvatar>
</template>

<script>
export default {
    name: 'Avatar'
};
</script>

<style scoped>
.v-avatar::v-deep {
    margin-right: 15px;
}
</style>
