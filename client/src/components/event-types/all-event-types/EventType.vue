<template>
    <div
        class="event-type-block"
        :style="{ 'border-bottom': '18px solid ' + eventType.color }"
    >
        <div class="action-button text-right">
            <VBtn icon color="primary">
                <VIcon dark>mdi-cog</VIcon>
            </VBtn>
        </div>
        <div class="event-type-content">
            <h3>{{ eventType.name }}</h3>
            <span class="event-type-about"
                >{{ eventType.duration }} min, one to one
            </span>
        </div>
        <div class="event-type-invitee mt-9 mb-2">
            <VAvatar color="teal" size="24">
                <span class="white--text headline">24</span>
            </VAvatar>
        </div>
        <VDivider />
        <div class="event-type-actions row">
            <div class="col-3 duration text-left">
                <div>/{{ eventType.duration }} min</div>
            </div>
            <div class="col-md-9 text-right">
                <VBtn
                    class="ma-2"
                    outlined
                    :disabled="isDisabled"
                    small
                    :color="eventType.color"
                >
                    Copy Link
                    <VIcon right dark>mdi-vector-arrange-below </VIcon>
                </VBtn>
                <VBtn
                    class="ma-2 text-left"
                    :disabled="isDisabled"
                    fab
                    small
                    :color="eventType.color"
                >
                    <VIcon dark>mdi-chevron-down</VIcon>
                </VBtn>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EventType',
    props: {
        eventType: {
            required: true
        }
    },
    computed: {
        isDisabled() {
            return this.eventType.disabled;
        }
    }
};
</script>

<style scoped>
.event-type-block {
    background: #fff;
    padding: 15px 20px 0 20px;
    border-radius: 10px;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.25);
}
.event-type-about {
    color: #858585;
}
.headline {
    font-size: 12px !important;
}
.duration {
    display: flex;
    justify-content: center;
    align-items: center;
}
.duration span {
    color: var(--v-primary-base);
    font-size: 16px;
}
.disabled-event {
    cursor: default;
}
.disabled-event .event-type-content h3,
.disabled-event .event-type-about,
.disabled-event .event-type-actions .duration span {
    color: #e5e5e5;
}
.disabled-event .event-type-invitee .v-application {
    background-color: #e5e5e5 !important;
}
</style>
