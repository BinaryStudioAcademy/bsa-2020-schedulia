<template>
    <VSnackbar v-model="visibility" :color="color">
        {{ message }}
        <RouterLink :to="{ path: '/login' }" v-if="isSuccessLogin">
            Sign In
        </RouterLink>
        <template v-slot:action="{ attrs }">
            <VBtn color="white" text v-bind="attrs" @click="closeAlert">
                Close
            </VBtn>
        </template>
    </VSnackbar>
</template>

<script>
export default {
    name: 'Alert',
    props: {
        type: {
            type: String
        },
        message: {
            required: true,
            type: String
        },
        visibility: {
            required: true
        }
    },
    computed: {
        color() {
            if (this.type.includes('success')) {
                return 'green';
            } else if (this.type === 'error') {
                return 'red';
            }
            return '';
        },
        isSuccessLogin() {
            return this.type === 'success.login';
        }
    },
    methods: {
        closeAlert() {
            this.$emit('alert-closed');
        }
    }
};
</script>

<style scoped>
.v-snack__content a {
    color: #fff;
    font-weight: bold;
}
</style>
