<template>
    <div class="row">
        <div class="col-md-6 row">
            <div class="col-md-1 text-right">
                <Avatar :size="48"></Avatar>
            </div>

            <div class="col">
                <span class="user-name">{{ user.name }}</span>
                <br />
                <a>shedulia.xyz/nickname</a>
            </div>
        </div>
        <div class="col-md-6 text-right new-event-type-btn">
            <RouterLink :to="{ name: 'new-event' }">
                <VBtn class="ma-2" outlined color="indigo">
                    {{ lang.NEW_EVENT_TYPE }}
                    <VIcon right dark>mdi-plus</VIcon>
                </VBtn>
            </RouterLink>
            <VBtn class="ma-2 text-left" outlined fab small color="indigo">
                <VIcon dark>mdi-chevron-down</VIcon>
            </VBtn>
        </div>
    </div>
</template>

<script>
import * as getters from '@/store/modules/auth/types/getters';
import { mapGetters } from 'vuex';
import Avatar from '@/components/common/GeneralLayout/Avatar';
import enLang from '@/store/modules/i18n/en';
export default {
    name: 'ActionBlock',
    data: () => ({
        lang: enLang
    }),
    components: {
        Avatar
    },
    computed: {
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
