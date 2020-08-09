import state from '@/store/modules/profile/state';
import actions from '@/store/modules/profile/actions';
import getters from '@/store/modules/profile/getters';
import mutations from '@/store/modules/profile/mutations';

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
