<template>
    <VApp>
        <Header />
        <VMain class="main">
            <Title />
            <div class="content">
                <RouterView />
            </div>
        </VMain>
    </VApp>
</template>

<script>
import Header from './Header';
import Title from "./Title";

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
</style>
