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
                    :rules="searchRules"
                    clearable
                ></VTextField>
            </VCol>
        </div>
        <ActionBlock />
        <VDivider />
        <div class="event-types-block row" v-if="eventTypes">
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
        <div class="text-center">
            <VBtn
                color="primary"
                class="ma-2 white--text"
                @click="onLoadMore"
                rounded
            >
                <VIcon left dark>mdi-plus</VIcon>
                Load more
            </VBtn>
        </div>
    </VContainer>
</template>

<script>
import ActionBlock from '@/components/event-types/all-event-types/ActionBlock';
import EventType from '@/components/event-types/all-event-types/EventType';
import NoEventTypes from '@/components/event-types/all-event-types/NoEventTypes';
import * as actions from '@/store/modules/eventTypes/types/actions';
import * as getters from '@/store/modules/eventTypes/types/getters';
import { mapActions, mapGetters } from 'vuex';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    name: 'EventTypesList',
    components: {
        ActionBlock,
        EventType,
        NoEventTypes
    },
    data: () => ({
        searchString: '',
        searchRules: [
            v => v.length <= 250 || enLang.SEARCH_FIELD_MUST_BE_LESS_THAN
        ],
        page: 1
    }),
    methods: {
        ...mapActions('eventTypes', {
            fetchEventTypes: actions.FETCH_EVENT_TYPES
        }),
        async onSearchInput() {
            await this.fetchEventTypes({ searchString: this.searchString });
        },
        async onLoadMore() {
            this.page += 1;
            await this.fetchEventTypes({ page: this.page });
        }
    },
    async mounted() {
        await this.fetchEventTypes();
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('eventTypes', {
            eventTypes: getters.GET_ALL_EVENT_TYPES
        })
    }
};
</script>
