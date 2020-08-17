<template>
    <div>
        <VSubheader>{{ label }}</VSubheader>
        <VTextField
            :value="inputValue"
            @input="onChange"
            :placeholder="label"
            outlined
            dense
            readonly
            :type="showPassword ? 'text' : 'password'"
            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append="showPassword = !showPassword"
        ></VTextField>
    </div>
</template>

<script>
export default {
    name: 'ProfileTextField',
    data: () => ({
        password: 'password',
        showPassword: false
    }),
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
