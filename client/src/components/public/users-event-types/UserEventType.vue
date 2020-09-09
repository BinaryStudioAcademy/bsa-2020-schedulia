<template>
    <div class="event-type pa-4">
        <VRow class="mb-0">
            <VCol cols="2" md="2" sm="2" xs="3">
                <div
                    class="color text-left"
                    :style="{ background: eventType.color }"
                ></div>
            </VCol>
            <VCol cols="8" md="8" sm="8">
                <b class="event-type-name">{{ eventType.name }}</b>
            </VCol>
            <VCol cols="2" md="2" sm="2" class="text-right">
                <VIcon color="black">mdi-chevron-right</VIcon>
            </VCol>
        </VRow>
        <div>
            <p class="description">{{ eventType.description }}</p>
        </div>
    </div>
</template>
<script>
export default {
    name: 'UserEventType',
    props: {
        eventType: {
            required: true
        }
    }
};
</script>
<style scoped>
.description {
    color: var(--text-color-level2, rgba(77, 80, 85, 0.6));
    font-size: 14px;
    text-decoration: none;
}

.color {
    width: 30px;
    height: 30px;
    border-radius: 50%;
}
.event-type-name,
.description {
    white-space: pre-wrap;
    word-break: break-word;
}
.description {
    text-overflow: ellipsis;
    white-space: inherit;
    overflow: hidden;
}
</style>
