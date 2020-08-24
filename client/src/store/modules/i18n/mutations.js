import * as mutations from './types/mutations';

export default {
    [mutations.SET_CURRENT_LANGUAGE]: (state, languageCode) => {
        state.currentLanguage = languageCode;
    },
    [mutations.SET_CURRENT_LANGUAGE_CONSTANT]: (state, languageConstants) => {
        state.languageConstants = languageConstants;
    }
};
