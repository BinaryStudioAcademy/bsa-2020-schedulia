export default {
    BRANDING: 'Branding',

    CHARACTERS: 'Characters',
    CHANGE_PASSWORD: 'Change password',
    CLOSE: 'Close',
    CURRENT_PASSWORD: 'Current password',

    EMAIL: 'Email',

    INDICATES_REQUIRED_FIELD: 'Indicates required field',
    INVALID_EMAIL: 'Invalid email',

    PASSWORD: 'Password',
    PASSWORD_DOESNT_MATCH: "Password doesn't match confirmation",
    PROFILE: 'Profile',

    REQUIRED: 'Required',
    REPEAT_NEW_PASSWORD: 'Repeat new password',

    SAVE: 'Save',

    LOGIN: 'Login',

    MAX: 'Max',
    MIN: 'Min',

    NEW_PASSWORD: 'New password',

    YOU_LOG_IN_WITH_AN_EMAIL_ADDRESS_AND_PASSWORD:
        'You log in with an email address and password',

    CREATE_AN_ACCOUNT: 'Create an account',
    ALREADY_REGISTERED: 'Already registered?',
    LOG_IN: 'Log in',
    FULL_NAME: 'Full Name',
    NAME: 'Name',
    CONFIRM_PASSWORD: 'Confirm Password',
    SIGN_UP: 'Sign Up',
    SUCCESSFULLY_REGISTERED: 'Successfully registered! Now you can authorize!',
    PASSWORDS_DONT_MATCH: "Passwords don't match",
    fieldIsRequired(field = '') {
        return field + ' is required';
    },
    valueMustBeMore(field = '', value = '') {
        return field + ' must be more than ' + value + ' characters!';
    }
};
