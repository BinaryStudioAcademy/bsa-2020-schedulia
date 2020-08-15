<template>
    <div>
        <VSubheader>{{ label }}</VSubheader>
        <VTextarea
            :value="inputValue"
            @input="onChange"
            :placeholder="label"
            required
            dense
            no-resize
            outlined
        ></VTextarea>
    </div>
</template>

<script>
export default {
    name: 'ProfileTextArea',
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

<style scoped></style>
