import * as getters from '@/store/modules/auth/types/getters';

export default {
    [getters.HAS_TOKEN]: state => !!state.token,
    [getters.GET_TOKEN]: state => state.token,
    [getters.IS_LOGGED_IN]: state => !!state.isLoggedIn,
    [getters.GET_LOGGED_USER]: state => state.user
};
