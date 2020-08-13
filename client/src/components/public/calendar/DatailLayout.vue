<template>
    <div>
        <div class="event-info-top"></div>
        <OwnerData />
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
    }
};
</script>

<style>
.event-info-top {
    height: 100px;
    background-color: rgb(243, 247, 247);
}
.event-info-details {
    padding-left: 50px;
    padding-right: 10px;
}
</style>
