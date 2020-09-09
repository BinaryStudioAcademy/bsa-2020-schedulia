<template>
    <DetailLayout
        :brandingLogo="brandingLogo"
        :avatar="avatar"
        :name="name"
        :eventName="eventName"
    >
        <div class="event-info">
            <VIcon dark color="primary">mdi-clock-outline</VIcon>
            {{ duration }} {{ lang.DURATION_MIN }}
        </div>
        <div v-if="showLocation" class="event-info">
            <VIcon dark color="primary">mdi-map-marker</VIcon>
            <span v-if="coords" @click="onOpenMap" class="map-address">
                {{ location }}
            </span>
            <span v-else>{{ location }}</span>
        </div>
        <div v-if="startDate" class="event-info">
            <VIcon dark color="primary">mdi-calendar-blank</VIcon>
            {{ startDate }}
        </div>
        <div v-if="timezone" class="event-info">
            <VIcon dark color="primary">mdi-earth</VIcon>
            {{ timezone }}
        </div>
        <div class="event-info">{{ description }}</div>
        <VDialog :value="showMapDialog" width="320" persistent>
            <div class="location-container">
                <LocationMap :coords="coords" />
                <VBtn
                    color="primary"
                    class="white--text mt-3"
                    width="114"
                    @click="onCloseMap"
                    >{{ lang.OK }}</VBtn
                >
            </div>
        </VDialog>
    </DetailLayout>
</template>

<script>
import DetailLayout from '@/components/public/calendar/DetailLayout';
import LocationMap from '@/components/public/calendar/LocationMap';

export default {
    name: 'EventInfo',
    components: {
        DetailLayout,
        LocationMap
    },
    props: {
        lang: Object,
        brandingLogo: String,
        avatar: String,
        name: String,
        eventName: String,

        duration: Number,
        locationType: String,
        address: String,
        coordinates: null,
        description: String,
        startDate: String,
        timezone: String
    },
    data: () => ({
        showMapDialog: false
    }),
    computed: {
        showLocation() {
            if (this.locationType === 'address') {
                if (this.address) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        },
        location() {
            if (this.locationType === 'address') {
                return this.address;
            } else if (this.locationType === 'zoom') {
                return 'Zoom meeting';
            } else {
                return 'Whale meeting';
            }
        },
        coords() {
            return this.coordinates
                ? [this.coordinates.lng, this.coordinates.lat]
                : null;
        }
    },
    methods: {
        onOpenMap() {
            this.showMapDialog = true;
        },
        onCloseMap() {
            this.showMapDialog = false;
        }
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
.map-address {
    cursor: pointer;
}
.location-container {
    background-color: white;
    padding: 10px 10px 15px 10px;
}
</style>
