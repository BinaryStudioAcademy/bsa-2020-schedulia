import requestService from '@/services/requestService';

export default {
    async upload(file) {
        let formData = new FormData();

        formData.append('file', file);

        const response = await requestService.post('/file/upload', formData);

        return response?.data?.data;
    },

    async getFile() {
        const response = await requestService.get('/file', name);
        return response?.data?.data;
    }
};
