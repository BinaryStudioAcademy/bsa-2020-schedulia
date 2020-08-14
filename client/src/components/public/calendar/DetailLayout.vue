<template>
    <div>
        <div class="event-info-top"></div>
        <OwnerData
            :companyLogo="companyLogo"
            :avatar="avatar"
            :name="name"
            :company="company"
            :specialty="specialty"
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
    props: ['companyLogo', 'avatar', 'name', 'company', 'specialty']
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
