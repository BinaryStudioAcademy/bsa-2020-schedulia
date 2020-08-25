<template>
    <div class="event-type pa-8">
        <VRow>
            <VCol cols="2" md="2" sm="2" xs="3">
                <div class="color text-left" :style="{ 'background': eventType.color }"></div>
            </VCol>
            <VCol cols="8" md="7" sm="8" xs="">
                <b class="event-type-name">{{ eventType.name }}</b>
            </VCol>
            <VCol cols="2" md="3" sm="2" class="text-right">
                <VIcon color="black">mdi-chevron-right</VIcon>
            </VCol>
        </VRow>
        <div class="mt-4">
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
.list-heading,
.description {
    color: var(--text-color-level2, rgba(77, 80, 85, 0.6));
    font-size: 14px;
}
.event-types div.event-type {
    transition: 0.5s;
    cursor: pointer;
    border-top: 1px solid var(--text-color-level3, rgba(77, 80, 85, 0.6));
}
.event-types div.event-type:hover {
    background: var(--text-color-level3, rgba(77, 80, 85, 0.1));
}
.color {
    width: 30px;
    height: 30px;
    border-radius: 50%;
}
.event-type-name {
    word-break: break-all;
}
</style>