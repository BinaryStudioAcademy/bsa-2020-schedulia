<template>
    <VTooltip right max-width="300">
        <template v-slot:activator="{ on, attrs }">
            <VBtn color="primary" icon v-bind="attrs" v-on="on">
                <VIcon color="grey lighten-1">mdi-help-circle-outline</VIcon>
            </VBtn>
        </template>
        <span>
            <slot></slot>
        </span>
    </VTooltip>
</template>

<script>
export default {
    name: 'TooltipIcon'
};
</script>
