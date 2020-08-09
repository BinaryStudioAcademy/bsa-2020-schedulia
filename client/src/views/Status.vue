<template>
    <GeneralLayout>
        <StatusTable />

        <template v-slot:title>
            Status
        </template>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import StatusTable from '../components/status/StatusTable.vue';

export default {
    components: {
        GeneralLayout,
        StatusTable
    }
};
</script>
