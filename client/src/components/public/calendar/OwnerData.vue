<template>
    <div>
        <VImg v-if="brandingLogo" :max-height="150" :src="brandingLogo" />
        <div v-if="!brandingLogo" class="no-branding-logo-fill"></div>

        <div class="event-info-content">
            <img
                v-if="avatar"
                :src="avatar"
                class="avatar-image"
                alt="Avatar"
            />
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
<style>
.v-image__image--cover {
    background-size: contain;
}
</style>

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
.avatar-image {
    object-fit: cover;
    width: 70px;
    height: 70px;
    border-radius: 50%;
}
.no-avatar-fill {
    height: 100px;
}
</style>
