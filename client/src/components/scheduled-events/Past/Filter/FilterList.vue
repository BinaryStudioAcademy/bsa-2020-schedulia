<template>
    <VRow class="filter">
        <VCol>
            <Teams />
        </VCol>
        <VCol>
            <EventTypes />
        </VCol>
        <VCol>
            <Status />
        </VCol>
        <VCol>
            <InviteeEmails />
        </VCol>
        <VCol class="text-right" align-self="center">
            <VBtn :to="{ name: 'Past' }" class="reset-button" outlined>
                {{ lang.RESET }}
            </VBtn>
        </VCol>
    </VRow>
</template>

<script>
import { mapGetters } from 'vuex';
import Teams from './Teams';
import EventTypes from './EventTypes';
import Status from './Status';
import InviteeEmails from './InviteeEmails';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    name: 'FilterList',

    components: {
        InviteeEmails,
        Status,
        EventTypes,
        Teams
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
    }
};
</script>

<style scoped>
.filter::v-deep {
    padding: 15px 43px;
    margin: 0;
}

.reset-button::v-deep {
    border: 1px solid #e0e0e0;
    color: #2c2c2c;
    font-weight: 500;
    font-size: 13px;
    line-height: 16px;
    text-transform: none;
}
</style>
