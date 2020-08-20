<template>
    <DetailLayout
        :companyLogo="companyLogo"
        :avatar="avatar"
        :name="name"
        :eventName="eventName"
    >
        <div class="event-info">
            <VIcon dark color="primary">mdi-clock-outline</VIcon>
            {{ duration }} {{ lang.DURATION_MIN }}
        </div>
        <div class="event-info">
            <VIcon dark color="primary">mdi-map-marker</VIcon>
            {{ location }}
        </div>
        <div v-if="fullDate" class="event-info">
            <VIcon dark color="primary">mdi-calendar-blank</VIcon>
            {{ fullDate }}
        </div>
        <div v-if="timezone" class="event-info">
            <VIcon dark color="primary">mdi-earth</VIcon>
            {{ timezone }}
        </div>
        <div class="event-info">{{ description }}</div>
    </DetailLayout>
</template>

<script>
import DetailLayout from './DetailLayout';

export default {
    name: 'EventInfo',
    components: {
        DetailLayout
    },
    props: {
        lang: Object,
        companyLogo: String,
        avatar: String,
        name: String,
        eventName: String,

        duration: Number,
        location: String,
        description: String,
        fullDate: String,
        timezone: String
    }
};
</script>

<style scoped>
.event-info {
    display: flex;
    padding: 6px 0 6px 0;
    margin-top: 20px;
}

.event-info ~ .event-info {
    margin-top: 0px;
}

.event-info i {
    margin-right: 10px;
}
</style>
