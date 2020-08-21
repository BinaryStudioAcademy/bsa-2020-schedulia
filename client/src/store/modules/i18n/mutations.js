import * as mutations from './types/mutations';

export default {
    [mutations.SET_CURRENT_LOCALE]: (state, languageCode) => {
        state.currentLocale = languageCode;
    },
    [mutations.SET_CURRENT_LANGUAGE_CONSTANT]: (state, languageConstants) => {
        state.languageConstants = languageConstants;
    }
};
