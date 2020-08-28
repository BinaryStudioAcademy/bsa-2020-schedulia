<template>
    <VDialog v-model="visible" width="380" persistent>
        <VCard class="day-availabilities">
            <VCard>
                <VRow justify="center">
                    <VCardTitle class="headline">
                        {{ lang.EDIT_AVAILABILITY }}
                    </VCardTitle>
                    <VCol cols="9" >
                        <VRow v-if="!isUnavailable" align="baseline">
                            <VRow>
                                <VCol>
                                    <label class="availability-label">
                                        {{ lang.FROM }}
                                    </label>
                                </VCol>
                                <VCol>
                                    <label class="availability-label">
                                        {{ lang.TO }}
                                    </label>
                                </VCol>
                            </VRow>
                            <VRow v-for="(availability, index) in dayAvailabilitiesData" :key="index">
                                <VCol>
                                    <VMenu
                                        ref="menu"
                                        :value="startTimeMenu"
                                        :close-on-content-click="false"
                                        @input="changeStartTimeMenu"
                                        transition="scale-transition"
                                        offset-y
                                        max-width="290px"
                                        min-width="290px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <VTextField :value="availability.startTime"
                                                        readonly
                                                        @click="selectIndexTime(index)"
                                                        v-bind="attrs"
                                                        v-on="on">
                                            </VTextField>
                                        </template>
                                        <VTimePicker
                                            v-if="startTimeMenu"
                                            :value="availability.startTime"
                                            full-width
                                            format="24hr"
                                            @change="changeStartTime(index, $event)">
                                        </VTimePicker>
                                    </VMenu>
                                </VCol>
                                <VCol>
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
                                            <VTextField :value="availability.endTime"
                                                        @click="selectIndexTime(index)"
                                                        readonly
                                                        v-bind="attrs"
                                                        v-on="on">
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
                                <VIcon @click="deleteAvailability(index)" >mdi-delete</VIcon>
                            </VRow>
                        </VRow>
                        <VRow v-else class="unavailable">
                            <span>{{ lang.UNAVAILABLE }}</span>
                        </VRow>
                    </VCol>
                    <VCol>
                        <VBtn @click="addNewInterval">
                            + {{ lang.NEW_INTERVAL }}
                        </VBtn>
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
        </VCard>
    </VDialog>
</template>

<script>
import {mapGetters} from 'vuex';
import * as eventTypeGetters from "@/store/modules/eventType/types/getters";
import eventTypeMixin from "@/components/events/eventTypeMixin";

export default {
    name: 'DayAvailabilitiesDialog',
    mixins: [eventTypeMixin],
    data() {
        return {
            startTimeMenu: false,
            endTimeMenu: false,
            selectIndex: null,
            exampleAvailability: {
                type: 'exact_date',
                startDate: '',
                endDate: '',
                startTime: '',
                endTime: ''
            },
            form: []
        };
    },

    methods: {
        changeStartTimeMenu() {
            this.startTimeMenu = true;
        },
        changeEndTimeMenu() {
            this.endTimeMenu = true;
        },
        changeStartTime(index, time) {
            let result = this.dayAvailabilitiesData;
            result[this.selectIndex]['startTime'] = time;
            result[this.selectIndex]['startDate'] = this.data.selectDay.date + ' ' + time + ':00';
            this.setPropertyData('dayAvailabilities', result);
            this.startTimeMenu = false;
        },
        changeEndTime(time) {
            let result = this.dayAvailabilitiesData;
            result[this.selectIndex]['endTime'] = time;
            result[this.selectIndex]['endDate'] = this.data.selectDay.date + ' ' + time + ':00';
            this.setPropertyData('dayAvailabilities', result);
            this.endTimeMenu = false;
        },
        deleteAvailability() {
            if (this.dayAvailabilities.length === 1) {
                this.setPropertyData('dayAvailabilities', [
                    ...this.exampleAvailability,
                    ...{type: 'unavailable'}
                ]);
            } else {
                let result = this.dayAvailabilities.filter((day, index) => index !== this.selectIndex);
                this.setPropertyData('dayAvailabilities', [
                    ...result
                ]);
            }
        },
        selectIndexTime(index) {
            this.selectIndex = index;
        },
        addNewInterval() {
            this.setPropertyData('dayAvailabilities', [
                ...this.dayAvailabilitiesData,
                ...[{...this.exampleAvailability}]
            ]);
        },
        cancel() {
            this.setPropertyData('visibleDayAvailabilitiesDialog', false);
        },
        apply() {
            let result = {};
            result[this.data.selectDay.date] = this.dayAvailabilitiesData.map(function (item) {
                item.type = 'exact_date';
                return item;
            });
            this.changeEventTypeProperty('availabilities', {
                ...this.data.availabilities,
                ...result
            });
            this.setPropertyData('visibleDayAvailabilitiesDialog', false);
        }
    },
    computed: {
        ...mapGetters('eventType', {
            dayAvailabilities: eventTypeGetters.GET_DAY_AVAILABILITIES,
            visibleDayAvailabilitiesDialog: eventTypeGetters.GET_VISIBLE_DAY_AVAILABILITIES_DIALOG
        }),
        dayAvailabilitiesData() {
            return this.dayAvailabilities;
        },
        isUnavailable() {
            let result = false;
            if (this.dayAvailabilitiesData[0] && this.dayAvailabilitiesData[0]['type']) {
                result = this.dayAvailabilitiesData[0]['type'] === 'unavailable';
            }
            return result;
        },
        visible() {
            return this.visibleDayAvailabilitiesDialog;
        }
    }
};
</script>
<style lang="scss" scoped>
.day-availabilities {
    .unavailable {
        box-sizing: border-box;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 46px;
        border: 1px dashed #D0D0D0;
        span {
            color: #A8A8A8;
            font-size: 16px;
        }
    }
    .theme--light.v-icon:focus::after {
        opacity: 0;
    }
}
::v-deep .v-dialog {
    overflow-x: hidden;
}
</style>
