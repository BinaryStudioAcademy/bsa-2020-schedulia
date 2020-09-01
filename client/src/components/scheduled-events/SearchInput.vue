<template>
    <div class="search-input">
        <VTextField
                hide-details
                type="text"
                solo
                :label="lang.SEARCH"
                prepend-inner-icon="mdi-magnify"
                dense
                v-model="searchString"
                @input="onSearchInput"
                color="var(--v-customDark-base)"
                clearable
        ></VTextField>
    </div>
</template>

<script>
    import * as i18nGetters from '@/store/modules/i18n/types/getters';
    import {mapGetters} from "vuex";

    export default {
        name: "SearchInput",

        data: () => ({
            searchString: '',
        }),

        computed: {
            ...mapGetters('i18n', {
                lang: i18nGetters.GET_LANGUAGE_CONSTANTS
            }),
        },

        methods: {
            onSearchInput() {

            }
        }
    };
</script>

<style lang="scss" scoped>
    .search-input {
        width: 150px;
        display: inline-flex;
    }
</style>
