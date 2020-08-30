<template>
    <VDialog
        v-model="dialogVisible"
        persistent
        max-width="600px"
        :activator="'.custom-field-' + customFieldId"
    >
        <VCard>
            <VCardTitle>
                <span class="headline"
                    >Edit <u>{{ customField.name }}</u></span
                >
            </VCardTitle>
            <VCardText>
                <span class="subtitle-2">Question</span>
                <VTextarea
                    id="name"
                    v-model="customFieldName"
                    solo
                    dense
                    height="100"
                    outlined
                    no-resize
                    :error-messages="nameErrors"
                ></VTextarea>
                <span class="subtitle-2">Answer type</span>
                <VSelect
                    id="type"
                    :items="types"
                    solo
                    label="Answer Type"
                    :value="customFieldType"
                ></VSelect>
                <VBtn color="red" outlined @click="onDelete">
                    <VIcon left>mdi-delete</VIcon>
                    Delete field
                </VBtn>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialogVisible = false"
                    >Close</VBtn
                >
                <VBtn color="blue darken-1" text @click="onSave">Save</VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import * as getters from '@/store/modules/eventTypes/types/getters';
import * as actions from '@/store/modules/eventTypes/types/actions';
import { mapGetters, mapActions } from 'vuex';
import { required, minLength } from 'vuelidate/lib/validators';
import { validationMixin } from 'vuelidate';
import customFieldMixin from '@/components/events/custom-fields/customFieldMixin';
export default {
    name: 'EditFieldDialog',
    validations: {
        customFieldName: {
            required,
            minLength: minLength(5)
        }
    },
    mixins: [customFieldMixin, validationMixin],
    data: () => ({
        dialogVisible: false,
        customFieldType: '',
        customFieldName: '',
        types: ['Line']
    }),
    props: {
        customFieldId: {
            required: true
        }
    },
    methods: {
        ...mapActions('eventTypes', {
            deleteCustomField: actions.DELETE_CUSTOM_FIELD
        }),
        onSave() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.setCustomField({
                id: this.customFieldId,
                type: this.customFieldType.toLowerCase(),
                name: this.customFieldName
            });
            this.$v.$reset();
            this.dialogVisible = false;
        },
        onDelete() {
            this.deleteCustomField(this.customFieldId);
            this.dialogVisible = false;
        }
    },
    async created() {
        let firstLetter = this.customField.type.charAt(0).toUpperCase();
        this.customFieldType = firstLetter + this.customField.type.slice(1);
        this.customFieldName = this.customField.name;
    },
    computed: {
        ...mapGetters('eventTypes', {
            getCustomFieldById: getters.GET_CUSTOM_FIELD_BY_ID
        }),
        customField() {
            return this.getCustomFieldById(this.customFieldId);
        },
        nameErrors() {
            const errors = [];
            if (!this.$v.customFieldName.$dirty) {
                return errors;
            }
            !this.$v.customFieldName.required &&
                errors.push('Name is required');
            !this.$v.customFieldName.minLength &&
                errors.push('Name must be more than 5');
            return errors;
        }
    }
};
</script>

<style scoped></style>
