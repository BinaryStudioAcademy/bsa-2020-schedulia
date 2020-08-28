<template>
    <VForm class="mt-9 mb-16" ref="form">
        <VRow>
            <h3 class="app-label">{{ lang.EVENT_DURATION }}*</h3>
        </VRow>
        <VRow align="baseline" class="mb-3">
            <VRadioGroup
                dense
                row
                :value="data.duration"
                @change="changeEventTypeProperty('duration', $event)"
                class="mr-5 app-text"
            >
                <VRadio
                    v-for="n in eventDuration"
                    :key="n.id"
                    :label="`${n.label}`"
                    :value="n.value"
                    class="mr-6"
                    :rules="rules"
                >
                </VRadio>
            </VRadioGroup>
            <p class="mr-3 app-text">
                {{ lang.CUSTOM_DURATION }}
            </p>
            <VTextField
                :value="data.customDuration"
                @change="changeEventTypeProperty('customDuration', $event)"
                outlined
                dense
                class="shrink ma-0 pa-0 custom-textfield"
                placeholder="0"
            >
            </VTextField>
        </VRow>
        <VRow class="mb-2">
            <h3 class="app-label">
                {{ lang.DATE_RANGE }}
            </h3>
        </VRow>
        <VRow class="mb-3" align="baseline">
            <p
                class="app-text"
                :class="{
                    'mb-0': $vuetify.breakpoint.xs,
                    'mb-3': $vuetify.breakpoint.smAndUp
                }"
            >
                {{ lang.EVENTS_CAN_BE_SCHEDULED }}
                {{ dateDuration }}
            </p>
            <VBtn
                text
                color="primary"
                dark
                @click.stop="setPropertyData('visibleAvailabilityDialog', true)"
            >
                {{ lang.EDIT }}
            </VBtn>
            <AvailabilityDialog></AvailabilityDialog>
        </VRow>
        <VRow class="mb-2">
            <h3 class="app-label">
                {{ lang.EVENT_TIME_ZONE }}
            </h3>
        </VRow>
        <VRow>
            <p class="app-text">
                {{ lang.EVENT_TIME_ZONE_EXPLANATION }}
                <VBtn
                    text
                    small
                    color="primary"
                    dark
                    @click.stop="setPropertyData('visibleTimeZoneDialog', true)"
                    class="editTimeZoneButton ma-n2 pa-n3"
                >
                    {{ lang.EDIT }}
                </VBtn>
                <TimeZoneDialog></TimeZoneDialog>
            </p>
        </VRow>
        <VRow class="mb-5">
            <VSheet class="recommendation-block">
                <p>{{ lang.LOCK_MEETING_TIME_RECOMMENDATION }}</p>
            </VSheet>
        </VRow>
        <VRow class="mb-2">
            <h3 class="app-label">
                {{ lang.AVAILABILITY }}
            </h3>
        </VRow>
        <VRow>
            <p class="app-text">
                {{ lang.SET_AVAILABLE_HOURS_TEXT }}
            </p>
        </VRow>

        <VRow>
            <VTabs v-model="tab">
                <VTabsSlider></VTabsSlider>
                <VTab :href="'#tab-0'">
                    <span class="custom-text">
                        {{ lang.HOURS }}
                    </span>
                </VTab>
                <VTabItem :value="'tab-0'">
                    <Calendar></Calendar>
                </VTabItem>
                <VTab :href="'#tab-1'">{{ lang.ADVANCED }}</VTab>
                <VTabItem :value="'tab-1'">
                    <VRow class="pt-3">
                        <VCol cols="5">
                            <p class="availability-label">
                                {{ lang.AVAILABILITY_INCREMENTS }}
                            </p>
                            <p>{{ lang.SET_THE_FREQUENCY_TIME_SLOTS_TEXT }}</p>
                        </VCol>
                        <VCol cols="5">
                            <p>{{ lang.SHOW_AVAILABILITY_IN_INCREMENTS_OF }}</p>
                            <VSelect
                                v-model="availabilityIncrementsSelected"
                                :items="availabilityIncrementsItems"
                                outlined
                                placeholder="Option"
                                dense
                                class="app-select"
                            >
                            </VSelect>
                        </VCol>
                    </VRow>
                    <VRow>
                        <VCol cols="5">
                            <p class="availability-label">
                                {{ lang.EVENT_MAX_PER_DAY }}
                            </p>
                            <p>{{ lang.LIMIT_THE_NUMBER_OF_EVENTS_TEXT }}</p>
                        </VCol>
                        <VCol cols="5">
                            <p>{{ lang.MAX_NUMBER_OF_EVENTS_PER_DAY }}</p>
                            <VTextField
                                v-model="maxEventsPerDay"
                                outlined
                                dense
                                class="shrink custom-textfield"
                                placeholder="0"
                            >
                            </VTextField>
                        </VCol>
                    </VRow>
                    <VRow>
                        <VCol cols="5">
                            <p class="availability-label">
                                {{ lang.MINIMUM_SCHEDULING_NOTICE }}
                            </p>
                            <p>
                                {{ lang.PREVENT_LAST_MINUTE_EVENTS_TEXT }}
                            </p>
                        </VCol>
                        <VCol cols="5">
                            <p>
                                {{ lang.PREVENT_EVENTS_LESS_THAN }}
                            </p>
                            <VRow align="baseline">
                                <VCol>
                                    <VTextField
                                        v-model="preventEventsHours"
                                        outlined
                                        dense
                                        class="shrink custom-textfield"
                                        placeholder="0"
                                    >
                                    </VTextField>
                                </VCol>
                                <VCol>
                                    <span>
                                        {{ lang.HOURS_AWAY }}
                                    </span>
                                </VCol>
                            </VRow>
                        </VCol>
                    </VRow>
                </VTabItem>
            </VTabs>
        </VRow>

        <VRow class="mt-10">
            <div>
                <VBtn text outlined width="114" class="mr-3">
                    {{ lang.CANCEL }}
                </VBtn>
                <VBtn
                    @click="saveEventType"
                    color="primary"
                    class="white--text"
                    width="114"
                >
                    {{ lang.SAVE_AND_CLOSE }}
                </VBtn>
            </div>
        </VRow>
    </VForm>
