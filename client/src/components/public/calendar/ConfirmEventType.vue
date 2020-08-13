<template>
    <div class="main">
        <div class="event-type-container">
            <VRow>
                <VCol sm="12" md="4" class="event-datail col-12">
                    <DatailLayout>
                        <div class="event-info">
                            <VIcon dark color="primary"
                                >mdi-clock-outline</VIcon
                            >
                            15 {{ lang.ET_MIN }}
                        </div>
                        <div class="event-info">
                            <VIcon dark color="primary">mdi-map-marker</VIcon>
                            {{ meetingLocation }}
                        </div>
                        <div class="event-info">
                            <VIcon dark color="primary"
                                >mdi-calendar-blank</VIcon
                            >
                            {{ meetingDate }}
                        </div>
                        <div class="event-info">
                            <VIcon dark color="primary">mdi-earth</VIcon>
                            {{ timezone }}
                        </div>
                    </DatailLayout>
                </VCol>
                <VCol sm="7" class="event-confirm-field col-12">
                    <h3>{{ lang.ENTER_DETAILS }}</h3>

                    <VForm v-model="formValid" ref="form">
                        <VCardText class="pa-0">
                            <VCol cols="12" sm="12" md="10" class="pa-0">
                                <label for="full-name">{{
                                    lang.FULL_NAME
                                }}</label>
                                <VTextField
                                    id="full-name"
                                    :placeholder="lang.NAME"
                                    outlined
                                    dense
                                    type="text"
                                    v-model="meetingData.name"
                                    :rules="nameRules"
                                ></VTextField>
                            </VCol>
                            <VCol cols="12" sm="12" md="10" class="pa-0">
                                <label for="email">{{ lang.EMAIL }}</label>
                                <VTextField
                                    id="email"
                                    placeholder="user@gmail.com"
                                    outlined
                                    dense
                                    type="email"
                                    v-model="meetingData.email"
                                    :rules="emailRules"
                                ></VTextField>
                            </VCol>

                            <VCol cols="12" sm="12" md="10" class="pa-0">
                                <label for="additional-info">
                                    {{ lang.ADDITIONAL_INFO_DESCRIPTION }}
                                </label>
                                <VTextarea
                                    id="additional-info"
                                    :placeholder="lang.ADDITIONAL_INFO"
                                    outlined
                                    dense
                                    type="text"
                                    height="100"
                                    v-model="meetingData.additionalInfo"
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
        </div>
    </div>
</template>

<script>
import enLang from '@/store/modules/i18n/en';
import DatailLayout from './DatailLayout';

export default {
    name: 'ConfirmEventType',
    components: {
        DatailLayout
    },
    data: () => ({
        lang: enLang,
        formValid: false,
        showPassword: false,
        meetingData: {
            name: '',
            email: '',
            additionalInfo: ''
        },
        owner: {
            name: 'Michael Scott',
            avatar:
                'https://avatars0.githubusercontent.com/u/9064066?v=4&s=460',
            company: 'Dunder Mifflin',
            specialty: 'Sales manager'
        },
        meetingDate: '10:00-10:15, Monday, July 20, 2020',
        timezone: 'Eastern European Time',
        meetingLocation: 'Scranton, Pennsylvania',
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

<style>
.main {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
}

.event-type-container {
    margin-top: 50px;
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
    background-color: #fff;
    width: 70%;
    height: 70%;
    max-width: 1000px;
    max-height: 900px;
}

.event-type-container > div {
    margin: 0;
    padding: 0;
}

.event-datail {
    min-width: 250px;
    margin: 0;
    padding: 0;
    border-right: 2px solid rgb(243, 247, 247);
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

.title-of-card {
    color: var(--v-primary-base);
    font-weight: 900;
    font-size: 34px;
    line-height: 44px;
    letter-spacing: -0.44px;
}
.info-text-in-title {
    font-style: normal;
    font-weight: 500;
    font-size: small;
    line-height: 16px;
}
a {
    text-decoration: none;
}
label {
    font-style: normal;
    font-weight: 500;
    font-size: small;
    color: #2c2c2c;
    display: block;
}
.forgot-password-a {
    font-size: x-small;
    letter-spacing: 0.4px;
    color: var(--v-primary-base);
}
.login-button {
    text-transform: none;
}
.social-button {
    font-weight: 700;
    font-size: xx-large;
    margin-left: 4px;
    margin-right: 0;
    color: var(--v-primary-base);
    text-transform: none;
}

@media screen and (max-width: 960px) {
    .confirm-container {
        width: 90%;
        height: 80%;
    }
    .event-confirm-field {
        min-width: 290px;
    }
    .event-datail {
        min-width: 290px;
        border-right: none;
    }
}

@media (max-width: 600px) {
    .event-type-container {
        width: 100%;
        box-shadow: none;
    }
}
</style>
