import * as actions from './types/actions';
import * as mutations from './types/mutations';

export default {
    [actions.SET_ERROR_NOTIFICATION]: async ({ commit }, text) => {
        commit(mutations.SET_NOTIFICATION, {
            showing: true,
            text: text,
            type: 'error'
        });
    },

    [actions.REMOVE_ERROR_NOTIFICATION]: async ({ commit }, id) => {
        commit(mutations.REMOVE_NOTIFICATION, id);
    }
};
