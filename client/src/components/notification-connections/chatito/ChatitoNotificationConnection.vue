<template>
    <VCol cols="12" md="3" lg="3" sm="6">
        <div class="notification-block">
            <div class="notification-main">
                <div class="notification-content text-center">
                    <h3 class="notification-name">Chatito</h3>
                    <VChip class="ma-2" color="#ec634c">
                        Active
                    </VChip>
                </div>
                <VDivider></VDivider>
                <div class="actions mt-3 mb-3 text-center row">
                    <div class="col text-left">
                        <VBtn color="red" class="slack-delete">
                            <VIcon color="white">mdi-delete</VIcon>
                        </VBtn>
                    </div>
                    <div class="col text-right"></div>
                </div>
            </div>
        </div>
    </VCol>
</template>

<script>
export default {
    name: 'ChatitoNotificationConnection'
};
</script>

<style scoped>
.notification-block {
    background: #fff;
    padding: 15px 20px 0 20px;
    border-radius: 10px;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.25);
    height: 100%;
}
.notification-content {
    min-height: 120px;
}
.notification-name {
    font-size: 30px;
    word-break: break-all;
}
</style>
