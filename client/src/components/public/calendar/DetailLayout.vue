<template>
    <div>
        <div class="event-info-top"></div>
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
.event-info-top {
    height: 100px;
    background-color: rgb(243, 247, 247);
}
.event-info-details {
    padding-left: 30px;
    padding-right: 10px;
}
</style>
