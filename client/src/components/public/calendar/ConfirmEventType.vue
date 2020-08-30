<template>
    <VRow class="pa-0 ma-0" v-if="publicEvent.startDate">
        <VCol class="event-datail col-12 col-sm-12 col-md-4">
            <EventInfo
                :brandingLogo="eventType.owner.brandingLogo"
                :avatar="eventType.owner.avatar"
                :name="eventType.owner.name"
                :eventName="eventType.name"
                :duration="eventType.duration"
                :location="'Vyacheslav Chornovol Avenue, 59, Lviv'"
                :description="eventType.description"
                :startDate="startDateFormatted"
                :timezone="publicEvent.timezone"
                :lang="lang"
            />
        </VCol>

        <VDivider vertical></VDivider>

        <VCol class="event-confirm-field col-12 col-sm-9 col-md-7">
            <h3 class="mb-3">{{ lang.ENTER_DETAILS }} {{ eventType.id }}</h3>

            <VForm v-model="formValid" ref="form">
                <VCardText class="pa-0">
                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="full-name">{{ lang.NAME }}*</label>
                        <VTextField
                            id="name"
                            :error-messages="nameErrors"
                            :placeholder="lang.NAME"
                            :value="meetingFormData.name"
                            @blur="setPropertyInMeetingFormData"
                            @input="setNameOnInput"
                            outlined
                            dense
                            type="text"
                        ></VTextField>
                    </VCol>
                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="email">{{ lang.EMAIL }}*</label>
                        <VTextField
                            id="email"
                            :error-messages="emailErrors"
                            :value="meetingFormData.email"
                            @blur="setPropertyInMeetingFormData"
                            @input="setEmailOnInput"
                            placeholder="user@gmail.com"
                            outlined
                            dense
                        ></VTextField>
                    </VCol>

                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="additional-info">{{
                            lang.ADDITIONAL_INFO_DESCRIPTION
                        }}</label>
                        <VTextarea
                            id="additional-info"
                            :error-messages="additionalInfoErrors"
                            :value="meetingFormData.additionalInfo"
                            @blur="setPropertyInMeetingFormData"
                            @input="setAdditionalInfoOnInput"
                            :placeholder="lang.ADDITIONAL_INFO"
                            outlined
                            no-resize
                            dense
                            type="text"
                            height="100"
                        ></VTextarea>
                    </VCol>
                    <VCol cols="12" sm="12" md="10" class="pa-0" v-for="(field, id) in fields" :key="id">
                        <span class="subtitle-2">{{ field.name }}</span>
                        <VTextField
                            v-if="field.type === 'line'"
                            outlined
                            dense
                            @input="onInputCustomFields"
                            @click="setInputCustomFields(id)"
                        ></VTextField>
                        <VTextarea
                            v-if="field.type === 'multiline'"
                            outlined
                            no-resize
                            dense
                            type="text"
                            height="100"
                            @input="onInputCustomFields"
                            @click="setInputCustomFields(id)"
                        ></VTextarea>
                    </VCol>
                </VCardText>
                <VCardActions class="pa-0">
                    <VCol cols="12" sm="12" md="9" class="pa-0">
                        <VRow align="center" justify="space-between">
                            <VCol>
                                <VBtn
                                    width="158"
                                    height="44"
                                    class="login-button primary text-capitalize"
                                    depressed
                                    @click="onScheduleEvent"
                                    >{{ lang.SCHEDULE_EVENT }}</VBtn
                                >
                            </VCol>
                        </VRow>
                    </VCol>
                </VCardActions>
            </VForm>
        </VCol>
    </VRow>
</template>

<script>
import moment from 'moment';
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import * as getters from '@/store/modules/publicEvent/types/getters';
import { mapActions, mapGetters } from 'vuex';
import * as notificationActions from '@/store/modules/notification/types/actions';
import * as actions from '@/store/modules/publicEvent/types/actions';
import { validationMixin } from 'vuelidate';
import * as eventTypesGetters from '@/store/modules/eventTypes/types/getters';
import * as eventTypesActions from '@/store/modules/eventTypes/types/actions';
import {
    required,
    email,
    minLength,
    maxLength,
    helpers
} from 'vuelidate/lib/validators';

const nameRequirements = helpers.regex(
    'symbols',
    /^[a-zA-Zа-яА-ЯЇїІіЄєҐґ /|,._\\]{2,50}$/
);
const infoRequirements = helpers.regex(
    'symbols',
    /^[a-zA-Zа-яА-ЯЇїІіЄєҐґ /|,._\\]{0,1000}$/
);

import EventInfo from './EventInfo';

