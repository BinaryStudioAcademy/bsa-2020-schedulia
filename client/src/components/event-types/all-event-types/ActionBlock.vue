<template>
    <div class="row">
        <div class="row col-md col-sm-12">
            <div class="col-lg-1 col-md-1 col-sm-2">
                <Avatar :size="48"></Avatar>
            </div>

            <div class="col-lg-11 col-md-11 col-sm-10">
                <span class="user-name">{{ user.name }}</span>
                <br />
                <a href="">shedulia.xyz/nickname</a>
            </div>
        </div>
        <div class="col-md text-right">
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
