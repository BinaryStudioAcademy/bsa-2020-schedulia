import state from '@/store/modules/connectedCalendars/state';
import actions from '@/store/modules/connectedCalendars/actions';
import getters from '@/store/modules/connectedCalendars/getters';
import mutations from '@/store/modules/connectedCalendars/mutations';

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
