import * as mutations from './types/mutations';

export default {
    [mutations.SET_EVENT_FILTER_VIEW]: (state, eventFilterView) => {
        state.eventFilterView = eventFilterView;
    }
};
