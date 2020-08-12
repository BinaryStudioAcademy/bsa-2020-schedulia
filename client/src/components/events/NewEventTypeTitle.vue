<template>
    <VRow class="justify-space-between">
        <VCol cols="3">
            <VBtn outlined class="primary--text py-5 rounded-lg">
                <VImg
                    src="https://img.icons8.com/metro/14/281AC8/back.png"
                    alt=""
                />
                <span class="back-button">
                    {{ lang.BACK }}
                </span>
            </VBtn>
        </VCol>
        <VCol cols="6">
            <h3 class="text-center">
                Add One-on-One Event Type
            </h3>
        </VCol>
        <VCol cols="3">
            <VFlex row class="align-center justify-end">
                <VSubheader class="app-subheader"
                    >{{ lang.YOUR_EVENT_TYPE_IS }}
                    {{ eventSwitch ? 'On' : 'Off' }}</VSubheader
                >
                <VSwitch v-model="eventSwitch"></VSwitch>
            </VFlex>
        </VCol>
    </VRow>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
export default {
    name: 'NewEventTypeCard',

    data() {
        return {
            lang: enLang,
            eventSwitch: ''
        };
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
</style>
