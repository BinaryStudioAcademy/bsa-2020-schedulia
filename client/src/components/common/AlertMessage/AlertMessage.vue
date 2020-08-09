<template>
    <VSnackbar v-model="this.snackbar">
        {{ text }}

        <template v-slot:action="{ attrs }">
            <VBtn color="blue" text v-bind="attrs" @click="snackbar = false">
                Close
            </VBtn>
        </template>
    </VSnackbar>
</template>

<script>
export default {
    name: 'AlertMessage',

    data: () => ({
        snackbar: false,
        text: 'My timeout is set to 2000.'
    }),

    methods: {
        showErrorMessage() {
            alert(this.snackbar);
            this.snackbar = true;
            alert(this.snackbar);
        }
    }
};
</script>

<style scoped></style>
