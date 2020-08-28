<template>
    <VMenu
        nudge-bottom="30"
        nudge-left="150"
        close-on-click
        :close-on-content-click="false"
    >
        <template v-slot:activator="{ on, attrs }">
            <VBtn icon color="primary" v-bind="attrs" v-on="on">
                <VIcon dark>mdi-dots-horizontal</VIcon>
            </VBtn>
        </template>
        <VList>
            <VListItem dense disabled>
                <VListItemTitle>
                    <VIcon color="primary">mdi-pencil</VIcon>
                    {{ lang.EDIT }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense disabled>
                <VListItemTitle>
                    <VIcon color="primary">mdi-file-outline</VIcon>
                    {{ lang.ADD_INTERNAL_NOTE }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense disabled>
                <VListItemTitle>
                    <VIcon color="primary">mdi-content-copy</VIcon>
                    {{ lang.CLONE }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense disabled>
                <VListItemTitle>
                    <VIcon color="primary">mdi-xml</VIcon>
                    {{ lang.ADD_TO_WEBSITE }}
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <VIcon color="primary">mdi-delete</VIcon>
                    <DeleteConfirmDialog :eventType="eventType" />
                </VListItemTitle>
            </VListItem>
            <VListItem dense>
                <VListItemTitle>
                    <div class="switch-item">
                        <div class="pa-0 ma-0">
                            {{ lang.ENABLED }}
                        </div>
                        <div class="pa-0 ma-0">
                            <VSwitch
                                inset
                                v-model="switchStatus"
                                @change="onSwitch"
                            ></VSwitch>
                        </div>
                    </div>
                </VListItemTitle>
            </VListItem>
        </VList>
    </VMenu>
</template>

<script>
import * as actions from '@/store/modules/eventTypes/types/actions';
import { mapActions, mapGetters } from 'vuex';
import DeleteConfirmDialog from '@/components/event-types/all-event-types/DeleteConfirmDialog';
import * as i18nGetters from '@/store/modules/i18n/types/getters';

export default {
    name: 'DropDown',
    components: {
        DeleteConfirmDialog
    },
    data: () => ({
        switchStatus: false,
        dialog: false
    }),
    props: {
        eventType: {
            required: true
        }
    },
    created() {
        this.switchStatus = !this.eventType.disabled;
    },
    methods: {
        ...mapActions('eventTypes', {
            disableEventType: actions.DISABLE_EVENT_TYPE_BY_ID
        }),
        onSwitch() {
            this.disableEventType({
                id: this.eventType.id,
                disabled: !this.switchStatus
            });
        }
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        })
    }
};
</script>

<style scoped>
.v-list-item {
    cursor: pointer;
}
.v-list-item__title a {
    text-decoration: none;
    color: #000;
}
.switch-item {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.switch-item div:first-child {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
