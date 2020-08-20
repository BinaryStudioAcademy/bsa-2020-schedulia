<template>
    <VRow class="justify-space-between">
        <VCol cols="3">
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
        <VCol cols="6">
            <h3 class="text-center">
                Add One-on-One Event Type
            </h3>
        </VCol>
        <VCol cols="3">
            <VFlex row class="align-center justify-end">
                <VSubheader class="app-subheader">
                    {{ lang.YOUR_EVENT_TYPE_IS }}
                    {{ !eventTypeForm.disabled ? 'On' : 'Off' }}
                </VSubheader>
                <VSwitch
                    :value="!eventTypeForm.disabled"
                    @change="changeDisabled(!eventTypeForm.disabled)"
                ></VSwitch>
            </VFlex>
        </VCol>
    </VRow>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
import { mapGetters, mapMutations } from 'vuex';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import * as eventTypeMutations from '@/store/modules/eventType/types/mutations';

export default {
    name: 'NewEventTypeCard',

    data() {
        return {
            lang: enLang
        };
    },
    computed: {
        ...mapGetters('eventType', {
            eventTypeForm: eventTypeGetters.GET_EVENT_TYPE_FORM
        })
    },
    methods: {
        changeDisabled(data) {
            this.setEventTypeDisabled(data);
        },
        ...mapMutations('eventType', {
            setEventTypeDisabled:
                eventTypeMutations.SET_EVENT_TYPE_FORM_COLUMN_DISABLE
        })
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
