<template>
    <VDialog :value="visible" max-width="380" persistent>
        <VCard>
            <VRow justify="center">
                <VCol cols="9">
                    <VRow justify="center">
                        <VCardTitle class="headline">
                            {{ lang.TIME_ZONE_STYLE }}
                        </VCardTitle>
                        <VRadioGroup
                            dense
                            row
                            :value="radioTimeZone"
                            @change="changeRadioTimeZone"
                            class="mr-5 app-text"
                        >
                            <VCol cols="6">
                                <VRadio
                                    :label="lang.LOCAL"
                                    value="Local"
                                ></VRadio>
                            </VCol>
                            <VCol cols="6">
                                <VRadio
                                    :label="lang.LOCKED"
                                    value="Locked"
                                ></VRadio>
                            </VCol>
                        </VRadioGroup>

                        <VCardText
                            v-show="radioTimeZone === 'Local'"
                            class="px-0 pb-0"
                        >
                            <p>{{ lang.INVITEES_VIRTUAL_MEETINGS }}</p>
                            <p class="mt-5">
                                {{ lang.INVITEES_VIRTUAL_MEETINGS_CONFIGURED }}
                            </p>
                        </VCardText>

                        <div v-show="radioTimeZone === 'Locked'">
                            <VCardText class="px-0 pb-0">
                                <p>{{ lang.INVITEES_IN_PERSON_MEETINGS }}</p>
                            </VCardText>
                            <VCol cols="12" class="px-0 py-0">
                                <VSelect
                                    :items="timeZones"
                                    @change="changeTimezone"
                                    :value="timezone"
                                    outlined
                                    placeholder="Option"
                                    dense
                                    class="app-select"
                                >
                                </VSelect>
                            </VCol>
                        </div>
                    </VRow>
                </VCol>
            </VRow>

            <VCardActions>
                <VSpacer></VSpacer>
                <VBtn color="primary" text @click="apply">
                    {{ lang.APPLY }}
                </VBtn>
                <VBtn color="primary" text @click="cancel">
                    {{ lang.CANCEL }}
                </VBtn>
            </VCardActions>
        </VCard>
    </VDialog>
</template>

<script>
import eventTypeMixin from '@/components/events/eventTypeMixin';
import { mapGetters } from 'vuex';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import momentTimezone from 'moment-timezone';
import moment from 'moment';
export default {
    name: 'TimeZoneDialog',

    mixins: [eventTypeMixin],

    data() {
        return {
            timeZones: momentTimezone.tz.names(),
            form: {
                timezone: '',
                radioTimeZone: ''
            }
        };
    },

    methods: {
        cancel() {
            this.setPropertyData('visibleTimeZoneDialog', false);
            this.form.timezone = null;
            this.form.radioTimeZone = 'Local';
        },
        apply() {
            this.changeEventTypeProperty('timezone', this.timezone);
            this.setPropertyData('visibleTimeZoneDialog', false);
        },
        changeTimezone(data) {
            this.form.timezone = data;
        },
        changeRadioTimeZone(data) {
            this.form.radioTimeZone = data;
            if (data === 'Local') {
                this.form.timezone = moment.tz.guess();
            }
        }
    },

    computed: {
        ...mapGetters('eventType', {
            visibleTimeZoneDialog: eventTypeGetters.GET_VISIBLE_TIME_ZONE_DIALOG
        }),
        visible() {
            return this.visibleTimeZoneDialog;
        },
        radioTimeZone() {
            return this.form.radioTimeZone || this.data.radioTimeZone;
        },
        timezone() {
            return this.form.timezone || this.data.timezone;
        }
    }
};
</script>
<style scoped>
/deep/ .v-dialog {
    overflow-x: hidden;
}
</style>
