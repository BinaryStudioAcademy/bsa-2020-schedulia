import * as getters from '@/store/modules/auth/types/getters';

export default {
    [getters.GET_LOGGED_USER]: state => state.user
};
