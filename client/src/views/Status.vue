<template>
    <div class="status"></div>
</template>
<script>
import requestService from '@/services/requestService';
export default {
    async mounted() {
        const result = await requestService.get('/api/status');

        console.log(result);
    }
};
</script>
