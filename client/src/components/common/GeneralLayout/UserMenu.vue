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
                <Avatar />
                {{ lang.USER_MENU_BUTTON }}
                <VIcon>mdi-menu-down</VIcon>
            </VBtn>
        </template>
        <VList dense>
            <VListItem class="v-list-item--link">
                <VListItemTitle align-self="center">
                    <RouterLink
                        :to="{ name: 'profile' }"
                        class="user-menu__link"
                    >
                        <VIcon>mdi-account</VIcon> Profile
                    </RouterLink>
                </VListItemTitle>
            </VListItem>
            <VListItem class="v-list-item--link">
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
import Avatar from './Avatar';

export default {
    name: 'UserMenu',

    data: () => ({
        lang: enLang
    }),

    components: {
        Avatar
    }
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

    &__button::v-deep:hover span.v-btn__content {
        opacity: 0.9;
    }

    &__button::v-deep[aria-expanded='true'] span{
        opacity: 0.9;
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
