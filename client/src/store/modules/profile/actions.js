import uploadFileService from '@/services/upload/fileService';
import profileService from '@/services/profile/profileService';
import * as authActions from '@/store/modules/auth/types/actions';
import * as loaderMutations from '@/store/modules/loader/types/mutations';

import {
    UPDATE_BRANDING_LOGO,
    UPDATE_USER,
    UPDATE_AVATAR
} from './types/mutations';

export default {
    async updatePassword({ commit, dispatch }, { password, oldPassword }) {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const response = await profileService.updatePassword(
                password,
                oldPassword
            );
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
            return response?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
        }
    },

    async saveBranding({ commit, dispatch }, logo) {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const response = await uploadFileService.upload(logo, 'branding');

            const url = response?.url;

            if (url) {
                profileService.saveBranding(url);
                commit(UPDATE_BRANDING_LOGO, url);
            }
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
            return response?.url;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
        }
    },

    async updateAvatar({ commit, dispatch }, avatar) {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const response = await uploadFileService.upload(avatar, 'avatar');

            const url = response?.url;

            commit(UPDATE_AVATAR, url);
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
            return response?.url;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
        }
    },

    async updateProfile({ commit, dispatch }, profile) {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const response = await profileService.updateProfile(profile);

            const userData = response?.data?.data;

            commit(UPDATE_USER, userData);
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
            return userData;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
        }
    },

    async deleteProfile({ commit, dispatch }) {
        commit('loader/' + loaderMutations.SET_LOADING, true, { root: true });
        try {
            const response = await profileService.deleteProfile();

            commit(UPDATE_USER, {});
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
            return response?.data;
        } catch (error) {
            dispatch('auth/' + authActions.CHECK_IF_UNAUTHORIZED, error, {
                root: true
            });
            commit('loader/' + loaderMutations.SET_LOADING, false, { root: true });
        }
    }
};
