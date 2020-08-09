<template>
    <VToolbarTitle class="logo">
        <RouterLink class="logo__link" :to="{ name: 'Home' }">
            <img class="logo__image" :src="require('@/assets/logo.svg')" />
            <span class="logo__text">Schedulia</span>
        </RouterLink>
    </VToolbarTitle>
</template>

<script>
export default {
    name: 'Logo'
};
</script>

<style lang="scss" scoped>
.logo {
    &__link {
        font-family: $body-font-family;
        font-weight: bold;
        font-size: 24px;
        text-decoration: none;
        display: inline-block;
        line-height: 52px;
        height: 52px;
        color: #fff;
        vertical-align: text-bottom;
    }

    &__image {
        display: inline-block;
        line-height: 52px;
        height: 52px;
    }

    &__text {
        display: inline-block;
        margin-left: 10px;
        line-height: 52px;
        height: 52px;
        vertical-align: top;
    }

    @media screen and (max-width: 767px) {
        &__text {
            display: none;
        }
    }
}
</style>
