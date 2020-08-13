<template>
    <VContainer>
        <VCard class="mt-7">
            <VRow align="center">
                <VCol cols="1">
                    <div>
                        <img
                            :src="require('@/assets/images/calender_circle.png')"
                            alt=""
                            class="ml-10"
                        />
                    </div>
                </VCol>
                <VCol>
                    <div>
                        <VCardTitle>
                            When can people book this event?
                        </VCardTitle>
                        <VCardSubtitle>
                            15 min, 12 Jul - 24 Jul 2020
                        </VCardSubtitle>
                    </div>
                </VCol>
            </VRow>
            <VDivider class="mx-4"></VDivider>
            <VRow>
                <VCol cols="7" offset-md="2">
                    <VForm class="mt-9 mb-16">
                        <VRow>
                            <h3 class="app-label">Event Duration</h3>
                        </VRow>
                        <VRow align="baseline" class="mb-3">

                            <VRadioGroup dense row v-model="radioChecked" class="mr-5 app-text">
                                <VRadio
                                        v-for="n in radioGroup"
                                        :key="n"
                                        :label="`${n}`"
                                        :value="`${n}`"
                                        class="mr-6"
                                ></VRadio>
                            </VRadioGroup>
                                <p class="mr-3 app-text">Custom Duration</p>

                            <VTextField outlined dense class="shrink" placeholder="0">

                            </VTextField>


                        </VRow>
                        <VRow class="mb-2">
                            <h3 class="app-label">Date Range</h3>
                        </VRow>
                        <VRow class="mb-3" align="center">
                            <p class="mr-5 app-text">Event can be scheduled from 12 Jul to 24 Jul 2020</p>

                            <p>Edit</p>
                        </VRow>
                        <VRow class="mb-2">
                            <h3 class="app-label">Event Time Zone</h3>
                        </VRow>
                        <VRow>
                            <p class="app-text">
                                You are viewing times in Eastern European Time.
                                Your invitees will see your availability in their local time zone. Edit
                            </p>
                        </VRow>
                        <VRow class="mb-5">
                            <div class="grey-text-block">
                                <p>To ensure you and your invitee agree to the same time,
                                    we recommend that you "lock" the meeting time to the time zone in which the meeting is held.
                                </p>
                            </div>
                        </VRow>
                        <VRow class="mb-2">
                            <h3 class="app-label"> Availability</h3>
                        </VRow>
                        <VRow>
                            <p class="app-text">Set your available hours when people can schedule meetings with you.</p>
                        </VRow>
                        <div>
<!--                            <VSheet-->
<!--                                    tile-->
<!--                                    height="54"-->
<!--                                    color="grey lighten-3"-->
<!--                                    class="d-flex"-->
<!--                            >-->
<!--                                <VBtn-->
<!--                                        icon-->
<!--                                        class="ma-2"-->
<!--                                        @click="$refs.calendar.prev()"-->
<!--                                >-->
<!--                                    <VIcon>mdi-chevron-left</VIcon>-->
<!--                                </VBtn>-->
<!--                                <VSelect-->
<!--                                        v-model="type"-->
<!--                                        :items="types"-->
<!--                                        dense-->
<!--                                        outlined-->
<!--                                        hide-details-->
<!--                                        class="ma-2"-->
<!--                                        label="type"-->
<!--                                ></VSelect>-->
<!--                                <VSelect-->
<!--                                        v-model="mode"-->
<!--                                        :items="modes"-->
<!--                                        dense-->
<!--                                        outlined-->
<!--                                        hide-details-->
<!--                                        label="event-overlap-mode"-->
<!--                                        class="ma-2"-->
<!--                                ></VSelect>-->
<!--                                <VSelect-->
<!--                                        v-model="weekday"-->
<!--                                        :items="weekdays"-->
<!--                                        dense-->
<!--                                        outlined-->
<!--                                        hide-details-->
<!--                                        label="weekdays"-->
<!--                                        class="ma-2"-->
<!--                                ></VSelect>-->
<!--                                <VSpacer></VSpacer>-->
<!--                                <VBtn-->
<!--                                        icon-->
<!--                                        class="ma-2"-->
<!--                                        @click="$refs.calendar.next()"-->
<!--                                >-->
<!--                                    <VIcon>mdi-chevron-right</VIcon>-->
<!--                                </VBtn>-->
<!--                            </VSheet>-->
                            <VSheet height="600">
                                <VCalendar
                                    :weekdays="weekday"
                                    :type="type"
                                    class="app-calendar"
                                >

                                </VCalendar>
                            </VSheet>
                        </div>
                    </VForm>
                </VCol>
            </VRow>
        </VCard>
    </VContainer>
</template>

<script>

export default {
    name: "CreateEventTypeBooking",

    data() {
        return {
            radioGroup: ['15 min', '30 min', '45 min', '60 min'],
            radioChecked: '',
            type: 'month',
            types: ['month', 'week', 'day', '4day'],
            weekday: [0, 1, 2, 3, 4, 5, 6],
        };
    },
};
</script>

<style scoped>
.v-text-field {
  width: 61px;
}

.grey-text-block {
    background-color: rgba(40, 26, 199, 0.1);
    padding-left: 20px;
    padding-top: 17px;
    width: 688px;
    height: 72px;

}

.grey-text-block p {
    font-size: 9px;
    width: 539px;
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

.app-calendar >>> .v-calendar-weekly__day {
    border: none;
}

.app-calendar >>> .v-calendar-weekly__head .v-calendar-weekly__head-weekday{
    background-color: #E9E8F9;
    color: black;
    margin-right: 3px;
    /*border-left: white solid 3px;*/
}

.app-calendar >>> .v-calendar-weekly__day.v-outside {
    background-color: white;
}

.app-calendar >>> .v-calendar-weekly__day.v-outside .v-calendar-weekly__day-label {
    display: none;
}

.app-calendar >>> .v-calendar-weekly__day.v-present .v-calendar-weekly__day-label .v-btn span {
    display: none;
}

.app-calendar >>> .v-calendar-weekly__day.v-present .v-calendar-weekly__day-label .v-btn:after {
    content: 'Today';
}



</style>