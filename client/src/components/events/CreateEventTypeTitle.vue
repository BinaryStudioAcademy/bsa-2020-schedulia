<template>
    <VRow align="center">
        <VCol cols="1">
            <div>
                <img
                    :src="colorById[data.color].image"
                    alt=""
                    class="pl-10"
                />
            </div>
        </VCol>
        <VCol class="pl-lg-5 pl-sm-10">
            <div>
                <VCardTitle>
                    {{ lang.CREATE_EVENT_TYPE_TITLE }}
                </VCardTitle>
                <VCardSubtitle>
                    {{ lang.CREATE_EVENT_TYPE_SUBTITLE }}
                </VCardSubtitle>
            </div>
        </VCol>
    </VRow>
</template>

<script>
import eventTypeMixin from "@/components/events/eventTypeMixin";
export default {
    name: 'FirstTitle',
    mixins: [eventTypeMixin]
};
</script>
<style scoped></style>
