import requestService from '@/services/requestService';

export default {
    async upload(file, type) {
        let formData = new FormData();

        formData.append('file', file);
        formData.append('type', type);

        const response = await requestService.post('/files', formData);

        return response?.data?.data;
    },

    async getFile(name) {
        const response = await requestService.get('/files', name);
        return response?.data?.data;
    },

    async delete(type) {
        return await requestService.delete(`/files/${type}`);
    }
};
