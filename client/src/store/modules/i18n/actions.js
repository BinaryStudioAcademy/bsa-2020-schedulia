import enConst from '@/store/modules/i18n/en';
import ukConst from '@/store/modules/i18n/uk';
import * as actions from './types/actions';
import * as mutations from './types/mutations';

export default {
    [actions.CHANGE_LANGUAGE]: ({ commit }, languageCode = '') => {
        commit(mutations.SET_CURRENT_LANGUAGE, languageCode);
        if (languageCode === 'en') {
            commit(mutations.SET_CURRENT_LANGUAGE_CONSTANT, enConst);
            commit(mutations.SET_LIST_OF_LANGUAGE_VALUES, 'en');
        } else if (languageCode === 'uk') {
            commit(mutations.SET_CURRENT_LANGUAGE_CONSTANT, {
                ...enConst,
                ...ukConst
            });
            commit(mutations.SET_LIST_OF_LANGUAGE_VALUES, 'uk');
        }
    }
};
