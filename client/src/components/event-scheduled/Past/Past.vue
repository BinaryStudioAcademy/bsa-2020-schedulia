<template>
    <div>
        <FilterList />
        <BorderBottom />
        <Events />
        <Events />
    </div>
</template>

<script>
import FilterList from './Filter/FilterList';
import BorderBottom from '../../common/GeneralLayout/BorderBottom';
import Events from '../ScheduledEvents/Events';
export default {
    name: 'Past',

    components: {
        Events,
        BorderBottom,
        FilterList
    }
};
</script>

<style scoped></style>
