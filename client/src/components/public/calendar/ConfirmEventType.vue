<template>
    <VRow class="pa-0 ma-0">
        <VCol class="event-datail col-12 col-sm-12 col-md-4">
            <DetailLayout
                :companyLogo="owner.companyLogo"
                :avatar="owner.avatar"
                :name="owner.name"
                :company="owner.company"
                :specialty="owner.specialty"
            >
                <div class="event-info">
                    <VIcon dark color="primary">mdi-clock-outline</VIcon>
                    {{ meetingData.duration }} {{ lang.DURATION_MIN }}
                </div>
                <div class="event-info">
                    <VIcon dark color="primary">mdi-map-marker</VIcon>
                    {{ meetingData.location }}
                </div>
                <div class="event-info">
                    <VIcon dark color="primary">mdi-calendar-blank</VIcon>
                    {{ meetingData.fulldate }}
                </div>
                <div class="event-info">
                    <VIcon dark color="primary">mdi-earth</VIcon>
                    {{ meetingData.timezone }}
                </div>
            </DetailLayout>
        </VCol>

        <VDivider vertical></VDivider>

        <VCol class="event-confirm-field col-12 col-sm-9 col-md-7">
            <h3>{{ lang.ENTER_DETAILS }}</h3>

            <VForm v-model="formValid" ref="form">
                <VCardText class="pa-0">
                    <VCol cols="12" sm="12" md="10" class="pa-0">
                        <label for="full-name"> {{ lang.FULL_NAME }}* </label>
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
import DetailLayout from './DetailLayout';

export default {
    name: 'ConfirmEventType',
    components: {
        DetailLayout
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
            fullDate: '10:00-10:30, Monday, July 20, 2020',
            duration: 30,
            location: 'Scranton, Pennsylvania',
            timezone: 'Eastern European Time'
        },
        owner: {
            name: 'Michael Scott',
            avatar:
                'https://avatars0.githubusercontent.com/u/9064066?v=4&s=460',
            company: 'Dunder Mifflin',
            companyLogo:
                'https://i.etsystatic.com/16438614/r/il/c31bd2/1806659071/il_570xN.1806659071_pn8j.jpg',
            specialty: 'Sales manager'
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

.event-info {
    display: flex;
    padding: 6px 0 6px 0;
    margin-top: 20px;
}

.event-info ~ .event-info {
    margin-top: 0px;
}

.event-info i {
    margin-right: 10px;
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
