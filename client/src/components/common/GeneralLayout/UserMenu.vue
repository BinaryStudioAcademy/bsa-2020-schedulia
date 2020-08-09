<template>
    <VMenu
        :close-on-click="true"
        :close-on-content-click="true"
        :offset-y="true"
        class="user-menu"
    >
        <template v-slot:activator="{ on, attrs }">
            <VBtn
                :ripple="false"
                :hover="false"
                class="user-menu__button"
                text
                v-bind="attrs"
                v-on="on"
            >
                {{ lang.USER_MENU_BUTTON }}
                <VIcon>mdi-menu-down</VIcon>
            </VBtn>
        </template>
        <VList dense>
            <VListItem>
                <VListItemTitle>Account settings</VListItemTitle>
            </VListItem>
            <VListItem>
                <VListItemTitle align-self="center">
                    <RouterLink :to="{ name: 'Home' }" class="user-menu__link">
                        <VIcon>mdi-logout-variant</VIcon>Logout
                    </RouterLink>
                </VListItemTitle>
            </VListItem>
        </VList>
    </VMenu>
</template>

<script>
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'UserMenu',

    data: () => ({
        lang: enLang
    })
};
</script>

<style lang="scss" scoped>
.user-menu {
    &__link {
        color: #2c2c2c;
        text-decoration: none;
    }

    &__button::v-deep {
        span.v-btn__content {
            font-family: Inter;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            line-height: 17px;
            text-transform: none;
            color: #fffefe;
        }
    }

    &__button::v-deep:before {
        background-color: transparent;
    }

    &__button[aria-expanded='true'] i {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }
}
</style>