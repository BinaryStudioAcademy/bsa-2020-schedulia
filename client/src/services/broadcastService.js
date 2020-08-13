import Pusher from 'pusher-js';

const pusher = new Pusher(process.env.VUE_APP_PUSHER_KEY, {
    cluster: process.env.VUE_APP_PUSHER_APP_CLUSTER
});

const broadcastService = {
    subscribe(channel) {
        return pusher.subscribe(channel);
    }
};

export default broadcastService;
