<template>
    <VDataTable
        :headers="headers"
        :items="items"
        :disable-pagination="true"
        :hide-default-footer="true"
        disable-sort
    />
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import * as statusGetters from '@/store/modules/status/types/getters';
import * as statusActions from '@/store/modules/status/types/actions';

export default {
    components: {},

    data() {
        return {
            headers: [
                {
                    text: 'Service Name',
                    value: 'name',
                    align: 'start',
                    width: '140px'
                },
                {
                    text: 'Status Text',
                    value: 'statusText',
                    align: 'start'
                },
                {
                    text: 'Status',
                    value: 'status',
                    align: 'start',
                    width: '16px'
                }
            ]
        };
    },

    computed: {
        ...mapGetters('status', {
            serviceById: statusGetters.GET_STATUS_BY_ID,
            services: statusGetters.GET_STATUS_MAP,
            isFetching: statusGetters.GET_STATUS_FETCHING
        }),

        items() {
            return this.services.map(serviceId => this.serviceById[serviceId]);
        }
    },

    methods: {
        ...mapActions('status', {
            getStatusByName: statusActions.GET_SERVICE_STATUS_BY_NAME
        })
    },

    mounted() {
        this.getStatusByName('app');
        this.getStatusByName('server');
        this.getStatusByName('database');
        this.getStatusByName('redis');
        this.getStatusByName('storage');
    }
};
</script>