</template>

<script>
import { mapActions } from 'vuex';
import * as eventTypeActions from '@/store/modules/eventType/types/actions';
import eventTypeMixin from '@/components/events/eventTypeMixin';
import AvailabilityDialog from '@/components/events/AvailabilityDialog';
import TimeZoneDialog from '@/components/events/TimeZoneDialog';
import moment from 'moment';
import Calendar from '@/components/events/Calendar';
export default {
    name: 'CreateEventTypeBooking',
    components: { Calendar, TimeZoneDialog, AvailabilityDialog },
    mixins: [eventTypeMixin],
    data() {
        return {
            availabilityIncrementsSelected: '',
            maxEventsPerDay: '',
            preventEventsHours: '',
            tab: null
        };
    },

    computed: {
        rules() {
            return [
                this.data.duration > 0 ||
                    this.data.customDuration > 0 ||
                    'At least one item should be selected'
            ];
        },
        availabilityIncrementsItems() {
            return [
                this.lang.FIVE_MIN,
                this.lang.TEN_MIN,
                this.lang.FIFTEEN_MIN,
                this.lang.TWENTY_MIN,
                this.lang.TWENTY_FIVE_MIN,
                this.lang.THIRTY_MIN
            ];
        },
        eventDuration() {
            return [
                { id: 1, value: 15, label: this.lang.FIFTEEN_MIN },
                { id: 2, value: 30, label: this.lang.THIRTY_MIN },
                { id: 3, value: 45, label: this.lang.FORTY_FIVE_MIN },
                { id: 4, value: 60, label: this.lang.SIXTY_MIN }
            ];
        }
    },

    methods: {
        ...mapActions('eventType', {
            addEventType: eventTypeActions.ADD_EVENT_TYPE
        }),
        async saveEventType() {
            try {
                if (this.$refs.form.validate()) {
                    this.prepareData();
                    await this.addEventType(this.data);
                    this.$router.push({ name: 'EventTypes' });
                }
            } catch (error) {
                this.showErrorMessage(error.message);
            }
        },
        prepareData() {
            let dateRangeData = {
                ...this.data.dateRange,
                ...{
                    startDate: this.data.dateRange.startDate + ' 00:00:00',
                    endDate: this.data.dateRange.endDate + ' 00:00:00'
                }
            };
            this.changeEventTypeProperty('availabilities', {
                ...{ dateRange: [dateRangeData]},
                ...this.data.availabilities
            });
        }
    },

    mounted() {
        if (!this.data.timezone) {
            this.changeEventTypeProperty('timezone', moment.tz.guess());
        }
    }
};
</script>

<style scoped>
.recommendation-block {
    background-color: var(--v-lightGrey-base);
    padding-left: 20px;
    padding-top: 17px;
    width: 688px;
    height: 72px;
}

.recommendation-block p {
    font-size: 11px;
}

.app-text {
    font-size: 14px;
}

.app-text >>> label {
    font-size: 14px;
}

.app-label {
    font-size: 16px;
}

.availability-label {
    font-size: 12px;
    font-weight: bold;
}

.editTimeZoneButton {
    font-size: 12px;
    min-width: 0;
}

.app-dialog {
    height: 360px;
}

.app-textfield {
    width: 506px;
}

.app-select {
    width: 325px;
}

.custom-textfield {
    width: 61px;
}

.v-btn {
    font-size: 13px;
    text-transform: none;
}

.app-textfield.error--text::v-deep .v-input__slot {
    background-color: var(--v-validationError-base);
}

.image-circle {
    cursor: pointer;
}

.image-circle:hover {
    opacity: 0.9;
}
</style>
