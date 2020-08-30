<template>
    <VDialog v-model="dialog" persistent max-width="600px">
        <template v-slot:activator="{ on, attrs }">
            <VBtn
                color="primary"
                class="white--text"
                v-bind="attrs"
                v-on="on"
                outlined
            >
                + Add new Field
            </VBtn>
        </template>
        <VCard>
            <VCardTitle>
                <span class="headline">{{ lang.ADD_NEW_FIELD }}</span>
            </VCardTitle>
            <VCardText>
                <span class="subtitle-2">{{ lang.QUESTION }}</span>
                <VTextarea
                    id="name"
                    v-model="name"
                    solo
                    dense
                    height="100"
                    outlined
                    no-resize
                    :error-messages="nameErrors"
                ></VTextarea>
                <span class="subtitle-2">{{ lang.ANSWER_TYPE }}</span>
                <VSelect
                    id="type"
                    :items="types"
                    solo
                    :label="lang.ANSWER_TYPE"
                    :value="type"
                ></VSelect>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false">{{
                    lang.CLOSE
                }}</VBtn>
                <VBtn color="blue darken-1" text @click="onSave">{{
                    lang.SAVE
                }}</VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import customFieldMixin from '@/components/events/custom-fields/customFieldMixin';
import { required, minLength } from 'vuelidate/lib/validators';
import { validationMixin } from 'vuelidate';
import { v4 as uuidv4 } from 'uuid';
export default {
    name: 'AddNewFiledDialog',
    validations: {
        name: {
            required,
            minLength: minLength(5)
        }
    },
    mixins: [customFieldMixin, validationMixin],
    data: () => ({
        dialog: false,
        type: '',
        name: '',
        types: ['Line']
    }),
    methods: {
        onSave() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.setCustomField({
                id: uuidv4(),
                type: this.type.toLowerCase(),
                name: this.name
            });
            this.name = '';
            this.$v.$reset();
            this.dialog = false;
        }
    },
    async created() {
        this.type = this.types[0];
    },
    computed: {
        nameErrors() {
            const errors = [];
            if (!this.$v.name.$dirty) {
                return errors;
            }
            !this.$v.name.required && errors.push('Name is required');
            !this.$v.name.minLength && errors.push('Name must be more than 5');
            return errors;
        }
    }
};
</script>

<style scoped>
.v-btn {
    text-transform: none;
}
</style>
