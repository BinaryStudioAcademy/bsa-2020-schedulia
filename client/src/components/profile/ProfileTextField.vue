<template>
    <div>
        <VSubheader>{{ label }}</VSubheader>
        <VTextField
            :value="inputValue"
            @input="onChange"
            :placeholder="label"
            required
            solo
            outlined
        ></VTextField>
    </div>
</template>

<script>
export default {
    name: 'ProfileTextField',
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
