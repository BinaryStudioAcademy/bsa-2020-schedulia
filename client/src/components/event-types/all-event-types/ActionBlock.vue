<template>
    <div class="row justify-space-between container ma-0">
        <VCol cols="12" md="6" sm="6">
            <VRow>
                <VCol cols="2" lg="1" md="2" class="">
                    <Avatar :size="48" :color="'black'"></Avatar>
                </VCol>
                <VCol cols="10">
                    <span class="user-name">{{ user.name }}</span>
                    <br />
                    <RouterLink :to="{ path: user.nickname }">
                        {{ domain }}/{{ user.nickname }}
                    </RouterLink>
                </VCol>
            </VRow>
        </VCol>
        <VCol cols="12" md="6" sm="6">
            <div class="new-event-type-btn text-right">
                <RouterLink :to="{ name: 'newEventType' }">
                    <VBtn class="ma-2" outlined color="indigo">
                        {{ lang.NEW_EVENT_TYPE }}
                        <VIcon right dark>mdi-plus</VIcon>
                    </VBtn>
                </RouterLink>
            </div>
        </VCol>
    </div>
</template>

<script>
import * as getters from '@/store/modules/auth/types/getters';
import { mapGetters } from 'vuex';
import Avatar from '@/components/common/Avatar/Avatar';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
export default {
    name: 'ActionBlock',
    data: () => ({
        domain: ''
    }),
    components: {
        Avatar
    },
    mounted() {
        this.domain = window.location.hostname;
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('auth', {
            user: getters.GET_LOGGED_USER
        })
    }
};
</script>

<style scoped>
.user-name {
    font-weight: bold;
}
.new-event-type-btn a {
    text-decoration: none;
}
</style>
