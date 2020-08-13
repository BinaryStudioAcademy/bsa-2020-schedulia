import * as getters from './types/getters';

export default {
    [getters.GET_LOGGED_USER]: state => state.user
};
