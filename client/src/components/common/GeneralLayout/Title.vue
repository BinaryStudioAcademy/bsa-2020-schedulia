<template>
    <div class="title" id="title">
        <VContainer class="title__content">
            <VRow>
                <VCol
                    class="title__content-column title__content-column--no-padding"
                >
                    <h1 class="title__text">Title</h1>
                </VCol>
            </VRow>
        </VContainer>
    </div>
</template>

<script>
export default {
    name: 'Title'
};
</script>

<style lang="scss" scoped>
.title {
    width: 100%;
    background: var(--v-background-lighten1);

    &__text {
        font-family: Inter;
        font-style: normal;
        font-weight: bold;
        font-size: 24px;
        line-height: 36px;
        padding: 32px 0;
    }

    &__content-column,
    &__content {
        padding-top: 0;
        padding-bottom: 0;
    }
}
</style>
