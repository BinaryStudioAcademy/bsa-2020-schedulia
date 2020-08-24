<template>
    <div class="ml-5 mt-5 verified-email">
        <div v-if="textVisible === true">
            <p class="verified-email__title">
                {{ lang.ACCOUNT_IS_BEING_ACTIVATED }}
            </p>
        </div>
        <div v-else>
            <p class="mr-2 verified-email__title">
                {{ lang.ACCOUNT_VERIFIED }}
            </p>
            <p class="verified-email__signin">
                {{ lang.ACCOUNT_VERIFIED_REDIRECT }}
                <RouterLink :to="{ name: 'SignIn' }">{{
                    lang.LOGIN
                }}</RouterLink>
            </p>
        </div>
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
import * as actions from '@/store/modules/auth/types/actions';
import { mapActions } from 'vuex';
import * as notificationActions from '@/store/modules/notification/types/actions';

export default {
    name: 'VerifiedEmailComponent',

    data: () => ({
        lang: enLang,

        textVisible: true
    }),
    methods: {
        ...mapActions('auth', {
            verifyEmail: actions.VERIFY_EMAIL
        }),
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        })
    },

    async created() {
        try {
            await this.verifyEmail(this.$route.query);
            this.textVisible = false;

            setTimeout(
                () => this.$router.push({ name: 'SignIn' }),
                7000
            );
        } catch (error) {
            this.setErrorNotification(error.message);
        }
    }
};
</script>

<style lang="scss" scoped>
.verified-email {
    &__title::v-deep {
        color: var(--v-primary-base);
        font-weight: 900;
        font-size: 24px;
        line-height: 34px;
        letter-spacing: -0.44px;
    }

    &__signin {
        color: rgba(0, 0, 0, 0.6);
        font-style: normal;
        font-weight: 500;
        font-size: small;
        line-height: 16px;

        a {
            text-decoration: none;
        }
    }
}
</style>
