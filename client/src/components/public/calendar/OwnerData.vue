<template>
    <div>
        <VImg v-if="brandingLogo" :max-height="150" :src="brandingLogo" />
        <div v-if="!brandingLogo" class="no-branding-logo-fill"></div>
        <div class="event-info-content">
            <VAvatar v-if="avatar" :size="70">
                <img :src="avatar" alt="Avatar" />
            </VAvatar>
            <div v-if="!avatar" class="no-avatar-fill"></div>

            <h4>{{ name }}</h4>
            <p>{{ eventName }}</p>
        </div>
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
.event-info-content {
    margin-top: -40px;
    margin-bottom: 10px;
    padding-left: 30px;
    padding-right: 10px;
}

.event-info-content h4 {
    margin-top: 15px;
}
.no-branding-logo-fill {
    height: 100px;
}
.no-avatar-fill {
    height: 100px;
}
</style>
