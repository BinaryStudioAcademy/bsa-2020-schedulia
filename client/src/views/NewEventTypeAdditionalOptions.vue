<template>
    <GeneralLayout>
        <VContainer>
            <VCard class="mt-7">
                <VExpansionPanels accordion>
                    <VExpansionPanel @change="panel = 0">
                        <VExpansionPanelHeader>
                            <FirstTitle></FirstTitle>
                        </VExpansionPanelHeader>
                        <VExpansionPanelContent>
                            <VDivider class="mx-4"></VDivider>
                            <VRow>
                                <VCol cols="6" offset-md="2" offset-sm="2">
                                    <CreateEventTypeForm
                                        :is-booking="true"
                                        @changePanel="panel = 1"
                                    ></CreateEventTypeForm>
                                </VCol>
                            </VRow>
                        </VExpansionPanelContent>
                    </VExpansionPanel>
                    <VExpansionPanel @change="panel = 1">
                        <VExpansionPanelHeader>
                            <VRow align="center">
                                <VCol cols="2" md="1" sm="1" lg="1">
                                    <div>
                                        <img
                                            :src="
                                                require('@/assets/images/calender_circle.svg')
                                            "
                                            alt
                                            :class="{
                                                'pl-3': $vuetify.breakpoint.xs,
                                                'pl-10':
                                                    $vuetify.breakpoint.smAndUp
                                            }"
                                        />
                                    </div>
                                </VCol>
                                <VCol cols="10" class="pl-lg-5 pl-sm-10">
                                    <div>
                                        <VCardTitle>
                                            {{
                                                lang.WHEN_CAN_PEOPLE_BOOK_EVENT
                                            }}
                                        </VCardTitle>
                                        <VCardSubtitle>
                                            {{ duration }}, {{ dateDuration }}
                                        </VCardSubtitle>
                                    </div>
                                </VCol>
                            </VRow>
                        </VExpansionPanelHeader>
                        <VExpansionPanelContent>
                            <VDivider class="mx-4"></VDivider>
                            <VRow>
                                <VCol
                                    cols="10"
                                    offset-sm="2"
                                    offset-md="2"
                                    md="7"
                                    sm="6"
                                    lg="7"
                                    :class="{ 'ml-10': $vuetify.breakpoint.xs }"
                                >
                                    <CreateEventTypeBookingForm></CreateEventTypeBookingForm>
                                </VCol>
                            </VRow>
                        </VExpansionPanelContent>
                    </VExpansionPanel>
                    <div class="mt-7 mb-5">
                        <p>
                            <b>{{ lang.NOW_YOU_CAN_ADD_CUSTOM_FIELDS }}</b>
                        </p>
                    </div>
                    <VExpansionPanel @change="panel = 2">
                        <VExpansionPanelHeader>
                            <VRow align="center">
                                <VCol cols="2" md="1" sm="1" lg="1">
                                    <div>
                                        <img
                                            :src="
                                                require('@/assets/images/custom_fields.svg')
                                            "
                                            alt
                                            :class="{
                                                'pl-3': $vuetify.breakpoint.xs,
                                                'pl-10':
                                                    $vuetify.breakpoint.smAndUp
                                            }"
                                        />
                                    </div>
                                </VCol>
                                <VCol cols="10" class="pl-lg-5 pl-sm-10">
                                    <div>
                                        <VCardTitle>
                                            {{ lang.ADDITIONAL_OPTIONS }}
                                        </VCardTitle>
                                        <VCardSubtitle>
                                            {{ lang.QUESTIONS_TO_INVITEE }}
                                        </VCardSubtitle>
                                    </div>
                                </VCol>
                            </VRow>
                        </VExpansionPanelHeader>
                        <VExpansionPanelContent>
                            <VDivider class="mx-4"></VDivider>
                            <VRow>
                                <VCol
                                    cols="10"
                                    offset-sm="2"
                                    offset-md="2"
                                    md="7"
                                    sm="6"
                                    lg="7"
                                    :class="{ 'ml-10': $vuetify.breakpoint.xs }"
                                >
                                    <CreateEventTypeQuestions />
                                </VCol>
                            </VRow>
                        </VExpansionPanelContent>
                    </VExpansionPanel>
                </VExpansionPanels>
            </VCard>
        </VContainer>
        <template v-slot:title>
            <NewEventTypeTitle />
        </template>
    </GeneralLayout>
</template>

<script>
import GeneralLayout from '@/components/common/GeneralLayout/GeneralLayout';
import NewEventTypeTitle from '@/components/events/NewEventTypeTitle';
import CreateEventTypeBookingForm from '@/components/events/CreateEventTypeBookingForm';
import FirstTitle from '@/components/events/CreateEventTypeTitle';
import CreateEventTypeForm from '@/components/events/CreateEventTypeForm';
import eventTypeMixin from '@/components/events/eventTypeMixin';
import CreateEventTypeQuestions from '@/components/events/custom-fields/CreateEventTypeQuestions';
import { mapActions } from 'vuex';
import * as actionEventType from '@/store/modules/eventType/types/actions';
export default {
    name: 'NewEventTypeAdditionalOptions',
    mixins: [eventTypeMixin],
    components: {
        GeneralLayout,
        NewEventTypeTitle,
        CreateEventTypeBookingForm,
        FirstTitle,
        CreateEventTypeForm,
        CreateEventTypeQuestions
    },
    computed: {
        duration() {
            return (
                (this.eventType.customDuration || this.eventType.duration) +
                ' ' +
                this.lang.DURATION_MIN
            );
        }
    },
    methods: {
        ...mapActions('eventType', {
            getEventTypeById: actionEventType.GET_EVENT_TYPE_BY_ID
        }),
        fetchEventType() {
            this.getEventTypeById(this.$route.params.id);
        }
    },
    mounted() {
        this.fetchEventType();
    }
};
</script>

<style scoped></style>
