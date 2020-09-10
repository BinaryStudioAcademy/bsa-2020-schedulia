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
            :error-messages="errors"
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
        defaultValue: {},
        errors: {}
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
