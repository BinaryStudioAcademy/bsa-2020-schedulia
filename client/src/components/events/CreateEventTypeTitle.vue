<template>
    <VRow align="center">
        <VCol cols="2" md="1" sm="1" lg="1">
            <div>
                <img
                    :src="colorById[data.color].image"
                    alt
                    :class="{
                        'pl-3': $vuetify.breakpoint.xs,
                        'pl-10': $vuetify.breakpoint.smAndUp
                    }"
                />
            </div>
        </VCol>
        <VCol cols="10" class="pl-lg-5 pl-sm-10">
            <div>
                <VCardTitle>
                    {{ lang.CREATE_EVENT_TYPE_TITLE }}
                </VCardTitle>
                <VCardSubtitle>{{ data.name }}</VCardSubtitle>
            </div>
        </VCol>
    </VRow>
</template>

<script>
import eventTypeMixin from '@/components/events/eventTypeMixin';
export default {
    name: 'CreateEventTypeTitle',
    mixins: [eventTypeMixin]
};
</script>
<style scoped></style>
