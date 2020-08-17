<template>
    <div class="row justify-space-between container ma-0">
        <VCol cols="12" md="6" sm="6">
            <VRow>
                <VCol cols="2" lg="1" md="2" class="">
                    <Avatar :size="48"></Avatar>
                </VCol>
                <VCol cols="10">
                    <span class="user-name">{{ user.name }}</span>
                    <br />
                    <a href="">shedulia.xyz/nickname</a>
                </VCol>
            </VRow>
        </VCol>
        <VCol cols="12" md="6" sm="6">
            <div class="new-event-type-btn text-right">
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
        </VCol>
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
