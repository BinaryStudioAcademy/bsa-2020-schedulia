import requestService from '../requestService';

const statusService = {
    async getStatusByService(serviceName) {
        const response = await requestService.get(`/api/status/${serviceName}`);

        return response?.data?.data?.[0];
    }
};

export default statusService;
