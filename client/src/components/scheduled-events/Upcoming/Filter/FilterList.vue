<template>
    <VRow class="filter">
        <VCol>
            <EventTypes />
        </VCol>
        <VCol>
            <EventTypesTags />
        </VCol>
        <VCol>
            <Status />
        </VCol>
        <VCol>
            <InviteeEmails />
        </VCol>
        <VCol class="text-center" align-self="center">
            <VBtn :to="{ name: 'Upcoming' }" class="reset-button" outlined>
                {{ lang.RESET }}
            </VBtn>
        </VCol>
        <VCol align-self="center">
            <SearchInput />
        </VCol>
    </VRow>
</template>

<script>
import { mapGetters } from 'vuex';
import EventTypes from './EventTypes';
import Status from './Status';
import InviteeEmails from './InviteeEmails';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import EventTypesTags from './EventTypesTags';
import SearchInput from './SearchInput';

export default {
    name: 'FilterList',

    components: {
        SearchInput,
        EventTypesTags,
        InviteeEmails,
        Status,
        EventTypes
    },

    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
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
