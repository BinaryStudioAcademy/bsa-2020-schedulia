<template>
    <div>
        <div
            v-for="(notification, index) in notifications.filter(
                s => s.showing
            )"
            :key="notification.text + Math.random()"
        >
            <Notification :index="index" :notification="notification" />
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import Notification from './Notification';

export default {
    name: 'Notifications',

    components: {
        Notification
    },

    computed: {
        ...mapState('notification', ['notifications'])
    }
};
</script>
