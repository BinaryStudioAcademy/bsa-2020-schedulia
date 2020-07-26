import * as mutations from './types/mutations';

export default {
    [mutations.SET_SERVICE_STATUS]: (state, serviceData) => {
        const i = state.map.findIndex(
            serviceName => serviceData.id === serviceName
        );

        state.byId = {
            ...state.byId,
            [serviceData.id]: {
                ...(state.byId[serviceData.id] || {}),
                ...serviceData.data
            }
        };

        if (i === -1) {
            state.map = state.map.concat(serviceData);
        } else {
            state.map = [
                ...state.map.slice(0, i),
                serviceData.id,
                ...state.map.slice(i + 1, state.map.length)
            ];
        }
    }
};
