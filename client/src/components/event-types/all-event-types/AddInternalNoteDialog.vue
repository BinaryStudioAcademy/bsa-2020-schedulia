<template>
    <VDialog
        v-model="dialog"
        persistent
        max-width="600px"
        :activator="'#internal-note-' + eventType.id"
    >
        <VCard>
            <VCardTitle>
                <span class="headline">{{ lang.INTERNAL_NOTE }}</span>
            </VCardTitle>
            <VCardText>
                <span class="subtitle-1 text-center d-block mb-3"
                    >{{ lang.INTERNAL_NOTE_DESCRIPTION }}</span
                >
                <VTextarea
                    id="name"
                    solo
                    dense
                    height="100"
                    outlined
                    no-resize
                    counter="100"
                    v-model="internalNote"
                    :error-messages="internalNoteErrors"
                ></VTextarea>
            </VCardText>
            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="blue darken-1" text @click="dialog = false"
                    >{{ lang.CANCEL }}</VBtn
                >
                <VBtn color="blue darken-1" text @click="onSave">{{ lang.SAVE }}</VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import { maxLength } from 'vuelidate/lib/validators';
import { validationMixin } from 'vuelidate';
import { mapGetters, mapActions } from 'vuex';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as action from '@/store/modules/eventTypes/types/actions';
export default {
    name: 'AddInternalNoteDialog',
    data: () => ({
        dialog: false,
        internalNote: ''
    }),
    validations: {
        internalNote: {
            maxLength: maxLength(100)
        }
    },
    mixins: [validationMixin],
    props: {
        eventType: {
            required: true
        }
    },
    methods: {
        ...mapActions('eventTypes', {
            updateInternalNoteById: action.UPDATE_INTERNAL_NOTE
        }),
        async onSave() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            await this.updateInternalNoteById({
                id: this.eventType.id,
                internalNote: this.internalNote
            });
            this.dialog = false;
            this.$v.$reset();
        }
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        internalNoteErrors() {
            const errors = [];
            if (!this.$v.internalNote.$dirty) {
                return errors;
            }
            !this.$v.internalNote.maxLength &&
                errors.push(
                    this.lang.NAME +
                        this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                            'value',
                            '100'
                        )
                );
            return errors;
        }
    },
    created() {
        this.internalNote = this.eventType.internalNote;
    }
};
</script>

<style scoped></style>
