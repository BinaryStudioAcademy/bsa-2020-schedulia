<template>
    <VApp>
        <Header />
        <VMain class="main">
            <div class="title">
                <VContainer class="title__content">
                    <VRow>
                        <VCol class="title__content-column title__content-column--no-padding">
                            <h1 class="title__text">Title</h1>
                        </VCol>
                    </VRow>
                </VContainer>
            </div>
            <div class="content">
                <RouterView />
            </div>
        </VMain>
    </VApp>
</template>

<script>
import Header from './Header';

export default {
    name: 'GeneralLayout',

    components: {
        Header
    }
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

.main {
    background-color: var(--v-background-base);
}
</style>
