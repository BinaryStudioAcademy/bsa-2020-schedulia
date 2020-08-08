<template>
    <VAppBar class="light primary header" height="85" flat app absolute>
        <VContainer>
            <VRow>
                <VCol class="text-left" align-self="center">
                    <VToolbarTitle class="logo">
                        <RouterLink class="logo__link" :to="{ name: 'Home' }">
                            <img class="logo__image" :src="require('@/assets/logo.svg')" />
                            <span class="logo__text">Schedulia</span>
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
                                <VIcon>mdi-menu-down</VIcon>
                            </VBtn>
                        </template>
                        <VList dense class="user-menu">
                            <VListItem>
                                <VListItemTitle
                                    >Account settings</VListItemTitle
                                >
                            </VListItem>
                            <VListItem>
                                <VListItemTitle align-self="center">
                                    <RouterLink :to="{ name: 'Home' }">
                                        <VIcon>mdi-logout-variant</VIcon>Logout
                                    </RouterLink>
                                </VListItemTitle>
                            </VListItem>
                        </VList>
                    </VMenu>
                </VCol>
            </VRow>
        </VContainer>
    </VAppBar>
</template>

<script>
export default {
    name: 'Header'
};
</script>

<style lang="scss" scoped>
.logo {
	&__link {
		font-family: Inter;
		font-style: normal;
		font-weight: bold;
		font-size: 24px;
		text-decoration: none;
		display: inline-block;
		line-height: 52px;
		height: 52px;
		color: #fff;
		vertical-align: text-bottom;

		padding: 0 10px;
		margin-left: -10px;
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
}

.user-button::v-deep > span.v-btn__content {
    font-family: Inter;
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 17px;
    text-transform: none;
    color: #fffefe;
    margin-left: 8px;
}

.user-button::v-deep:before {
    background-color: transparent;
}

.user-button[aria-expanded='true'] i {
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    transform: rotate(180deg);
}

.user-menu a {
    color: #2c2c2c;
    text-decoration: none;
}
</style>>
