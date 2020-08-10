<template>
    <VSnackbar
        v-model="notification.showing"
        :color="notification.type"
        :timeout="timeout"
        :top="top"
        :style="`top: ${index * 80 + 15}px`"
    >
        <VRow>
            <VCol cols="12" md="11">
                {{ notification.text }}
            </VCol>
            <VCol class="text-right" align-self="center" cols="12" md="1">
                <span class="close" @click="closeSnackbar">
                    <VIcon size="14">
                        mdi-close
                    </VIcon>
                </span>
            </VCol>
        </VRow>
    </VSnackbar>
</template>

<script>
export default {
    name: 'Notification',

    props: {
        notification: {
            type: Object,
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },

    data() {
        return {
            top: true,
            timeout: -1
        };
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

.col-12::v-deep {
    padding: 0 5px;
}
</style>
