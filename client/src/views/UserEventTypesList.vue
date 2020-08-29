<template>
    <div class="container mt-16">
        <VCard elevation="5">
            <div class="list-heading text-center pa-8">
                <span
                    ><b>{{ ownerName }}</b></span
                ><br /><br />
                <div v-if="Object.values(eventTypes).length">
                    <span>Welcome to my scheduling page.</span><br />
                    <span
                        >Please follow the instructions to add an event to my
                        calendar.</span
                    ><br />
                </div>
                <div v-else>
                    <span>
                        <b>No openings at the moment.</b>
                    </span>
                </div>
            </div>
            <div
                v-if="Object.values(eventTypes).length"
                class="event-types row-flex d-flex flex-wrap flex-row px-10 py-10"
            >
                <VCol
                    cols="12"
                    md="6"
                    lg="3"
                    sm="6"
                    v-for="eventType in eventTypes"
                    :key="eventType.id"
                >
                    <RouterLink
                        :to="`/${eventType.owner.nickname}/${eventType.id}`"
                    >
                        <UserEventType :event-type="eventType" />
                    </RouterLink>
                </VCol>
            </div>
        </VCard>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import * as actions from '@/store/modules/eventTypes/types/actions';
import * as getters from '@/store/modules/eventTypes/types/getters';
import UserEventType from '@/components/public/users-event-types/UserEventType';
export default {
    name: 'UserEventTypesList',
    components: {
        UserEventType
    },
    data: () => ({}),
    methods: {
        ...mapActions('eventTypes', {
            fetchEventTypesByNickname: actions.FETCH_EVENT_TYPES_BY_NICKNAME
        })
    },
    async mounted() {
        await this.fetchEventTypesByNickname(this.userNickname);
    },
    computed: {
        userNickname() {
            return this.$route.params.nickname;
        },
        ...mapGetters('eventTypes', {
            eventTypes: getters.GET_EVENT_TYPES_BY_NICKNAME,
            ownerName: getters.GET_OWNER_NAME_BY_NICKNAME
        })
    }
};
</script>

<style scoped>
.container {
    background: #fff;
}
.event-types > div {
    min-height: 200px;
}
.event-types div.event-type {
    transition: 0.5s;
    cursor: pointer;
    height: 100%;
    border-top: 1px solid var(--text-color-level3, rgba(77, 80, 85, 0.6));
}
.event-types div.event-type:hover {
    background: var(--text-color-level3, rgba(77, 80, 85, 0.1));
}
.list-heading {
    color: var(--text-color-level2, rgba(77, 80, 85, 0.6));
}

a {
    text-decoration: none;
    color: #000;
}
</style>
