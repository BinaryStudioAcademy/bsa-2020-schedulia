<template>
    <VApp>
        <VMain class="main">
            <div class="event-type-container">
                <div class="event-type-content">
                    <VContainer fluid class="pa-0">
                        <slot></slot>
                    </VContainer>
                </div>
            </div>
        </VMain>
    </VApp>
</template>

<script>
export default {
    name: 'GeneralLayout'
};
</script>

<style lang="scss" scoped>
.main {
    background-color: var(--v-background-base);
    font-family: $body-font-family;
}
.event-type-container {
    width: 100%;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.event-type-content {
    margin-top: 50px;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
    background-color: #fff;
    width: 87%;
    max-width: 1200px;
}

@media (max-width: 1263px) {
    .event-type-content {
        width: 90%;
    }
}
@media (max-width: 600px) {
    .event-type-content {
        width: 100%;
        box-shadow: none;
    }
}
</style>
