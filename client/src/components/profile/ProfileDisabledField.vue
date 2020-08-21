<template>
    <div>
        <VSubheader>{{ label }}</VSubheader>
        <VTextField
            :value="inputValue"
            @input="onChange"
            :placeholder="label"
            outlined
            readonly
            dense
            required
        ></VTextField>
    </div>
</template>

<script>
export default {
    name: 'ProfileDisabledField',
    props: {
        label: {
            type: String,
            required: true
        },
        value: {},
        defaultValue: {}
    },

    computed: {
        inputValue() {
            return this.value || this.defaultValue;
        }
    },

    methods: {
        onChange(value) {
            this.$emit('change', value);
        }
    }
};
</script>

<style scoped>
.v-input__slot {
    box-shadow: none;
}
</style>
