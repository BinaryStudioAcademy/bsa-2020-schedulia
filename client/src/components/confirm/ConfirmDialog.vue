<template>
    <div>
        <VDialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on, attrs }">
                <VBtn color="red darken-4" dark v-bind="attrs" v-on="on">
                    {{ buttonText }}
                </VBtn>
            </template>

            <VCard>
                <VCardTitle class="headline grey lighten-2">
                    {{ header }}
                </VCardTitle>

                <VCardText>
                    {{ content }}
                </VCardText>

                <VDivider></VDivider>

                <VCardActions>
                    <VSpacer></VSpacer>
                    <VBtn color="primary" text @click="confirm">
                        Confirm
                    </VBtn>
                    <VBtn text @click="dialog = false">
                        Cancel
                    </VBtn>
                </VCardActions>
            </VCard>
        </VDialog>
    </div>
</template>

<script>
export default {
    name: 'ConfirmDialog',
    props: {
        header: {
            type: String,
            required: true
        },
        content: {
            type: String,
            required: true
        },
        buttonText: {
            type: String,
            required: true
        }
    },
    data: () => ({
        dialog: false
    }),

    methods: {
        confirm() {
            this.$emit('confirm');
            this.dialog = false;
        }
    }
};
</script>

<style lang="scss" scoped>
.v-btn {
    font-size: 13px;
    text-transform: none;

    &.cancel {
        border-color: rgba(0, 0, 0, 0.12);
        background: none;
        box-shadow: none;
    }
}
</style>
