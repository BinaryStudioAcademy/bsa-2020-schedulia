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
            const response = await uploadFileService.upload(logo);

            console.log('Upload logo image');
            return Promise.resolve(response);
        } catch (error) {
            return Promise.reject(error);
        }
    },

    async saveBranding() {
        try {
            console.log('Saving branding');
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
