<template>
    <VApp>
        <VAppBar color="#281AC8" class="light" height="85" flat app absolute>
            <VContainer>
                <VRow>
                    <VCol class="text-left" align-self="center">
                        <VToolbarTitle class="logo">
                            <RouterLink :to="{ name: 'Home' }">
                                <img :src="require('@/assets/logo.svg')" />
                                <span class="logo-text">Schedulia</span>
                            </RouterLink>
                        </VToolbarTitle>
                    </VCol>
                    <VSpacer></VSpacer>
                    <VCol class="text-right" align-self="center">
                        <VAvatar size="36">
                            <img
                                src="https://cdn.vuetifyjs.com/images/john.jpg"
                                alt="John"
                            />
                        </VAvatar>
                        <VMenu
                            v-model="value"
                            :close-on-click="true"
                            :close-on-content-click="true"
                            :offset-y="true"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <VBtn
                                    :ripple="false"
                                    :hover="false"
                                    class="user-button"
                                    flat
                                    text
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    My Account
                                    <VIcon>
                                        mdi-menu-down
                                    </VIcon>
                                </VBtn>
                            </template>
                            <VList dense class="user-menu">
                                <VListItem>
                                    <VListItemTitle>
                                        Account settings
                                    </VListItemTitle>
                                </VListItem>
                                <VListItem>
                                    <VListItemTitle align-self="center">
                                        <RouterLink :to="{ name: 'Home' }">
                                            <VIcon>
                                                mdi-logout-variant
                                            </VIcon>
                                            Logout
                                        </RouterLink>
                                    </VListItemTitle>
                                </VListItem>
                            </VList>
                        </VMenu>
                    </VCol>
                </VRow>
            </VContainer>
        </VAppBar>
        <VMain>
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
        </VMain>
    </VApp>
</template>

<script>
export default {
    name: 'GeneralLayout'
};
</script>

<style scoped>
.logo a{
    font-family: Inter;
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 36px;
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #ffffff;
}

.logo-text {
    margin-left: 10px;
}

.user-button::v-deep > span.v-btn__content {
    font-family: Inter;
    font-style: normal;
    font-weight: 500;
    font-size: 14px !important;
    line-height: 17px;
    text-transform: none;
    color: #fffefe;
    margin-left: 8px;
}

.user-button::v-deep:before {
    background-color: transparent;
}

.user-button[aria-expanded=true] i{
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    transform: rotate(180deg);
}

.user-menu a{
    color: #2C2C2C;
    text-decoration: none;
}

.container h1 {
    font-family: Inter;
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 36px;
}
</style>
