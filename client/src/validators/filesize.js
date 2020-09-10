import { helpers } from 'vuelidate/lib/validators';

export const fileSize = (options = {}) => {
    return helpers.withParams(options, value => {
        if (!value) {
            return true;
        }
        const sizeInKb = value.size / 1024;
        const size = Math.round(sizeInKb * 100) / 100;

        return size <= options.maxFileSizeKb;
    });
};
