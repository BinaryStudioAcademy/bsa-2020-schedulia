<template>
    <div class="loader-wrapper">
        <VProgressCircular
            :size="50"
            color="primary"
            indeterminate
        ></VProgressCircular>
    </div>
</template>

<script>
export default {
    name: 'Loader'
};
</script>

<style scoped>
div.loader-wrapper {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 99;
    background: rgba(0, 0, 0, 0.4);
}
.v-progress-circular {
    position: absolute;
    z-index: 100;
    top: 50%;
    left: 50%;
}
</style>
