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
    [mutations.SET_VISIBILITY_FORGOT]: (state, value) => {
        state.forgotPasswordData = {
            ...state.forgotPasswordData,
            explanationVisibility: value
        };
    },
    [mutations.SET_EXPLANATION_RESET]: (state, text) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            explanation: text
        };
    },
    [mutations.SET_STATUS_SUBMIT_RESET]: (state, text) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            status: text
        };
    },
    [mutations.SET_SHORT_DESC_SUBMIT_RESET]: (state, text) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            shotDescription: text
        };
    },
    [mutations.SET_EMAIL_RESET]: (state, email) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            email: email
        };
    },
    [mutations.SET_VISIBILITY_RESET]: (state, value) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            explanationAlertVisibility: value
        };
    },
    [mutations.SET_PASSWORD_RESET]: (state, value) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            password: value
        };
    },
    [mutations.SET_PASSWORD_CONFIRM_RESET]: (state, value) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            confirmPassword: value
        };
    },
    [mutations.SET_TOKEN_RESET]: (state, value) => {
        state.resetPasswordData = {
            ...state.resetPasswordData,
            token: value
        };
    }
};
