import uploadFileService from '@/services/upload/fileService';
import profileService from '@/services/profile/profileService';
import { UPDATE_BRANDING_LOGO } from './types/mutations';
import * as authActions from '@/store/modules/auth/types/actions';

export default {
    async updatePassword({ dispatch }, password, oldPassword) {
        try {
            const response = profileService.updatePassword(
                password,
                oldPassword
            );

            return response?.data?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },

    async saveBranding({ commit, dispatch }, logo) {
        try {
            const response = await uploadFileService.upload(logo);

            const url = response?.data?.data?.logo?.url;

            profileService.saveBranding(url);

            commit(UPDATE_BRANDING_LOGO, url);

            return response?.data?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },

    async uploadAvatar({ dispatch }, avatar) {
        try {
            const response = uploadFileService.upload(avatar);

            return response?.data?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },

    async updateProfile() {}
};
