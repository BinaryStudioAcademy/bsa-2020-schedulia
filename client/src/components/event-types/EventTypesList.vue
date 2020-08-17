<template>
    <VContainer class="background-none">
        <div class="row ma-0">
            <VCol cols="12" sm="12" md="3" class="pa-0">
                <VTextField
                    type="text"
                    :label="lang.SEARCH"
                    prepend-inner-icon="mdi-magnify"
                    dense
                    filled
                    solo-inverted
                    v-model="searchString"
                    @input="onSearchInput"
                ></VTextField>
            </VCol>
        </div>
        <ActionBlock />
        <VDivider />
        <div class="event-types-block row" v-if="eventTypes.length">
            <VCol
                cols="12"
                md="4"
                lg="3"
                sm="6"
                v-for="eventType in eventTypes"
                :key="eventType.id"
            >
                <EventType :eventType="eventType" />
            </VCol>
        </div>
        <NoEventTypes v-else />
    </VContainer>
</template>

<script>
import ActionBlock from '@/components/event-types/all-event-types/ActionBlock';
import EventType from '@/components/event-types/all-event-types/EventType';
import NoEventTypes from '@/components/event-types/all-event-types/NoEventTypes';
import * as actions from '@/store/modules/eventTypes/types/actions';
import * as getters from '@/store/modules/eventTypes/types/getters';
import { mapActions, mapGetters } from 'vuex';
import enLang from '@/store/modules/i18n/en';

export default {
    name: 'EventTypesList',
    components: {
        ActionBlock,
        EventType,
        NoEventTypes
    },
    data: () => ({
        searchString: '',
        lang: enLang
    }),
    methods: {
        ...mapActions('eventTypes', {
            fetchAllEventTypes: actions.FETCH_ALL_EVENT_TYPES,
            searchEventTypes: actions.SEARCH_EVENT_TYPE
        }),
        async onSearchInput() {
            await this.searchEventTypes(this.searchString);
        }
    },
    async mounted() {
        await this.fetchAllEventTypes();
    },
    computed: {
        ...mapGetters('eventTypes', {
            eventTypes: getters.GET_ALL_EVENT_TYPES
        })
    }
};
</script>
