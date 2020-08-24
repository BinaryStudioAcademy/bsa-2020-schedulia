<template>
    <VToolbarTitle class="logo">
        <RouterLink class="logo__link" :to="{ name: 'EventTypes' }">
            <img class="logo__image" :src="require('@/assets/logo.svg')" />
            <span class="logo__text">{{ lang.SCHEDULIA }}</span>
        </RouterLink>
    </VToolbarTitle>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'Logo',

    data: () => ({}),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
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
