<template>
    <div>
        <div>
            <VCol
                cols="12"
                md="6"
                v-for="field in fields"
                :key="field.id"
                class="mb-3 custom-field"
                :class="'custom-field-' + field.id"
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
                :disabled="!Object.values(fields).length"
            >
                {{ lang.SAVE_AND_CLOSE }}
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
import customFieldMixin from '@/components/events/custom-fields/customFieldMixin';

export default {
    name: 'CreateEventTypeQuestions',
    components: {
        AddNewFieldDialog,
        EditFieldDialog
    },
    mixins: [customFieldMixin],
    computed: {
        ...mapGetters('eventTypes', {
            fields: getters.GET_CUSTOM_FIELDS,
            toDeleteIds: getters.GET_TO_DELETE_IDS
        })
    },
    data: () => ({
        eventTypeId: ''
    }),
    methods: {
        ...mapActions('eventTypes', {
            saveCustomFields: actions.SAVE_CUSTOM_FIELDS,
            fetchCustomFieldsByEventTypeId:
                actions.FETCH_CUSTOM_FIELDS_BY_EVENT_ID
        }),
        async onSaveCustomFields() {
            await this.saveCustomFields({
                id: this.eventTypeId,
                custom_fields: this.fields,
                to_delete_ids: this.toDeleteIds
            });
            this.$router.push({ name: 'EventTypes' });
        }
    },
    async mounted() {
        this.eventTypeId = this.$route.params.id;
        await this.fetchCustomFieldsByEventTypeId(this.eventTypeId);
    }
};
</script>

<style scoped>
.v-btn {
    font-size: 13px;
}
.custom-field {
    cursor: pointer;
    background: #e5e5e5;
    border-radius: 10px;
}
</style>
