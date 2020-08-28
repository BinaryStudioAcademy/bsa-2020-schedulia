<template>
    <div class="event-info-container">
        <div class="event-info-content">
            <VImg
                v-if="brandingLogo"
                :max-width="60"
                :max-height="40"
                :src="brandingLogo"
                class="company-logo"
            />
            <VAvatar v-if="avatar" :size="70">
                <img :src="avatar" alt="Avatar" />
            </VAvatar>
        </div>
        <h4>{{ name }}</h4>
        <p>{{ eventName }}</p>
    </div>
</template>

<script>
export default {
    name: 'OwnerData',
    props: {
        brandingLogo: String,
        avatar: String,
        name: String,
        eventName: String
    }
};
</script>

<style scoped>
.event-info-container {
    padding-left: 30px;
    padding-right: 10px;
}
.event-info-content {
    margin-top: -80px;
    margin-bottom: 10px;
    height: 100px;
}

.event-info-content h4 {
    margin-top: 15px;
}

.company-logo {
    margin-bottom: -10px;
    margin-left: 80px;
}
</style>
