<template>
    <div>
        <VSubheader>{{ label }}</VSubheader>
        <VSelect
            :value="inputValue"
            :items="items"
            :placeholder="label"
            @change="onChange"
            required
            solo
            outlined
        ></VSelect>
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
        items: {
            type: Array,
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
