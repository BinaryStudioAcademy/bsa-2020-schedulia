import * as mutations from './types/mutations';

export default {
    [mutations.SET_CURRENT_LANGUAGE]: (state, languageCode) => {
        state.currentLanguage = languageCode;
    },
    [mutations.SET_CURRENT_LANGUAGE_CONSTANT]: (state, languageConstants) => {
        state.languageConstants = languageConstants;
    },
    [mutations.SET_LIST_OF_LANGUAGE_VALUES]: (state, languageCode) => {
        if (languageCode === 'en') {
            state.languages = [
                { value: 'en', text: 'English' },
                { value: 'uk', text: 'Ukrainian' }
            ];
        } else if (languageCode === 'uk') {
            state.languages = [
                { value: 'en', text: 'Англійська' },
                { value: 'uk', text: 'Українська' }
            ];
        }
    }
};
