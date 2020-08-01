import * as types from './types/getters';

export default {
    [types.GET_STATUS_MAP]: state => state.map,
    [types.GET_STATUS_BY_ID]: state => state.byId
};
