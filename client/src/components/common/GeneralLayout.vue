<template>
    <VApp>
        <Header />
        <!-- <VMain>
            <VAppBar color="#FFF" absolute app>
                <VContainer>
                    <h1>Title</h1>
                </VContainer>
            </VAppBar>
            <VContent style="background-color: #CCC; margin-top: 30px;" app>
                <VContainer style="background-color: #FFF">
                    Some text
                </VContainer>
            </VContent>
        </VMain> -->
    </VApp>
</template>

<script>
import Header from './GeneralLayout/Header';

export default {
    name: 'GeneralLayout',

    components: {
        Header
    }
};
</script>

<style scoped>

.container h1 {
    font-family: Inter;
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 36px;
}
</style>
