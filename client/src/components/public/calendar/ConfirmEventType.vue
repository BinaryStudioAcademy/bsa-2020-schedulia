<template>
    <VRow class="pa-0 ma-0" v-if="publicEvent.startDate">
        <VCol class="event-datail col-12 col-sm-12 col-md-4">
            <EventInfo
                :brandingLogo="eventType.owner.brandingLogo"
                :avatar="eventType.owner.avatar"
                :name="eventType.owner.name"
                :eventName="eventType.name"
                :duration="eventType.duration"
                :location="eventType.location"
                :description="eventType.description"
                :startDate="publicEvent.startDate"
                :timezone="publicEvent.timezone"
                :lang="lang"
            />
        </VCol>

        <VDivider vertical></VDivider>

        <VCol class="event-confirm-field col-12 col-sm-9 col-md-7">
            <h3 class="mb-3">{{ lang.ENTER_DETAILS }}</h3>

            <VForm v-model="formValid" ref="form">
                <VCardText class="pa-0">
                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="full-name">{{ lang.NAME }}*</label>
                        <VTextField
                            id="full-name"
                            :placeholder="lang.NAME"
                            outlined
                            dense
                            type="text"
                            v-model="meetingFormData.name"
                            :rules="nameRules"
                        ></VTextField>
                    </VCol>
                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="email">{{ lang.EMAIL }}*</label>
                        <VTextField
                            id="email"
                            placeholder="user@gmail.com"
                            outlined
                            dense
                            type="email"
                            v-model="meetingFormData.email"
                            :rules="emailRules"
                        ></VTextField>
                    </VCol>

                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="additional-info">{{
                            lang.ADDITIONAL_INFO_DESCRIPTION
                        }}</label>
                        <VTextarea
                            id="additional-info"
                            :placeholder="lang.ADDITIONAL_INFO"
                            outlined
                            no-resize
                            dense
                            type="text"
                            height="100"
                            v-model="meetingFormData.additionalInfo"
                            :rules="additionalInfoRules"
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
import enLang from '@/store/modules/i18n/en';
import * as getters from '@/store/modules/publicEvent/types/getters';
import { mapGetters } from 'vuex';
import EventInfo from './EventInfo';

export default {
    name: 'ConfirmEventType',
    components: {
        EventInfo
    },
    data: () => ({
        lang: enLang,
        isReady: false,
        formValid: false,
        showPassword: false,
        meetingFormData: {
            name: '',
            email: '',
            additionalInfo: ''
        },
        emailRules: [
            v => !!v || enLang.FIELD_IS_REQUIRED.replace('field', enLang.EMAIL),
            v =>
                /([a-zA-Z0-9_.-]+)@(.+)[.](.+)/.test(v) ||
                enLang.WRONG_EMAIL_FORMAT,
            v =>
                (!!v &&
                    !!v.includes('@') &&
                    v.split('@')[0].length >= 1 &&
                    v.split('@')[0].length <= 35) ||
                enLang.WRONG_EMAIL_FORMAT,
            v =>
                (!!v &&
                    !!v.includes('@') &&
                    v.split('@')[1].length >= 3 &&
                    v.split('@')[1].length <= 12) ||
                enLang.WRONG_EMAIL_FORMAT
        ],
        nameRules: [
            v => !!v || enLang.FIELD_IS_REQUIRED.replace('field', enLang.NAME),
            v =>
                v.length >= 2 ||
                enLang.NAME +
                    enLang.FIELD_MUST_BE_MORE_THAN_VALUE.replace('value', 2),
            v =>
                v.length <= 50 ||
                enLang.NAME +
                    enLang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 50)
        ],
        additionalInfoRules: [
            v =>
                v.length <= 200 ||
                enLang.ADDITIONAL_INFO +
                    enLang.FIELD_MUST_BE_LESS_THAN_VALUE.replace('value', 200)
        ],
        alert: {
            visible: false,
            message: '',
            type: ''
        }
    }),
    computed: {
        ...mapGetters('publicEvent', {
            eventType: getters.GET_EVENT_TYPE,
            publicEvent: getters.GET_PUBLIC_EVENT
        })
    },
    methods: {
        onScheduleEvent() {
            this.$refs.form.validate();
            if (this.formValid) {
                this.$router.push({ name: 'PublicEventDetails' });
            }
        }
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
