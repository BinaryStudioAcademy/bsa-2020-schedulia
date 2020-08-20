<template>
    <VRow class="pa-0 ma-0">
        <VCol class="event-datail col-12 col-sm-12 col-md-4">
            <EventInfo
                :companyLogo="owner.companyLogo"
                :avatar="owner.avatar"
                :name="owner.name"
                :eventName="meetingData.name"
                :duration="meetingData.duration"
                :location="meetingData.location"
                :description="meetingData.description"
                :fullDate="meetingData.fullDate"
                :timezone="meetingData.timezone"
                :lang="lang"
            />
        </VCol>

        <VDivider vertical></VDivider>

        <VCol class="event-confirm-field col-12 col-sm-9 col-md-7">
            <h3 class="mb-3">{{ lang.ENTER_DETAILS }}</h3>

            <VForm v-model="formValid" ref="form">
                <VCardText class="pa-0">
                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="full-name">{{ lang.FULL_NAME }}*</label>
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
                                    class="login-button primary"
                                    depressed
                                    :to="{ path: 'event-details' }"
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
import EventInfo from './EventInfo';

export default {
    name: 'ConfirmEventType',
    components: {
        EventInfo
    },
    data: () => ({
        lang: enLang,
        formValid: false,
        showPassword: false,
        meetingFormData: {
            name: '',
            email: '',
            additionalInfo: ''
        },
        meetingData: {
            name: 'Sales manager',
            fullDate: '10:00-10:30, Monday, July 20, 2020',
            description: '',
            duration: 30,
            location: 'Scranton, Pennsylvania',
            timezone: 'Eastern European Time'
        },
        owner: {
            name: 'Michael Scott | Dunder Mifflin',
            avatar:
                'https://avatars0.githubusercontent.com/u/9064066?v=4&s=460',
            companyLogo:
                'https://i.etsystatic.com/16438614/r/il/c31bd2/1806659071/il_570xN.1806659071_pn8j.jpg'
        },
        emailRules: [
            v => !!v || enLang.FIELD_IS_REQUIRED.replace('field', enLang.EMAIL),
            v =>
                /([a-zA-Z0-9_.-]+)@(.+)[.](.+)/.test(v) ||
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
                enLang.EMAIL +
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
    })
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
    }
    .event-datail {
        min-width: 290px;
        border-right: none;
    }
}
</style>
