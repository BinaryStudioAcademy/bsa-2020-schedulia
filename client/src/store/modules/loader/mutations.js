import * as mutations from './types/mutations';

export default {
    [mutations.SET_LOADING]: (state, value) => {
        state.isLoading = value;
    }
};
