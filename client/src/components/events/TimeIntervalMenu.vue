<template>
    <VRow class="time-interval-wrapper">
        <VCol class="start-time">
            <VMenu
                ref="menu"
                :value="startTimeMenu"
                :close-on-content-click="false"
                @input="changeStartTimeMenu"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="290px"
            >
                <template v-slot:activator="{ on, attrs }">
                    <VTextField
                        :rules="startTimeRules"
                        :value="availability.startTime"
                        @focus="clearValidate"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    >
                    </VTextField>
                </template>
                <VTimePicker
                    v-if="startTimeMenu"
                    :value="availability.startTime"
                    full-width
                    format="24hr"
                    @change="changeStartTime"
                >
                </VTimePicker>
            </VMenu>
        </VCol>
        <VCol class="end-time">
            <VMenu
                ref="menu"
                :value="endTimeMenu"
                @input="changeEndTimeMenu"
                :close-on-content-click="false"
                transition="scale-transition"
                offset-y
                max-width="290px"
                min-width="290px"
            >
                <template v-slot:activator="{ on, attrs }">
                    <VTextField
                        :value="availability.endTime"
                        :rules="endTimeRules"
                        @focus="clearValidate"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    >
                    </VTextField>
                </template>
                <VTimePicker
                    v-if="endTimeMenu"
                    :value="availability.endTime"
                    full-width
                    format="24hr"
                    @change="changeEndTime"
                ></VTimePicker>
            </VMenu>
        </VCol>
        <VIcon @click="deleteAvailability">
            mdi-delete
        </VIcon>
    </VRow>
</template>

<script>
import eventTypeMixin from '@/components/events/eventTypeMixin';
import { mapGetters } from 'vuex';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import moment from 'moment';
export default {
    name: 'TimeIntervalMenu',
    mixins: [eventTypeMixin],
    props: {
        index: {
            type: Number,
            required: true
        },
        availability: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            startTimeMenu: false,
            endTimeMenu: false
        };
    },

    methods: {
        clearValidate() {
            this.$emit('clear-validate');
            this.setPropertyData('intervalsOverlappingError', []);
        },
        changeStartTimeMenu() {
            this.startTimeMenu = true;
        },
        changeEndTimeMenu() {
            this.endTimeMenu = true;
        },
        changeStartTime(time) {
            let result = this.dayAvailabilitiesData;
            result[this.getIndex]['startTime'] = time;
            result[this.getIndex]['startDate'] =
                this.data.selectDay.date + ' ' + time + ':00';
            this.setPropertyData('dayAvailabilities', result);
            this.startTimeMenu = false;
        },
        changeEndTime(time) {
            let result = this.dayAvailabilitiesData;
            result[this.getIndex]['endTime'] = time;
            result[this.getIndex]['endDate'] =
                this.data.selectDay.date + ' ' + time + ':00';
            this.setPropertyData('dayAvailabilities', result);
            this.endTimeMenu = false;
        },
        deleteAvailability() {
            if (this.dayAvailabilities.length === 1) {
                let params = {
                    type: 'unavailable',
                    startDate: this.dayAvailabilities[0]['startDate'],
                    endDate: this.dayAvailabilities[0]['endDate']
                };
                this.setPropertyData('dayAvailabilities', [params]);
            } else {
                let result = this.dayAvailabilities.filter((day, index) => {
                    return index !== this.getIndex;
                });
                this.setPropertyData('dayAvailabilities', [...result]);
            }
        },
        validateDuration() {
            let result = false;
            if (!this.availability.startDate || !this.availability.endDate) {
                return true;
            }
            if (
                moment(this.availability.startDate).add(
                    this.data.duration,
                    'minutes'
                ) < moment(this.availability.endDate)
            ) {
                result = true;
            } else {
                result = this.lang.INTERVALS_MUST.replace(
                    '_',
                    this.data.duration
                );
            }

            return result;
        }
    },
    computed: {
        ...mapGetters('eventType', {
            dayAvailabilities: eventTypeGetters.GET_DAY_AVAILABILITIES,
            getIntervalsOverlappingError:
                eventTypeGetters.GET_INTERVALS_OVERLAPPING_ERROR
        }),
        getIndex() {
            return this.index;
        },
        dayAvailabilitiesData() {
            return this.dayAvailabilities;
        },
        startTimeRules() {
            return [
                v => !!v || this.lang.REQUIRED_START_TIME,
                this.validateDuration(),
                this.isIntervalsOverlappingError
            ];
        },
        endTimeRules() {
            return [
                v => !!v || this.lang.REQUIRED_END_TIME,
                this.validateDuration(),
                this.isIntervalsOverlappingError
            ];
        },
        isIntervalsOverlappingError() {
            let result = false;
            if (this.getIntervalsOverlappingError.length < 1) {
                result = true;
            } else if (this.getIntervalsOverlappingError.includes(this.index)) {
                result = this.lang.INTERVALS_OVERLAPPING;
            }
            return result;
        }
    }
};
</script>
<style lang="scss" scoped>
.time-interval-wrapper {
    .start-time {
        padding: 0 0 0 21px;
    }
    .end-time {
        padding: 0 0 0 60px;
    }
}
.theme--light.v-icon:focus::after {
    opacity: 0;
}
</style>
