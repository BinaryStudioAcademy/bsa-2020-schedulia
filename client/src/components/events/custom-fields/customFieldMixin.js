import { mapActions, mapGetters } from 'vuex';
import * as actions from '@/store/modules/eventTypes/types/actions';
import * as getters from '@/store/modules/eventTypes/types/getters';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    methods: {
        ...mapActions('eventTypes', {
            setCustomField: actions.SET_CUSTOM_FIELD
        })
    },
    computed: {
        ...mapGetters('eventTypes', {
            getCustomFields: getters.GET_CUSTOM_FIELDS
        }),
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
