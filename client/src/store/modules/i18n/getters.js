import * as i18n from './types/getters';

export default {
    [i18n.GET_LANGUAGE_CONSTANTS]: state => state.languageConstants,
    [i18n.GET_LANGUAGE_LIST]: state => state.languages,
    [i18n.GET_CURRENT_LANGUAGE]: state => state.currentLanguage
};
