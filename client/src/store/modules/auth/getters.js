import * as getters from '@/store/modules/auth/types/getters';

export default {
    [getters.IS_LOGGED_IN]: state => !!state.isLoggedIn,
    [getters.GET_LOGGED_USER]: state => state.user
};
