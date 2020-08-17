<template>
    <VRow class="filter">
        <VCol>
            <Teams />
        </VCol>
        <VCol>
            <EventTypes />
        </VCol>
        <VCol>
            <Status />
        </VCol>
        <VCol>
            <TrackingId />
        </VCol>
        <VCol>
            <EnviteeEmails />
        </VCol>
        <VCol class="text-right" align-self="center">
            <VBtn class="reset-button" outlined>
                Reset
            </VBtn>
        </VCol>
    </VRow>
</template>

<script>
import Teams from './Teams';
import EventTypes from './EventTypes';
import Status from './Status';
import TrackingId from './TrackingId';
import EnviteeEmails from './EnviteeEmails';
export default {
    name: 'FilterList',
    components: { EnviteeEmails, TrackingId, Status, EventTypes, Teams }
};
</script>

<style scoped>
.filter::v-deep {
    padding: 15px 43px;
    margin: 0;
}

.reset-button::v-deep {
    border: 1px solid #e0e0e0;
    color: #2c2c2c;
    font-weight: 500;
    font-size: 13px;
    line-height: 16px;
    text-transform: none;
}
</style>
