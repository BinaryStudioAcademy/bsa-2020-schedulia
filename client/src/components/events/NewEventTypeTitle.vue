<template>
    <VRow class="justify-space-between">
        <VCol cols="12" md="3" sm="3">
            <RouterLink :to="{ name: 'EventTypes' }" class="back-btn-link">
                <VBtn outlined class="primary--text py-5 rounded-lg">
                    <VImg
                        src="https://img.icons8.com/metro/14/281AC8/back.png"
                        alt=""
                    />
                    <span class="back-button">
                        {{ lang.BACK }}
                    </span>
                </VBtn>
            </RouterLink>
        </VCol>
        <VCol cols="12" md="6" sm="6">
            <h3 class="text-center">
                {{ lang.ADD_ONE_ON_ONE_EVENT_TYPE }}
            </h3>
        </VCol>
        <VCol cols="12" md="3" sm="3">
            <VFlex row class="align-center justify-end">
                <VSubheader class="app-subheader">
                    {{ lang.YOUR_EVENT_TYPE_IS }}
                    {{ !data.disabled ? 'On' : 'Off' }}
                </VSubheader>
                <VSwitch
                    :input-value="!data.disabled"
                    @change="changeDisabled(!data.disabled)"
                ></VSwitch>
            </VFlex>
        </VCol>
    </VRow>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters, mapActions } from 'vuex';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import * as actionEventType from '@/store/modules/eventType/types/actions';

export default {
    name: 'NewEventTypeCard',

    data() {
        return {};
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('eventType', {
            eventType: eventTypeGetters.GET_EVENT_TYPE
        }),
        data() {
            return this.eventType;
        }
    },
    methods: {
        ...mapActions('eventType', {
            setEventType: actionEventType.SET_EVENT_TYPE
        }),
        changeDisabled(data) {
            this.setEventType({ disabled: data });
        }
    }
};
</script>
<style scoped>
.back-button {
    text-transform: none;
    font-size: 13px;
    padding-left: 5px;
    padding-right: 10px;
}
.app-subheader {
    min-width: 182px;
}
.back-btn-link {
    text-decoration: none;
}
</style>
