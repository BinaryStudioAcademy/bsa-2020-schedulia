import * as actions from './types/actions';
import * as mutations from './types/mutations';

export default {
    [actions.SET_EVENT_FILTER_VIEW]: async ({ commit }, eventFilterView) => {
        commit(mutations.SET_EVENT_FILTER_VIEW, eventFilterView);
    }
};
