import uploadFileService from '@/services/upload/fileService';
import profileService from '@/services/profile/profileService';
import * as authActions from '@/store/modules/auth/types/actions';
import {
    UPDATE_BRANDING_LOGO,
    UPDATE_USER,
    UPDATE_AVATAR
} from './types/mutations';

export default {
    async updatePassword({ dispatch }, { password, oldPassword }) {
        try {
            const response = await profileService.updatePassword(
                password,
                oldPassword
            );

            return response?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },

    async saveBranding({ commit, dispatch }, logo) {
        try {
            const response = await uploadFileService.upload(logo, 'branding');

            const url = response?.url;

            if (url) {
                profileService.saveBranding(url);
                commit(UPDATE_BRANDING_LOGO, url);
            }

            return response?.url;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },

    async updateAvatar({ commit, dispatch }, avatar) {
        try {
            const response = await uploadFileService.upload(avatar, 'avatar');

            const url = response?.url;

            commit(UPDATE_AVATAR, url);

            return response?.url;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },

    async updateProfile({ commit, dispatch }, profile) {
        try {
            const response = await profileService.updateProfile(profile);

            const userData = response?.data?.data;

            commit(UPDATE_USER, userData);

            return userData;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    },

    async deleteProfile({ commit, dispatch }) {
        try {
            const response = await profileService.deleteProfile();

            commit(UPDATE_USER, {});

            return response?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
        }
    }
};
