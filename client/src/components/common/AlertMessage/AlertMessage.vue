<template>
    <VSnackbar v-model="snackbar.showing" color="error" timeout="10000">
        {{ snackbar.text }}
    </VSnackbar>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'AlertMessage',

    computed: {
        ...mapState(['snackbar'])
    }
};
</script>

<style scoped></style>
