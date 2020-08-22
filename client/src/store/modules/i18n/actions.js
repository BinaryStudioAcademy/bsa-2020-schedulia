import enConst from '@/store/modules/i18n/en';
import ukConst from '@/store/modules/i18n/uk';
import * as actions from './types/actions';
import * as mutations from './types/mutations';

export default {
    [actions.CHANGE_LANGUAGE]: ({ commit }, languageCode = '') => {
        commit(mutations.SET_CURRENT_LANGUAGE, languageCode);
        if (languageCode === 'en') {
            commit(mutations.SET_CURRENT_LANGUAGE_CONSTANT, enConst);
        } else if (languageCode === 'uk') {
            commit(mutations.SET_CURRENT_LANGUAGE_CONSTANT, {
                ...enConst,
                ...ukConst
            });
        }
    }
};
