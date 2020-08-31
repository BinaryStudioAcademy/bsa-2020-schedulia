<template>
    <div>
        <h4 class="color-danger pb-4">{{ lang.ERROR_404 }}</h4>
        <p class="color-danger">
            {{ lang.THE_PAGE_YOU_ARE_LOOKING_FOR_COULD_NOT_BE_FOUND }}.
        </p>
        <p class="color-danger">
            {{ lang.PLEASE_MAKE_SURE_THAT_YOU_TYPED_IN_THE_URL_CORRECTLY }}
        </p>
        <p class="color-danger">
            {{ lang.PLEASE_RETYPE_ADDRESS_OR_RETURN_TO }}
            <RouterLink :to="{ path: '/' }"> {{ lang.MAIN_PAGE }}. </RouterLink>
        </p>
        <VSpacer></VSpacer>
    </div>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';
export default {
    name: 'Error404',
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped>
h4 {
    font-style: normal;
    font-weight: 900;
    font-size: 34px;
    line-height: 44px;
    letter-spacing: -0.44px;
}
.color-danger {
    color: var(--v-error-lighten5);
}
p {
    font-size: 20px;
    line-height: 32px;
    letter-spacing: 0.44px;
}

a {
    text-decoration: none;
}
</style>
