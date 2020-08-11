<template>
    <VCol cols="12">
        <VRow class="justify-space-between">
            <VCol cols="3">
                <VBtn
                    outlined
                    class="primary--text py-5 rounded-lg"
                >
                    <VImg
                        src="https://img.icons8.com/metro/14/281AC8/back.png"
                        alt=""
                    />
                    <span class="back-button">
                        Back
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
                    <VSubheader>Your event type is {{ eventSwitch ? 'On' : 'Off' }}</VSubheader>
                    <VSwitch v-model="eventSwitch"></VSwitch>
                </VFlex>
            </VCol>
        </VRow>
    </VCol>
</template>

<script>
export default {
    name: 'NewEventTypeCard',

    data() {
        return {
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

</style>