<template>
    <div>
        <div>
            <span class="subtitle-2">
                Please share anything that will help prepare for our meeting
            </span>
            <VCol cols="12" md="6">
                <VTextarea
                    solo
                    outlined
                    readonly
                    no-resize
                    label="Additional information"
                ></VTextarea>
            </VCol>
            <VCol
                cols="12"
                md="6"
                v-for="field in fields"
                :key="field.id"
                style="background: lightgray;border-radius: 10px;"
                class="mb-3 custom-field"
                :class="'custom-field-' + field.id"
                @click="onEditClick(field.id)"
            >
                <span class="subtitle-2">{{ field.name }}</span>
                <VTextField
                    v-if="field.type === 'line'"
                    outlined
                    dense
                    solo
                    disabled
                ></VTextField>
                <VTextarea
                    v-if="field.type === 'multiline'"
                    solo
                    outlined
                    disabled
                    no-resize
                ></VTextarea>
                <EditFieldDialog :custom-field-id="field.id" />
            </VCol>
        </div>
        <AddNewFieldDialog />
        <VDivider class="mt-5"></VDivider>
        <div class="mt-5">
            <VBtn
                color="primary"
                class="white--text"
                @click="onSaveCustomFields"
            >
                Save & Close
            </VBtn>
        </div>
    </div>
</template>

<script>
import AddNewFieldDialog from '@/components/events/custom-fields/AddNewFieldDialog';
import EditFieldDialog from '@/components/events/custom-fields/EditFieldDialog';
import { mapGetters, mapActions } from 'vuex';
import * as getters from '@/store/modules/eventTypes/types/getters';
import * as actions from '@/store/modules/eventTypes/types/actions';
export default {
    name: 'CreateEventTypeQuestions',
    components: {
        AddNewFieldDialog,
        EditFieldDialog
    },
    computed: {
        ...mapGetters('eventTypes', {
            fields: getters.GET_CUSTOM_FIELDS
        })
    },
    props: {
        eventTypeId: {
            required: true
        }
    },
    methods: {
        ...mapActions('eventTypes', {
            fetchCustomFields: actions.FETCH_CUSTOM_FIELDS_BY_EVENT_ID,
            saveCustomFields: actions.SAVE_CUSTOM_FIELDS
        }),
        async onSaveCustomFields() {
            await this.saveCustomFields({
                id: this.eventTypeId,
                custom_fields: this.fields
            });
            this.$router.push({ name: 'EventTypes' });
        }
    },
    async mounted() {
        await this.fetchCustomFields();
    }
};
</script>

<style scoped>
.v-btn {
    font-size: 13px;
}
.custom-field {
    cursor: pointer;
}
</style>
