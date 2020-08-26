<template>
    <VContainer class="background-none">
        <div class="row ma-0">
            <VCol cols="12" sm="12" md="3" class="pa-0">
                <VTextField
                    class="search-input"
                    type="text"
                    :label="lang.SEARCH"
                    prepend-inner-icon="mdi-magnify"
                    dense
                    filled
                    solo
                    background-color="rgba(224, 224, 224, 0.3)"
                    v-model="searchString"
                    @input="onSearchInput"
                    :error-messages="searchErrors"
                    clearable
                ></VTextField>
            </VCol>
        </div>
        <ActionBlock />
        <VDivider />
        <div
            class="event-types-block row-flex flex-wrap flex-row d-flex"
            v-if="eventTypes"
        >
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
                :disabled="!loadMoreActive"
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
import { maxLength } from 'vuelidate/lib/validators';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { validationMixin } from 'vuelidate';

export default {
    name: 'EventTypesList',
    components: {
        ActionBlock,
        EventType,
        NoEventTypes
    },
    mixins: [validationMixin],
    validations: {
        searchString: {
            maxLength: maxLength(250)
        }
    },
    data: () => ({
        searchString: '',
        page: 1,
        loadMoreActive: true
    }),
    methods: {
        ...mapActions('eventTypes', {
            fetchEventTypes: actions.FETCH_EVENT_TYPES
        }),
        async onSearchInput() {
            this.page = 1;
            this.$v.searchString.$touch();
            await this.fetchEventTypes({
                searchString: this.searchString,
                page: this.page
            });
        },
        async onLoadMore() {
            let eventTypes = await this.fetchEventTypes({
                searchString: this.searchString,
                page: this.page + 1
            });
            if (eventTypes.length) {
                this.loadMoreActive = true;
                this.page += 1;
            } else {
                this.loadMoreActive = false;
            }
        }
    },
    async mounted() {
        await this.fetchEventTypes({
            searchString: this.searchString,
            page: this.page
        });
    },
    computed: {
        ...mapGetters('eventTypes', {
            eventTypes: getters.GET_ALL_EVENT_TYPES
        }),
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        searchErrors() {
            const errors = [];
            if (!this.$v.searchString.$dirty) {
                return errors;
            }
            !this.$v.searchString.maxLength &&
                errors.push(this.lang.SEARCH_FIELD_MUST_BE_LESS_THAN);
            return errors;
        }
    }
};
</script>
