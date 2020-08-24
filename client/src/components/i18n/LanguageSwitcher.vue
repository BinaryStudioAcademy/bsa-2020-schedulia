<template>
    <div>
        <VSelect
            :items="languageList"
            @change="changeLanguage"
            :label="lang.LANGUAGE"
            dense
            flat
            outlined
            solo
            full-width
            prepend-inner-icon="mdi-earth"
            class="language-select info-text"
        ></VSelect>
    </div>
</template>

<script>
import * as i18nActions from '@/store/modules/i18n/types/actions';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'LanguageSwitcher',
    methods: {
        ...mapActions('i18n', {
            changeLanguage: i18nActions.CHANGE_LANGUAGE
        })
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS,
            currentLanguage: i18nGetters.GET_CURRENT_LANGUAGE
        }),
        languageList() {
            return [
                { value: 'en', text: this.lang.ENGLISH },
                { value: 'uk', text: this.lang.UKRAINIAN }
            ];
        }
    }
};
</script>

<style scoped>
.v-input.language-select::v-deep .v-input__slot {
    background: transparent;
}
.v-input.language-select::v-deep .v-label {
    color: var(--v-info-base);
}
.info-text {
    color: var(--v-info-base);
}
</style>