export default {
    name: 'ConfirmEventType',
    mixins: [validationMixin],
    components: {
        EventInfo
    },
    validations: {
        meetingFormData: {
            name: {
                required,
                minLength: minLength(2),
                maxLength: maxLength(50),
                nameRequirements
            },
            email: { required, email },
            additionalInfo: {
                maxLength: maxLength(1000),
                infoRequirements
            }
        }
    },
    data: () => ({
        isReady: false,
        formValid: false,
        showPassword: false,
        meetingFormData: {
            name: '',
            email: '',
            additionalInfo: ''
        },
        customFieldValues: {},
        customFieldId: ''
    }),
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('publicEvent', {
            eventType: getters.GET_EVENT_TYPE,
            publicEvent: getters.GET_PUBLIC_EVENT
        }),
        ...mapGetters('eventTypes', {
            fields: eventTypesGetters.GET_CUSTOM_FIELDS
        }),
        startDateFormatted() {
            return moment(this.publicEvent.startDate).format(
                'dddd, YYYY-MM-DD, HH:mm'
            );
        },
        nameErrors() {
            const errors = [];
            if (!this.$v.meetingFormData.name.$dirty) {
                return errors;
            }
            !this.$v.meetingFormData.name.required &&
                errors.push(this.lang.NAME_IS_REQUIRED);
            !this.$v.meetingFormData.name.minLength &&
                errors.push(this.lang.NAME_MUST_BE_AT_LEAST_2_CHARACTERS_LONG);
            !this.$v.meetingFormData.name.maxLength &&
                errors.push(
                    this.lang.NAME_MUST_BE_NO_MORE_THAN_50_CHARACTERS_LONG
                );
            !this.$v.meetingFormData.name.nameRequirements &&
                errors.push(this.lang.ONLY_LETTER_AND_SYMBOLS_PERMITTED);
            return errors;
        },
        emailErrors() {
            const errors = [];
            if (!this.$v.meetingFormData.email.$dirty) {
                return errors;
            }
            !this.$v.meetingFormData.email.email &&
                errors.push(this.lang.MUST_BE_VALID_EMAIL);
            !this.$v.meetingFormData.email.required &&
                errors.push(this.lang.EMAIL_IS_REQUIRED);
            return errors;
        },
        additionalInfoErrors() {
            const errors = [];
            if (!this.$v.meetingFormData.additionalInfo.$dirty) {
                return errors;
            }
            !this.$v.meetingFormData.additionalInfo.maxLength &&
                errors.push(
                    this.lang.INFO_MUST_BE_NO_MORE_THAN_1000_CHARACTERS_LONG
                );
            !this.$v.meetingFormData.additionalInfo.infoRequirements &&
                errors.push(this.lang.ONLY_LETTER_AND_SYMBOLS_PERMITTED);
            return errors;
        }
    },
    methods: {
        ...mapActions('notification', {
            setErrorNotification: notificationActions.SET_ERROR_NOTIFICATION
        }),
        ...mapActions('publicEvent', {
            addPublicEvent: actions.ADD_PUBLIC_EVENT
        }),
        ...mapActions('eventTypes', {
            fetchCustomFields: eventTypesActions.FETCH_CUSTOM_FIELDS_BY_EVENT_ID
        }),
        setInputCustomFields(id) {
            this.customFieldId = id;
        },
        onInputCustomFields() {
            this.customFieldValues[this.customFieldId] = {
                value: event.target.value,
                custom_field_id: this.customFieldId
            };
        },
        async onScheduleEvent() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                try {
                    const customFieldValues = Object.values(this.customFieldValues).filter(field => {
                        return field.value;
                    });
                    await this.addPublicEvent({
                        event_type_id: this.eventType.id,
                        invitee_name: this.meetingFormData.name,
                        invitee_email: this.meetingFormData.email,
                        start_date: this.publicEvent.startDate,
                        timezone: this.publicEvent.timezone,
                        custom_field_values: customFieldValues
                    });

                    this.$router.push({
                        path: `/${this.eventType.owner.nickname}/${this.eventType.id}/invitee/details`
                    });
                } catch (error) {
                    this.setErrorNotification(error);
                }
            } else {
                this.setErrorNotification(this.lang.PLEASE_ENTER_CORRECT_DATA);
            }
        },
        setPropertyInMeetingFormData(e) {
            this.meetingFormData[e.target.id] = e.target.value;
            this.$v.meetingFormData[e.target.id].$touch();
        },
        setEmailOnInput(value) {
            this.meetingFormData.email = value;
            this.$v.meetingFormData.email.$touch();
        },
        setNameOnInput(value) {
            this.meetingFormData.name = value;
            this.$v.meetingFormData.name.$touch();
        },
        setAdditionalInfoOnInput(value) {
            this.meetingFormData.additionalInfo = value;
            this.$v.meetingFormData.additionalInfo.$touch();
        }
    },
    async mounted() {
        await this.fetchCustomFields(this.eventType.id);
    }
};
</script>

<style scoped>
.event-datail {
    min-width: 250px;
    margin: 0;
    padding: 0;
}

.event-confirm-field {
    min-width: 300px;
    margin: 0;
    padding: 50px;
}

label {
    font-style: normal;
    font-weight: 500;
    font-size: small;
    color: #2c2c2c;
    display: block;
}

@media screen and (max-width: 960px) {
    .event-confirm-field {
        min-width: 290px;
        padding: 30px;
    }
    .event-datail {
        min-width: 290px;
        border-right: none;
    }
}
</style>
