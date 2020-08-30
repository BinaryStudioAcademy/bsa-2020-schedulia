import * as actions from '@/store/modules/eventTypes/types/actions';
import * as getters from '@/store/modules/eventTypes/types/getters';
import { mapActions, mapGetters } from 'vuex';
export default {
    methods: {
        ...mapActions('eventTypes', {
            setCustomField: actions.SET_CUSTOM_FIELD
        })
    },
    computed: {
        ...mapGetters('eventTypes', {
            getCustomFields: getters.GET_CUSTOM_FIELDS
        })
    }
};
