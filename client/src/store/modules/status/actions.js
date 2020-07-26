import * as actions from './types/actions';
import * as mutations from './types/mutations';
import statusService from '@/services/status/statusService';

export default {
    [actions.GET_SERVICE_STATUS_BY_NAME]: async (context, serviceName) => {
        try {
            const status = await statusService.getStatusByService(serviceName);

            context.commit(mutations.SET_SERVICE_STATUS, {
                id: serviceName,
                data: {
                    statusText: status.value,
                    status: true
                }
            });
        } catch (error) {
            context.commit(mutations.SET_SERVICE_STATUS, {
                id: serviceName,
                data: {
                    statusText: error?.response?.data?.message || error.message,
                    status: false
                }
            });
        }
    }
};
