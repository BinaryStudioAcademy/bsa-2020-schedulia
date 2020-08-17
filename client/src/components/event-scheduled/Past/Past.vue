<template>
    <div>
        <FilterList v-if="this.EvenFilterView" />
        <BorderBottom />
        <Events />
        <Events />
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { GET_EVENT_FILTER_VIEW } from '@/store/modules/eventScheduled/types/getters';
import FilterList from './Filter/FilterList';
import BorderBottom from '../../common/GeneralLayout/BorderBottom';
import Events from '../ScheduledEvents/Events';
export default {
    name: 'Past',

    components: {
        Events,
        BorderBottom,
        FilterList
    },

    computed: {
        ...mapGetters('eventScheduled', {
            EvenFilterView: GET_EVENT_FILTER_VIEW
        })
    }
};
</script>

<style scoped></style>
