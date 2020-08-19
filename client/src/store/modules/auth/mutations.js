import * as mutations from './types/mutations';

export default {
    [mutations.USER_LOGOUT]: state => {
        state.user = null;
    },
    [mutations.SET_LOGGED_USER]: (state, userData) => {
        state.user = userData;
    },
    [mutations.SET_EXPLANATION_FORGOT]: (state, text) => {
        state.forgotPasswordData = {
            ...state.forgotPasswordData,
            explanation: text
        };
    },
    [mutations.SET_TYPE_RESULT_SUBMIT_FORGOT]: (state, text) => {
        state.forgotPasswordData = {
            ...state.forgotPasswordData,
            typeResultSubmitPassword: text
        };
    },
    [mutations.SET_RESULT_SUBMIT_FORGOT]: (state, text) => {
        state.forgotPasswordData = {
            ...state.forgotPasswordData,
            resultSubmitPassword: text
        };
    },
    [mutations.SET_EMAIL_FORGOT]: (state, email) => {
        state.forgotPasswordData = {
            ...state.forgotPasswordData,
            email: email
        };
    },
    [mutations.CHANGE_HELPER_VISIBILITY_FORGOT]: (state, value) => {
        state.forgotPasswordData = {
            ...state.forgotPasswordData,
            helperVisibility: value
        };
    }
};
