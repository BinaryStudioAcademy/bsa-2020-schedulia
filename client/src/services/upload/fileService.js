export default {
    upload(file) {
        let formData = new FormData();

        formData.append('file', file);

        //TODO change to the real endpoint
        return { data: { file: 'https://via.placeholder.com/100x50' } };
    },

    getFile() {
        //TODO change to the real endpoint
        return { data: { file: 'https://via.placeholder.com/200x100' } };
    }
};
