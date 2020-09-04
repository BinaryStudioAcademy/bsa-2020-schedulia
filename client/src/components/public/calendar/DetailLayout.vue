<template>
    <div>
        <OwnerData
            :brandingLogo="brandingLogo"
            :avatar="avatar"
            :name="name"
            :eventName="eventName"
        />
        <div class="event-info-details">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import OwnerData from './OwnerData';

export default {
    name: 'DatailLayout',
    components: {
        OwnerData
    },
    props: {
        brandingLogo: String,
        avatar: String,
        name: String,
        eventName: String
    }
};
</script>

<style scoped>
.event-info-details {
    padding-left: 30px;
    padding-right: 10px;
}
</style>
