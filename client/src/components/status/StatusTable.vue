<template>
    <div>
        <BorderBottom />
        <VContainer class="container-content">
            <VDataTable
                :headers="headers"
                :items="items"
                :disable-pagination="true"
                :hide-default-footer="true"
                disable-sort
            >
                <template v-slot:item.status="{ item }">
                    <VIcon v-if="item.status === true" color="success"
                        >mdi-check</VIcon
                    >
                    <VIcon v-else-if="item.status === false" color="error">
                        mdi-skull-crossbones-outline
                    </VIcon>
                    <VProgressCircular v-else indeterminate color="primary" />
                </template>
            </VDataTable>
            <VBtn @click="setErrorNotification('Error notification')"
                >Get Alert</VBtn
            >
            <VBtn @click="sendNotification">Broadcast</VBtn>
        </VContainer>
    </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import * as statusGetters from '@/store/modules/status/types/getters';
import * as statusActions from '@/store/modules/status/types/actions';
import * as notificationActions from '@/store/modules/notification/types/actions';
import BorderBottom from '../common/GeneralLayout/BorderBottom';
import broadcastService from '@/services/broadcastService';
import requestService from '@/services/requestService';

export default {
    components: {
        BorderBottom
    },

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
            services: statusGetters.GET_STATUS_MAP
        }),

        items() {
            return this.services.map(serviceId => this.serviceById[serviceId]);
        }
    },

    methods: {
        ...mapActions('status', {
            getStatusByName: statusActions.GET_SERVICE_STATUS_BY_NAME
        }),

        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION,
            setInfoNotification: notificationActions.SET_INFO_NOTIFICATION
        }),

        sendNotification() {
            requestService.post('/broadcast', { message: 'Test message' });
        }
    },

    mounted() {
        this.getStatusByName('app');
        this.getStatusByName('server');
        this.getStatusByName('redis');
        this.getStatusByName('cache');
        this.getStatusByName('database');
        this.getStatusByName('storage');

        broadcastService.subscribe('test-channel').bind('test-event', data => {
            this.setInfoNotification(data.message);
        });
    }
};
</script>
