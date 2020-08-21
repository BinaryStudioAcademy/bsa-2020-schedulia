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
                        :to="{ name: 'Profile' }"
                        class="user-menu__link"
                    >
                        <VIcon>mdi-account</VIcon> {{ lang.PROFILE }}
                    </RouterLink>
                </VListItemTitle>
            </VListItem>
            <VListItem class="v-list-item--link">
                <VListItemTitle align-self="center">
                    <RouterLink
                        :to="{ name: 'EventTypes' }"
                        class="user-menu__link"
                    >
                        <VIcon>mdi-calendar</VIcon> {{ lang.EVENT_TYPES }}
                    </RouterLink>
                </VListItemTitle>
            </VListItem>
            <VListItem class="v-list-item--link">
                <VListItemTitle align-self="center">
                    <RouterLink
                        :to="{ name: 'CalendarConnections' }"
                        class="user-menu__link"
                    >
                        <VIcon>mdi-calendar-sync</VIcon>
                        {{ lang.CALENDAR_CONNECTIONS }}
                    </RouterLink>
                </VListItemTitle>
            </VListItem>
            <VListItem class="v-list-item--link" @click="onSignOut">
                <VListItemTitle align-self="center">
                    <VIcon>mdi-logout-variant</VIcon>{{ lang.LOGOUT }}
                </VListItemTitle>
            </VListItem>
        </VList>
    </VMenu>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
import Avatar from './Avatar';
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions } from 'vuex';

export default {
    name: 'UserMenu',

    data: () => ({
        lang: enLang
    }),
    components: {
        Avatar
    },
    methods: {
        ...mapActions('auth', {
            signOut: actions.SIGN_OUT
        }),
        async onSignOut() {
            await this.signOut();
            this.$router.push({ name: 'SignIn' });
        }
    }
};
</script>

<style lang="scss" scoped>
.user-menu {
    &__link {
        color: #2c2c2c;
        text-decoration: none;
        display: block;
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

    &__button::v-deep:hover,
    &__button::v-deep[aria-expanded='true'] {
        span.v-btn__content {
            opacity: 0.9;
        }
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
