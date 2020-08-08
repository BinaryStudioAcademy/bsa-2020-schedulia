import requestService from '@/services/requestService';

export default {
    async upload(file) {
        let formData = new FormData();

        formData.append('file', file);

        const response = await requestService.post('/files', formData);

        return response?.data?.data;
    },

    async getFile(name) {
        const response = await requestService.get('/files', name);
        return response?.data?.data;
    }
};
