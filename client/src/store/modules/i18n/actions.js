import enConst from '@/store/modules/i18n/en';
import ukConst from '@/store/modules/i18n/uk';
import * as actions from './types/actions';
import * as mutations from './types/mutations';

export default {
    [actions.CHANGE_LOCALE]: ({ commit }, localeCode = '') => {
        commit(mutations.SET_CURRENT_LOCALE, localeCode);
        if (localeCode === 'en') {
            commit(mutations.SET_CURRENT_LANGUAGE_CONSTANT, enConst);
        } else if (localeCode === 'uk') {
            commit(mutations.SET_CURRENT_LANGUAGE_CONSTANT, ukConst);
        }
    }
};
