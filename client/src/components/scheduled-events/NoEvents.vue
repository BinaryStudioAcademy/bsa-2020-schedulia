<template>
    <VContainer class="no-events">
        <VRow class="text-center">
            <VCol align-self="center">
                <img class="" :src="require('@/assets/images/no-events.svg')" />
                <div class="no-events-title">
                    <slot></slot>
                </div>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
export default {
    name: 'NoEvents'
};
</script>

<style scoped></style>
