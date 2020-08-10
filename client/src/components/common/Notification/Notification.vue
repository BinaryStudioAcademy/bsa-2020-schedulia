<template>
    <VSnackbar
        v-model="notification.showing"
        :color="notification.type"
        :timeout="timeout"
        :top="top"
    >
        <VRow>
            <VCol>
                {{ notification.text }}
            </VCol>
            <VCol class="text-right" align-self="center">
                <span class="close" @click="closeSnackbar">x</span>
            </VCol>
        </VRow>
    </VSnackbar>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'notification',

    data() {
        return {
            top: true,
            timeout: 2500
        };
    },

    computed: {
        ...mapState('notification', ['notification'])
    },

    methods: {
        closeSnackbar() {
            this.notification.showing = false;
        }
    }
};
</script>

<style scoped>
    .close::v-deep {
        font-size: 16px;
        cursor: pointer;
    }
</style>
