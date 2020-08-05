import state from '@/store/modules/auth/state';
import getters from '@/store/modules/status/getters';
import actions from '@/store/modules/auth/actions';
import mutations from '@/store/modules/auth/mutations';

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
