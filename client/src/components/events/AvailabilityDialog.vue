<template>
    <VCard>
        <VRow justify="center">
            <VCol cols="9">
                <VRow justify="center">
                    <VCardTitle class="headline">
                        {{ lang.AVAILABILITY }}
                    </VCardTitle>
                    <VRow>
                        <VCol cols="12">
                            <label class="availability-label">
                                {{ lang.WHEN_CAN_EVENTS_BE_SCHEDULED }}
                            </label>
                        </VCol>
                    </VRow>

                    <VSelect
                        :value="type"
                        :items="availabilityItems"
                        @change="changeRangeType"
                        item-value="value"
                        item-text="label"
                        outlined
                        placeholder="Option"
                        dense
                        class="app-select"
                    >
                    </VSelect>

                    <VCardText
                        class="px-0 pb-0"
                        v-if="type !== availabilityItems[1]['value']"
                    >
                        <p>
                            {{ lang.YOUR_INVITEES_WILL_BE_OFFERED }}
                        </p>
                        <p
                            class="mt-5"
                            v-if="type === availabilityItems[0]['value']"
                        >
                            {{ lang.HOW_FAR_INTO_THE_FUTURE }}
                        </p>
                    </VCardText>

                    <VCardText class="px-0 pb-0" v-else>
                        <p>{{ lang.AVAILABILITY_RANGE }}</p>
                    </VCardText>

                    <VCol
                        cols="3"
                        class="px-0 py-0"
                        v-if="type === availabilityItems[0]['value']"
                    >
                        <VTextField
                            :value="value"
                            @change="changeRangeValue"
                            outlined
                            dense
                        >
                        </VTextField>
                    </VCol>
                    <VCol
                        cols="9"
                        class="px-0 py-0"
                        v-if="type === availabilityItems[0]['value']"
                    >
                        <VSelect
                            :value="subType"
                            :items="daysFormatItems"
                            item-value="value"
                            item-text="label"
                            outlined
                            placeholder="Option"
                            dense
                            class="mb-3 app-select"
                        >
                        </VSelect>
                    </VCol>
                    <VCol
                        cols="11"
                        class="px-0 py-0"
                        v-if="type === availabilityItems[1]['value']"
                    >
                        <VDatePicker
                            :value="date"
                            :no-title="true"
                            @input="changeRangeDate"
                            range
                        >
                        </VDatePicker>
                    </VCol>
                </VRow>
            </VCol>
        </VRow>

        <VCardActions>
            <VSpacer></VSpacer>
            <VBtn color="primary" text @click="$emit('apply', form)">
                {{ lang.APPLY }}
            </VBtn>
            <VBtn color="primary" text @click="$emit('cancel')">
                {{ lang.CANCEL }}
            </VBtn>
        </VCardActions>
    </VCard>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
export default {
    name: 'AvailabilityDialog',
    props: {
        range: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            lang: enLang,
            form: {
                type: 'period',
                value: 60,
                subType: 'calendar',
                date: []
            }
        };
    },

    methods: {
        changeRangeType(val) {
            this.resetDateRange();
            switch (val) {
                case this.availabilityItems[0]['value']:
                    this.form.type = val;
                    this.form.value = 60;
                    this.form.subType = this.daysFormatItems[0]['value'];
                    break;
                default:
                    this.form.type = val;
                    break;
            }
        },
        changeRangeDate(date) {
            this.form.date = date;
        },
        changeRangeValue(value) {
            this.form.value = +value;
        },
        resetDateRange() {
            this.form.type = null;
            this.form.value = null;
            this.form.subType = null;
            this.form.date = [];
        }
    },

    computed: {
        type() {
            return this.form.type || this.range.type;
        },
        subType() {
            return this.form.subType || this.range.subType;
        },
        date() {
            return this.form.date || this.range.date;
        },
        value() {
            return this.form.value || this.range.value;
        },
        availabilityItems() {
            return [
                { value: 'period', label: this.lang.AVAILABILITY_ITEMS_PERIOD },
                { value: 'range', label: this.lang.AVAILABILITY_ITEMS_RANGE },
                {
                    value: 'indefinitely',
                    label: this.lang.AVAILABILITY_ITEMS_INDEFINITELY
                }
            ];
        },
        daysFormatItems() {
            return [
                {
                    value: 'calendar',
                    label: this.lang.DAYS_FORMAT_ITEMS_CALENDAR
                },
                {
                    value: 'business',
                    label: this.lang.DAYS_FORMAT_ITEMS_BUSINESS
                }
            ];
        }
    }
};
</script>
<style scoped></style>
