<template>
    <div class="event-info-content">
        <VImg
            :max-width="60"
            :max-height="40"
            :src="companyLogo"
            class="company-logo"
        />
        <VAvatar :size="70">
            <img :src="avatar" alt="Avatar" />
        </VAvatar>
        <h4>{{ name }}</h4>
        <p>{{ eventName }}</p>
    </div>
</template>

<script>
export default {
    name: 'OwnerData',
    props: {
        companyLogo: String,
        avatar: String,
        name: String,
        eventName: String
    }
};
</script>

<style scoped>
.event-info-content {
    margin-top: -70px;
    padding-left: 30px;
    padding-right: 10px;
}

.event-info-content h4 {
    margin-top: 15px;
}

.company-logo {
    margin-bottom: -10px;
    margin-left: 80px;
}
</style>
