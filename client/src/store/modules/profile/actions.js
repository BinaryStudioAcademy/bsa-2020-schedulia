import uploadFileService from '@/services/upload/fileService';

export default {
    async checkUserPassword(context, password) {
        try {
            //TODO Send request to check user password
            console.log(password);
            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async updatePassword(context, password) {
        try {
            //TODO Send request to update user password
            console.log(password);
            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async uploadBrandingLogo(context, logo) {
        try {
            await uploadFileService.upload(logo);

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async uploadAvatar(context, avatar) {
        try {
            await uploadFileService.upload(avatar);

            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async updateProfile() {
        try {
            return Promise.resolve();
        } catch (error) {
            return Promise.reject(error);
        }
    }
};
