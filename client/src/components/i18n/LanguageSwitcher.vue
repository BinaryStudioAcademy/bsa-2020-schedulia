<template>
    <div>
        <VSelect
            :items="languageList"
            @change="changeLanguage"
            :value="currentLanguage"
            dense
            flat
            solo
        ></VSelect>
    </div>
</template>

<script>
import * as actions from '@/store/modules/i18n/types/actions';
import * as getters from '@/store/modules/i18n/types/getters';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'LanguageSwitcher',
    methods: {
        ...mapActions('i18n', {
            changeLanguage: actions.CHANGE_LANGUAGE
        })
    },
    computed: {
        ...mapGetters('i18n', {
            languageList: getters.GET_LANGUAGE_LIST,
            currentLanguage: getters.GET_CURRENT_LANGUAGE
        })
    }
};
</script>

<style scoped></style>
