<template>
    <VContainer>
        <VCard class="mt-7">
            <VExpansionPanels accordion :value="1">
                <VExpansionPanel>
                    <VExpansionPanelHeader>
                        <VRow align="center">
                            <VCol cols="1">
                                <div>
                                    <img
                                        :src="colorById[data.color].image"
                                        alt=""
                                        class="ml-10"
                                    />
                                </div>
                            </VCol>
                            <VCol>
                                <div>
                                    <VCardTitle>
                                        {{ lang.CREATE_EVENT_TYPE_TITLE }}
                                    </VCardTitle>
                                    <VCardSubtitle>
                                        {{ lang.CREATE_EVENT_TYPE_SUBTITLE }}
                                    </VCardSubtitle>
                                </div>
                            </VCol>
                        </VRow>
                    </VExpansionPanelHeader>
                    <VExpansionPanelContent>
                        <VDivider class="mx-4"></VDivider>
                        <VRow>
                            <VCol cols="6" offset-md="2">
                                <VForm class="mt-9 mb-16">
                                    <div class="mb-2">
                                        <label
                                            >{{ lang.EVENT_NAME_LABEL }}*</label
                                        >
                                    </div>

                                    <VTextField
                                        :value="data.name"
                                        @input="changeName"
                                        :rules="nameRules"
                                        outlined
                                        class="app-textfield"
                                        dense
                                    >
                                    </VTextField>

                                    <div class="mb-2">
                                        <label>{{ lang.LOCATION_LABEL }}</label>
                                    </div>

                                    <VSelect
                                        :value="data.location"
                                        :items="items"
                                        @change="changeLocation"
                                        outlined
                                        placeholder="Option"
                                        dense
                                        class="mb-3 app-textfield"
                                    >
                                    </VSelect>

                                    <div class="mb-2">
                                        <label>{{
                                            lang.DESCRIPTION_LABEL
                                        }}</label>
                                    </div>

                                    <VTextarea
                                        :value="data.description"
                                        @change="changeDescription"
                                        :rules="descRules"
                                        placeholder="Placeholder"
                                        outlined
                                        class="mb-3 app-textfield"
                                    >
                                    </VTextarea>

                                    <div class="mb-2">
                                        <label
                                            >{{ lang.EVENT_LINK_LABEL }}*</label
                                        >
                                    </div>

                                    <VTextField
                                        :rules="eventLinkRules"
                                        outlined
                                        :value="data.slug"
                                        @input="changeSlug"
                                        dense
                                        class="mb-4 app-textfield"
                                        required
                                    >
                                    </VTextField>

                                    <div class="mb-2">
                                        <p>{{ lang.EVENT_COLOR_LABEL }}</p>
                                    </div>
                                    <div class="mb-12">
                                        <VRow>
                                            <div class="d-flex">
                                                <VImg
                                                    v-for="id in colors"
                                                    :key="id"
                                                    :src="colorById[id].image"
                                                    alt=""
                                                    class="mr-7 ml-3 image-circle"
                                                    v-on:click="setColor(id)"
                                                >
                                                    <VOverlay
                                                        absolute
                                                        :value="
                                                            data.color === id
                                                        "
                                                        class="rounded-circle"
                                                        color="eventColor"
                                                    >
                                                        <img
                                                            :src="
                                                                require('@/assets/images/icon_check.png')
                                                            "
                                                            alt=""
                                                        />
                                                    </VOverlay>
                                                </VImg>
                                            </div>
                                        </VRow>
                                    </div>
                                    <div>
                                        <VBtn
                                            text
                                            outlined
                                            width="114"
                                            class="mr-3"
                                        >
                                            {{ lang.CANCEL }}
                                        </VBtn>
                                        <VBtn
                                            @click="clickNext"
                                            color="primary"
                                            class="white--text"
                                            width="114"
                                        >
                                            Save & Close
                                        </VBtn>
                                    </div>
                                </VForm>
                            </VCol>
                        </VRow>
                    </VExpansionPanelContent>
                </VExpansionPanel>
                <VExpansionPanel>
                    <VExpansionPanelHeader>
                        <VRow align="center">
                            <VCol cols="1">
                                <div>
                                    <img
                                        :src="
                                            require('@/assets/images/calender_circle.png')
                                        "
                                        alt=""
                                        class="ml-10"
                                    />
                                </div>
                            </VCol>
                            <VCol>
                                <div>
                                    <VCardTitle>
                                        {{ lang.WHEN_CAN_PEOPLE_BOOK_EVENT }}
                                    </VCardTitle>
                                    <VCardSubtitle>
                                        15 min, 12 Jul - 24 Jul 2020
                                    </VCardSubtitle>
                                </div>
                            </VCol>
                        </VRow>
                    </VExpansionPanelHeader>
                    <VExpansionPanelContent>
                        <VDivider class="mx-4"></VDivider>
                        <VRow>
                            <VCol cols="7" offset-md="2">
                                <VForm class="mt-9 mb-16">
                                    <VRow>
                                        <h3 class="app-label">
                                            {{ lang.EVENT_DURATION }}*
                                        </h3>
                                    </VRow>
                                    <VRow align="baseline" class="mb-3">
                                        <VRadioGroup
                                            dense
                                            row
                                            v-model="eventDurationChecked"
                                            class="mr-5 app-text"
                                        >
                                            <VRadio
                                                v-for="n in eventDuration"
                                                :key="n"
                                                :label="`${n}`"
                                                :value="`${n}`"
                                                class="mr-6"
                                                :rules="rules"
                                            ></VRadio>
                                        </VRadioGroup>

                                        <p class="mr-3 app-text">
                                            {{ lang.CUSTOM_DURATION }}
                                        </p>

                                        <VTextField
                                            v-model="customDuration"
                                            outlined
                                            dense
                                            class="shrink custom-textfield"
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
                                        <p class="mr-5 app-text">
                                            {{
                                                lang.EVENTS_CAN_BE_SCHEDULED_OVER_60_DAYS
                                            }}
                                        </p>
                                        <VBtn
                                            text
                                            color="primary"
                                            dark
                                            @click.stop="
                                                availabilityDialog = true
                                            "
                                        >
                                            {{ lang.EDIT }}
                                        </VBtn>
                                    </VRow>
                                    <VRow class="mb-2">
                                        <h3 class="app-label">
                                            {{ lang.EVENT_TIME_ZONE }}
                                        </h3>
                                    </VRow>
                                    <VRow>
                                        <p class="app-text">
                                            {{
                                                lang.EVENT_TIME_ZONE_EXPLANATION
                                            }}

                                            <VBtn
                                                text
                                                small
                                                color="primary"
                                                dark
                                                @click.stop="
                                                    timeZoneDialog = true
                                                "
                                                class="editTimeZoneButton ma-n2 pa-n3"
                                            >
                                                {{ lang.EDIT }}
                                            </VBtn>
                                        </p>
                                    </VRow>
                                    <VRow class="mb-5">
                                        <VSheet class="recommendation-block">
                                            <p>
                                                {{
                                                    lang.LOCK_MEETING_TIME_RECOMMENDATION
                                                }}
                                            </p>
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
                                                {{ lang.HOURS }}
                                            </VTab>
                                            <VTabItem :value="'tab-0'">
                                                <VRow class="fill-height">
                                                    <VCol>
                                                        <VSheet height="64">
                                                            <VToolbar
                                                                flat
                                                                color="white"
                                                            >
                                                                <VBtn
                                                                    fab
                                                                    text
                                                                    small
                                                                    @click="
                                                                        prev
                                                                    "
                                                                >
                                                                    <img
                                                                        :src="
                                                                            require('@/assets/images/chevrons/chevron_left.png')
                                                                        "
                                                                        alt=""
                                                                    />
                                                                </VBtn>
                                                                <VToolbarTitle
                                                                    v-if="
                                                                        $refs.calendar
                                                                    "
                                                                    class="pa-4"
                                                                >
                                                                    {{
                                                                        $refs
                                                                            .calendar
                                                                            .title
                                                                    }}
                                                                </VToolbarTitle>
                                                                <VBtn
                                                                    fab
                                                                    text
                                                                    small
                                                                    @click="
                                                                        next
                                                                    "
                                                                >
                                                                    <img
                                                                        :src="
                                                                            require('@/assets/images/chevrons/chevron_right.png')
                                                                        "
                                                                        alt=""
                                                                    />
                                                                </VBtn>
                                                                <VMenu
                                                                    ref="menu"
                                                                    v-model="
                                                                        menu
                                                                    "
                                                                    :close-on-content-click="
                                                                        false
                                                                    "
                                                                    :return-value.sync="
                                                                        date
                                                                    "
                                                                    transition="scale-transition"
                                                                    offset-y
                                                                    min-width="290px"
                                                                >
                                                                    <template
                                                                        v-slot:activator="{
                                                                            on,
                                                                            attrs
                                                                        }"
                                                                    >
                                                                        <VBtn
                                                                            v-model="
                                                                                date
                                                                            "
                                                                            label="Picker in menu"
                                                                            v-bind="
                                                                                attrs
                                                                            "
                                                                            v-on="
                                                                                on
                                                                            "
                                                                            text
                                                                            color="white"
                                                                        >
                                                                            <VImg
                                                                                :src="
                                                                                    require('@/assets/images/calendar_dates.svg')
                                                                                "
                                                                                alt=""
                                                                                width="24"
                                                                                height="24"
                                                                            ></VImg>
                                                                        </VBtn>
                                                                    </template>
                                                                    <VDatePicker
                                                                        v-model="
                                                                            date
                                                                        "
                                                                        no-title
                                                                        scrollable
                                                                    >
                                                                        <VSpacer></VSpacer>
                                                                        <VBtn
                                                                            text
                                                                            color="primary"
                                                                            @click="
                                                                                menu = false
                                                                            "
                                                                            >Cancel</VBtn
                                                                        >
                                                                        <VBtn
                                                                            text
                                                                            color="primary"
                                                                            @click="
                                                                                $refs.menu.save(
                                                                                    date
                                                                                )
                                                                            "
                                                                            >OK</VBtn
                                                                        >
                                                                    </VDatePicker>
                                                                </VMenu>
                                                                <VSpacer></VSpacer>
                                                            </VToolbar>
                                                        </VSheet>
                                                        <VSheet height="600">
                                                            <VCalendar
                                                                ref="calendar"
                                                                v-model="focus"
                                                                color="primary"
                                                                :type="type"
                                                                :show-month-on-first="
                                                                    false
                                                                "
                                                                :short-weekdays="
                                                                    false
                                                                "
                                                                @click:date="
                                                                    viewEventDialog
                                                                "
                                                            ></VCalendar>
                                                        </VSheet>
                                                    </VCol>
                                                </VRow>
                                            </VTabItem>
                                            <VTab :href="'#tab-1'">
                                                {{ lang.ADVANCED }}
                                            </VTab>
                                            <VTabItem :value="'tab-1'">
                                                <VRow class="pt-3">
                                                    <VCol cols="5">
                                                        <p
                                                            class="availability-label"
                                                        >
                                                            {{
                                                                lang.AVAILABILITY_INCREMENTS
                                                            }}
                                                        </p>
                                                        <p>
                                                            {{
                                                                lang.SET_THE_FREQUENCY_TIME_SLOTS_TEXT
                                                            }}
                                                        </p>
                                                    </VCol>
                                                    <VCol cols="5">
                                                        <p>
                                                            {{
                                                                lang.SHOW_AVAILABILITY_IN_INCREMENTS_OF
                                                            }}
                                                        </p>
                                                        <VSelect
                                                            v-model="
                                                                availabilityIncrementsSelected
                                                            "
                                                            :items="
                                                                availabilityIncrementsItems
                                                            "
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
                                                        <p
                                                            class="availability-label"
                                                        >
                                                            {{
                                                                lang.EVENT_MAX_PER_DAY
                                                            }}
                                                        </p>
                                                        <p>
                                                            {{
                                                                lang.LIMIT_THE_NUMBER_OF_EVENTS_TEXT
                                                            }}
                                                        </p>
                                                    </VCol>
                                                    <VCol cols="5">
                                                        <p>
                                                            {{
                                                                lang.MAX_NUMBER_OF_EVENTS_PER_DAY
                                                            }}
                                                        </p>
                                                        <VTextField
                                                            v-model="
                                                                maxEventsPerDay
                                                            "
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
                                                        <p
                                                            class="availability-label"
                                                        >
                                                            {{
                                                                lang.MINIMUM_SCHEDULING_NOTICE
                                                            }}
                                                        </p>
                                                        <p>
                                                            {{
                                                                lang.PREVENT_LAST_MINUTE_EVENTS_TEXT
                                                            }}
                                                        </p>
                                                    </VCol>
                                                    <VCol cols="5">
                                                        <p>
                                                            {{
                                                                lang.PREVENT_EVENTS_LESS_THAN
                                                            }}
                                                        </p>
                                                        <VRow align="baseline">
                                                            <VCol>
                                                                <VTextField
                                                                    v-model="
                                                                        preventEventsHours
                                                                    "
                                                                    outlined
                                                                    dense
                                                                    class="shrink custom-textfield"
                                                                    placeholder="0"
                                                                >
                                                                </VTextField>
                                                            </VCol>
                                                            <VCol>
                                                                <span>{{
                                                                    lang.HOURS_AWAY
                                                                }}</span>
                                                            </VCol>
                                                        </VRow>
                                                    </VCol>
                                                </VRow>
                                            </VTabItem>
                                        </VTabs>
                                    </VRow>
                                    <VRow class="mt-10">
                                        <div>
                                            <VBtn
                                                text
                                                outlined
                                                width="114"
                                                class="mr-3"
                                            >
                                                {{ lang.CANCEL }}
                                            </VBtn>
                                            <VBtn
                                                @click="clickNext"
                                                color="primary"
                                                class="white--text"
                                                width="114"
                                            >
                                                {{ lang.SAVE_AND_CLOSE }}
                                            </VBtn>
                                        </div>
                                    </VRow>
                                </VForm>
                            </VCol>
                        </VRow>
                    </VExpansionPanelContent>
                </VExpansionPanel>
            </VExpansionPanels>
        </VCard>
        <VRow justify="center">
            <VDialog v-model="availabilityDialog" max-width="380">
                <VCard>
                    <VRow justify="center">
                        <VCol cols="9">
                            <VRow justify="center">
                                <VCardTitle class="headline">{{
                                    lang.AVAILABILITY
                                }}</VCardTitle>
                                <VRow>
                                    <VCol cols="12">
                                        <label class="availability-label"
                                            >{{
                                                lang.WHEN_CAN_EVENTS_BE_SCHEDULED
                                            }}
                                        </label>
                                    </VCol>
                                </VRow>

                                <VSelect
                                    v-model="availabilitySelected"
                                    :items="availabilityItems"
                                    outlined
                                    placeholder="Option"
                                    dense
                                    class="app-select"
                                >
                                </VSelect>

                                <VCardText class="px-0 pb-0">
                                    <p>
                                        {{ lang.YOUR_INVITEES_WILL_BE_OFFERED }}
                                    </p>
                                    <p class="mt-5">
                                        {{ lang.HOW_FAR_INTO_THE_FUTURE }}
                                    </p>
                                </VCardText>

                                <VCol cols="3" class="px-0 py-0">
                                    <VTextField
                                        v-model="scheduledDays"
                                        outlined
                                        dense
                                    >
                                    </VTextField>
                                </VCol>
                                <VCol cols="9" class="px-0 py-0">
                                    <VSelect
                                        v-model="selectedDaysFormat"
                                        :items="daysFormatItems"
                                        outlined
                                        placeholder="Option"
                                        dense
                                        class="mb-3 app-select"
                                    >
                                    </VSelect>
                                </VCol>
                            </VRow>
                        </VCol>
                    </VRow>

                    <VCardActions>
                        <VSpacer></VSpacer>

                        <VBtn
                            color="primary"
                            text
                            @click="availabilityDialog = false"
                        >
                            {{ lang.APPLY }}
                        </VBtn>

                        <VBtn
                            color="primary"
                            text
                            @click="availabilityDialog = false"
                        >
                            {{ lang.CANCEL }}
                        </VBtn>
                    </VCardActions>
                </VCard>
            </VDialog>
        </VRow>
        <VRow justify="center">
            <VDialog v-model="timeZoneDialog" max-width="380">
                <VCard>
                    <VRow justify="center">
                        <VCol cols="9">
                            <VRow justify="center">
                                <VCardTitle class="headline">{{
                                    lang.TIME_ZONE_STYLE
                                }}</VCardTitle>
                                <VRadioGroup
                                    dense
                                    row
                                    v-model="radioTimeZoneChecked"
                                    class="mr-5 app-text"
                                >
                                    <VCol cols="6">
                                        <VRadio
                                            :label="lang.LOCAL"
                                            value="Local"
                                        >
                                        </VRadio>
                                    </VCol>
                                    <VCol cols="6">
                                        <VRadio
                                            :label="lang.LOCKED"
                                            value="Locked"
                                        >
                                        </VRadio>
                                    </VCol>
                                </VRadioGroup>

                                <VCardText
                                    v-show="radioTimeZoneChecked === 'Local'"
                                    class="px-0 pb-0"
                                >
                                    <p>
                                        Invitees will see your availability in
                                        their time zone. Recommended for virtual
                                        meetings.
                                    </p>
                                    <p class="mt-5">
                                        (Your account settings are configured
                                        for Eastern European Time)
                                    </p>
                                </VCardText>

                                <div v-show="radioTimeZoneChecked === 'Locked'">
                                    <VCardText class="px-0 pb-0">
                                        <p>
                                            Invitees will see your availability
                                            in a locked time zone. Recommended
                                            for in-person meetings.
                                        </p>
                                    </VCardText>

                                    <VCol cols="12" class="px-0 py-0">
                                        <VSelect
                                            v-model="selectedTimeZone"
                                            :items="timeZones"
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

                        <VBtn
                            color="primary"
                            text
                            @click="timeZoneDialog = false"
                        >
                            {{ lang.APPLY }}
                        </VBtn>

                        <VBtn
                            color="primary"
                            text
                            @click="timeZoneDialog = false"
                        >
                            {{ lang.CANCEL }}
                        </VBtn>
                    </VCardActions>
                </VCard>
            </VDialog>
        </VRow>
        <VRow justify="center">
            <VDialog v-model="eventDialog" width="380">
                <VCard>
                    <VRow justify="center">
                        <VCardTitle class="headline">{{
                            lang.EDIT_AVAILABILITY
                        }}</VCardTitle>
                        <VCol cols="9">
                            <VRow align="baseline">
                                <VCol cols="4">
                                    <VRow>
                                        <label class="availability-label"
                                            >From
                                        </label>
                                    </VRow>
                                    <VRow>
                                        <VTextField
                                            v-model="startEvent"
                                            outlined
                                            dense
                                            placeholder="hh::mm"
                                        >
                                        </VTextField>
                                    </VRow>
                                </VCol>
                                <VCol cols="2">
                                    <VRow> </VRow>
                                    <VRow justify="center">
                                        <span class="mt-3"> - </span>
                                    </VRow>
                                </VCol>

                                <VCol cols="4">
                                    <VRow>
                                        <label class="availability-label"
                                            >To
                                        </label>
                                    </VRow>
                                    <VRow>
                                        <VTextField
                                            v-model="endEvent"
                                            outlined
                                            dense
                                            placeholder="hh::mm"
                                        >
                                        </VTextField>
                                    </VRow>
                                </VCol>
                            </VRow>
                        </VCol>
                    </VRow>
                    <VCardActions>
                        <VSpacer></VSpacer>

                        <VBtn color="primary" text @click="eventDialog = false">
                            {{ lang.APPLY }}
                        </VBtn>

                        <VBtn color="primary" text @click="eventDialog = false">
                            {{ lang.CANCEL }}
                        </VBtn>
                    </VCardActions>
                </VCard>
            </VDialog>
        </VRow>
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
import momentTimezone from 'moment-timezone';
import { mapGetters, mapMutations } from 'vuex';
import * as eventTypeMutations from '@/store/modules/eventType/types/mutations';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
export default {
    name: 'CreateEventTypeBooking',

    data() {
        return {
            lang: enLang,
            eventDuration: ['15 min', '30 min', '45 min', '60 min'],
            eventDurationChecked: '',
            customDuration: '',
            radioTimeZone: ['Local', 'Locked'],
            radioTimeZoneChecked: 'Local',
            availabilityItems: [
                'Over a period fo rolling days',
                'Over a date range',
                'Indefinitely'
            ],
            daysFormatItems: ['calendar days', 'business days'],
            availabilitySelected: '',
            selectedDaysFormat: '',
            selectedTimeZone: '',
            scheduledDays: '60',
            availabilityDialog: false,
            availabilityIncrementsItems: [
                '5 min',
                '10 min',
                '15 min',
                '20 min',
                '25 min',
                '30min'
            ],
            availabilityIncrementsSelected: '',
            maxEventsPerDay: '',
            preventEventsHours: '',
            timeZoneDialog: false,
            focus: '',
            type: 'month',
            eventDialog: false,
            startEvent: '',
            endEvent: '',
            tab: null,
            date: new Date().toISOString().substr(0, 10),
            menu: false,
            timeZones: momentTimezone.tz.names(),

            form: {
                name: '',
                location: '',
                description: '',
                slug: '',
                color: 'yellow'
            },
            items: ['address on the map', 'zoom', 'skype'],
            colorById: {
                yellow: {
                    id: 'yellow',
                    image: require('@/assets/images/yellow_circle.png')
                },
                red: {
                    id: 'red',
                    image: require('@/assets/images/red_circle.png')
                },
                blue: {
                    id: 'blue',
                    image: require('@/assets/images/blue_circle.png')
                },
                green: {
                    id: 'green',
                    image: require('@/assets/images/green_circle.png')
                }
            },
            colors: ['yellow', 'red', 'blue', 'green'],
            nameRules: [
                v => !!v || this.lang.PROVIDE_EVENT_NAME,
                v =>
                    v.length >= 2 ||
                    this.lang.EVENT_NAME_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_MORE_THAN_VALUE.replace(
                            'value',
                            2
                        ),
                v =>
                    v.length <= 55 ||
                    this.lang.EVENT_NAME_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                            'value',
                            55
                        )
            ],
            eventLinkRules: [
                v => !!v || this.lang.PROVIDE_EVENT_LINK,
                v =>
                    v.length <= 250 ||
                    this.lang.EVENT_LINK_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                            'value',
                            250
                        ),
                v =>
                    /[a-z]|[0-9]|-|_/.test(v) ||
                    this.lang.EVENT_LINK_VALID_SYMBOLS
            ],
            descRules: [
                v =>
                    v.length <= 1000 ||
                    this.lang.DESCRIPTION_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_LESS_THAN_VALUE.replace(
                            'value',
                            1000
                        )
            ]
        };
    },
    mounted() {
        this.$refs.calendar.checkChange();
    },

    computed: {
        ...mapGetters('eventType', {
            getEventTypeForm: eventTypeGetters.GET_EVENT_TYPE_FORM
        }),
        data() {
            return {
                ...this.getEventTypeForm,
                ...this.form
            };
        },

        rules() {
            return [
                this.eventDurationChecked.length > 0 ||
                    'At least one item should be selected'
            ];
        }
    },

    methods: {
        ...mapMutations('eventType', {
            setEventTypeForm: eventTypeMutations.SET_EVENT_TYPE_FORM
        }),
        clickNext() {
            this.setEventTypeForm(this.form);
        },
        setColor(id) {
            this.form.color = this.colorById[id].id;
        },
        changeName(val) {
            this.form.name = val;
            this.changeSlug(val);
        },
        changeLocation(val) {
            this.form.location = val;
        },
        changeDescription(val) {
            this.form.description = val;
        },
        changeSlug(val) {
            this.form.slug = val.replace(/\s/g, '-');
        },

        viewEventDialog() {
            this.eventDialog = !this.eventDialog;
        },

        prev() {
            this.$refs.calendar.prev();
        },
        next() {
            this.$refs.calendar.next();
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
