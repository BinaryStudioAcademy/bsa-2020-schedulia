<template>
    <VAppBar class="light primary header" height="85" app flat absolute>
        <VContainer>
            <VRow>
                <VCol class="text-left" align-self="center">
                    <Logo />
                </VCol>
                <VSpacer></VSpacer>
                <VCol class="text-right" align-self="center">
                    <UserMenu />
                </VCol>
            </VRow>
        </VContainer>
    </VAppBar>
</template>

<script>
import Logo from './Logo';
import UserMenu from './UserMenu';

export default {
    name: 'Header',

    components: {
        Logo,
        UserMenu
    }
};
</script>

<style lang="scss" scoped>
.header::v-deep > .v-toolbar__content {
    padding-left: 0;
    padding-right: 0;
}

@media screen and (max-width: 767px) {
    .spacer {
        flex-grow: 0 !important;
    }
}
</style>
