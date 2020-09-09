<template>
    <VApp>
        <Header />
        <VMain class="main">
            <Title>
                <slot name="title"></slot>
            </Title>
            <div class="content general-content">
                <slot></slot>
            </div>
        </VMain>
    </VApp>
</template>

<script>
import Header from './Header';
import Title from './Title';

export default {
    name: 'GeneralLayout',

    components: {
        Header,
        Title
    }
};
</script>

<style lang="scss" scoped>
.main {
    background-color: var(--v-background-base);
}

.general-content {
    min-height:680px;
}
</style>
