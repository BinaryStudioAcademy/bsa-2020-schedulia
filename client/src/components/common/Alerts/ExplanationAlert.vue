<template>
    <VAlert :type="status" dense outlined text dismissible :value="visibility">
        <h6>{{ shotDescription }}</h6>
        <p>{{ explanation }}</p>
    </VAlert>
</template>

<script>
export default {
    name: 'ExplanationAlert',
    props: {
        status: { type: String, default: 'error' },
        visibility: { type: Boolean, default: false },
        shotDescription: { type: String, default: '' },
        explanation: { type: String, default: '' }
    }
};
</script>

<style scoped>
h6 {
    font-style: normal;
    font-weight: bold;
    font-size: 20px;
    line-height: 32px;
}
p {
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.25px;
}
</style>
