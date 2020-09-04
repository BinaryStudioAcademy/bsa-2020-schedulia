<template>
    <div class="search-input">
        <VTextField
            hide-details
            type="text"
            solo
            :label="lang.SEARCH"
            prepend-inner-icon="mdi-magnify"
            dense
            :value="searchString"
            @input="onSearchInput"
            color="var(--v-customDark-base)"
            clearable
        ></VTextField>
    </div>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters } from 'vuex';

export default {
    name: 'SearchInput',

    data: () => ({
        searchString: ''
    }),

    watch: {
        $route: 'setSearchInput'
    },

    async mounted() {
        await this.setSearchInput();
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    },

    methods: {
        onSearchInput(searchString) {
            this.$router.push({
                name: 'Past',
                query: {
                    event_types: this.$route.query.event_types,
                    event_emails: this.$route.query.event_emails,
                    event_status: this.$route.query.event_status,
                    tags: this.$route.query.tags,
                    search: searchString
                }
            });
        },

        setSearchInput() {
            if (this.$route.query.search) {
                this.searchString = this.$route.query.search;
            } else {
                this.searchString = '';
            }
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
