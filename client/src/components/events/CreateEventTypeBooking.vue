<template>
    <VContainer>
        <VCard class="mt-7">
            <VExpansionPanels accordion :value="defaultPanel">
                <VExpansionPanel>
                    <VExpansionPanelHeader>
                        <VRow align="center">
                            <VCol cols="2" md="1" sm="1" lg="1">
                                <div>
                                    <img
                                        :src="colorById[color].image"
                                        alt=""
                                        :class="{
                                            'pl-3': $vuetify.breakpoint.xs,
                                            'pl-10': $vuetify.breakpoint.smAndUp
                                        }"
                                    />
                                </div>
                            </VCol>
                            <VCol cols="10" class="pl-lg-5 pl-sm-10">
                                <div>
                                    <VCardTitle>
                                        {{ lang.CREATE_EVENT_TYPE_TITLE }}
                                    </VCardTitle>
                                    <VCardSubtitle>
                                        {{ name }}
                                    </VCardSubtitle>
                                </div>
                            </VCol>
                        </VRow>
                    </VExpansionPanelHeader>
                    <VExpansionPanelContent>
                        <VDivider class="mx-4"></VDivider>
                        <VRow>
                            <VCol
                                cols="10"
                                offset-sm="3"
                                offset-md="3"
                                md="6"
                                sm="6"
                                :class="{ 'ml-10': $vuetify.breakpoint.xs }"
                            >
                                <VForm class="mt-9 mb-16" ref="form">
                                    <div class="mb-2">
                                        <label>
                                            {{ lang.EVENT_NAME_LABEL }}*
                                        </label>
                                    </div>
                                    <VTextField
                                        :value="name"
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
                                        :value="location"
                                        :items="items"
                                        @change="changeLocation"
                                        outlined
                                        placeholder="Option"
                                        dense
                                        class="mb-3 app-textfield"
                                    >
                                        <template
                                            slot="selection"
                                            slot-scope="data"
                                        >
                                            <VFlex xs2 md1>
                                                <VIcon>
                                                    {{ data.item.icon }}
                                                </VIcon>
                                            </VFlex>
                                            <VFlex>
                                                {{ data.item.title }}
                                            </VFlex>
                                        </template>

                                        <template slot="item" slot-scope="data">
                                            <VFlex xs2 md1>
                                                <VIcon>
                                                    {{ data.item.icon }}
                                                </VIcon>
                                            </VFlex>
                                            <VFlex>
                                                {{ data.item.title }}
                                            </VFlex>
                                        </template>
                                    </VSelect>

                                    <div class="mb-2">
                                        <label>{{
                                            lang.DESCRIPTION_LABEL
                                        }}</label>
                                    </div>

                                    <VTextarea
                                        :value="description"
                                        @change="changeDescription"
                                        :rules="descRules"
                                        placeholder="Placeholder"
                                        outlined
                                        class="mb-3 app-textfield"
                                    >
                                    </VTextarea>

                                    <div class="mb-2">
                                        <label>
                                            {{ lang.EVENT_LINK_LABEL }}*
                                        </label>
                                    </div>

                                    <VTextField
                                        :rules="eventLinkRules"
                                        outlined
                                        :value="slug"
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
                                                    class=" image-circle"
                                                    :class="{
                                                        'mr-5':
                                                            $vuetify.breakpoint
                                                                .xs,
                                                        'mr-7 ml-3':
                                                            $vuetify.breakpoint
                                                                .smAndUp
                                                    }"
                                                    v-on:click="setColor(id)"
                                                >
                                                    <VOverlay
                                                        absolute
                                                        :value="color === id"
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
                                    <VRow>
                                        <div>
                                            <VBtn
                                                text
                                                outlined
                                                width="114"
                                                class="mr-3"
                                                @click.stop="
                                                    cancelDialog = true
                                                "
                                            >
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
                            </VCol>
                        </VRow>
                    </VExpansionPanelContent>
                </VExpansionPanel>
                <VExpansionPanel>
                    <VExpansionPanelHeader>
                        <VRow align="center">
                            <VCol cols="2" md="1" sm="1" lg="1">
                                <div>
                                    <img
                                        :src="
                                            require('@/assets/images/calender_circle.png')
                                        "
                                        alt=""
                                        :class="{
                                            'pl-3': $vuetify.breakpoint.xs,
                                            'pl-10': $vuetify.breakpoint.smAndUp
                                        }"
                                    />
                                </div>
                            </VCol>
                            <VCol cols="10" class="pl-lg-5 pl-sm-10">
                                <div>
                                    <VCardTitle>
                                        {{ lang.WHEN_CAN_PEOPLE_BOOK_EVENT }}
                                    </VCardTitle>
                                    <VCardSubtitle>
                                        {{ duration }}, {{ dateDuration }}
                                    </VCardSubtitle>
                                </div>
                            </VCol>
                        </VRow>
                    </VExpansionPanelHeader>
                    <VExpansionPanelContent>
                        <VDivider class="mx-4"></VDivider>
                        <VRow>
                            <VCol
                                cols="10"
                                offset-sm="2"
                                offset-md="2"
                                md="7"
                                sm="6"
                                lg="7"
                                :class="{ 'ml-10': $vuetify.breakpoint.xs }"
                            >
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
                                            :value="form.duration"
                                            @change="changeDuration"
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

                                        <p class="app-text mr-3">
                                            {{ lang.CUSTOM_DURATION }}
                                        </p>
                                        <VTextField
                                            :value="form.customDuration"
                                            @change="changeCustomDuration"
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
                                                'mb-3':
                                                    $vuetify.breakpoint.smAndUp
                                            }"
                                        >
                                            {{ lang.EVENTS_CAN_BE_SCHEDULED }}
                                            {{ dateDuration }}
                                        </p>
                                        <p
                                            @click.stop="
                                                availabilityDialog = true
                                            "
                                            class="edit-clicked ml-3 app-text"
                                        >
                                            {{ lang.EDIT }}
                                        </p>
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

                                            <span
                                                @click.stop="
                                                    timeZoneDialog = true
                                                "
                                                class="edit-clicked ml-3 app-text"
                                            >
                                                {{ lang.EDIT }}
                                            </span>
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
                                                <span class="custom-text">{{
                                                    lang.HOURS
                                                }}</span>
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
                                                                            >
                                                                            </VImg>
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
                                                                            >Cancel
                                                                        </VBtn>
                                                                        <VBtn
                                                                            text
                                                                            color="primary"
                                                                            @click="
                                                                                $refs.menu.save(
                                                                                    date
                                                                                )
                                                                            "
                                                                            >OK
                                                                        </VBtn>
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
                                                            >
                                                            </VCalendar>
                                                        </VSheet>
                                                    </VCol>
                                                </VRow>
                                            </VTabItem>
                                            <VTab :href="'#tab-1'">
                                                <span class="custom-text">{{
                                                    lang.ADVANCED
                                                }}</span>
                                            </VTab>
                                            <VTabItem :value="'tab-1'">
                                                <VRow class="pt-3">
                                                    <VCol cols="12" md="5">
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
                                                    <VCol cols="12" md="5">
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
                                                    <VCol cols="12" md="5">
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
                                                    <VCol cols="12" md="5">
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
                                                    <VCol cols="12" md="5">
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
                                                    <VCol cols="12" md="5">
                                                        <p>
                                                            {{
                                                                lang.PREVENT_EVENTS_LESS_THAN
                                                            }}
                                                        </p>
                                                        <VRow align="baseline">
                                                            <VCol
                                                                cols="3"
                                                                md="5"
                                                            >
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
                                                @click.stop="
                                                    cancelDialog = true
                                                "
                                            >
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
                            </VCol>
                        </VRow>
                    </VExpansionPanelContent>
                </VExpansionPanel>
            </VExpansionPanels>
        </VCard>
        <VRow justify="center">
            <VDialog
                v-model="availabilityDialog"
                max-width="380"
                @close="cancelDateRange"
            >
                <AvailabilityDialog
                    :range="form.dateRange"
                    @cancel="cancelDateRange"
                    @apply="changeDateRange"
                >
                </AvailabilityDialog>
            </VDialog>
        </VRow>
        <VRow justify="center">
            <VDialog v-model="timeZoneDialog" max-width="380">
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
                                    v-model="radioTimeZoneChecked"
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
                                    v-show="radioTimeZoneChecked === 'Local'"
                                    class="px-0 pb-0"
                                >
                                    <p>{{ lang.INVITEES_VIRTUAL_MEETINGS }}</p>
                                    <p class="mt-5">
                                        {{
                                            lang.INVITEES_VIRTUAL_MEETINGS_CONFIGURED
                                        }}
                                    </p>
                                </VCardText>

                                <div v-show="radioTimeZoneChecked === 'Locked'">
                                    <VCardText class="px-0 pb-0"
                                        ><p>
                                            {{
                                                lang.INVITEES_IN_PERSON_MEETINGS
                                            }}
                                        </p></VCardText
                                    >
                                    <VCol cols="12" class="px-0 py-0">
                                        <VSelect
                                            :items="timeZones"
                                            @change="changeTimezone"
                                            :value="form.timezone"
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
            <VDialog v-model="eventDialog" width="380" v-if="selectedDay">
                <VCard>
                    <VRow justify="center">
                        <VCardTitle class="headline">{{
                            lang.EDIT_AVAILABILITY
                        }}</VCardTitle>
                        <VCol cols="9">
                            <VRow align="baseline">
                                <VCol cols="4">
                                    <VRow>
                                        <label class="availability-label">{{
                                            lang.FROM
                                        }}</label>
                                    </VRow>
                                    <VRow>
                                        <VTextField
                                            :value="startTime"
                                            :key="selectedDay.date"
                                            @change="changeStartTime"
                                            outlined
                                            dense
                                            placeholder="hh:mm"
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
                                        <label class="availability-label">{{
                                            lang.TO
                                        }}</label>
                                    </VRow>
                                    <VRow>
                                        <VTextField
                                            :value="endTime"
                                            :key="selectedDay.date"
                                            @change="changeEndTime"
                                            outlined
                                            dense
                                            placeholder="hh:mm"
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
        <VRow>
            <VDialog v-model="cancelDialog" width="380">
                <VCard>
                    <VCardTitle class="mb-5">
                        <VRow justify="center">
                            <h3>{{ lang.ARE_YOU_SURE }}</h3>
                        </VRow>
                    </VCardTitle>
                    <VCardText>
                        <VRow justify="center">
                            <p>{{ lang.UNSAVE_CHANGES_WILL_BE_LOST }}</p>
                        </VRow>
                    </VCardText>
                    <VCardActions class="justify-center">
                        <div class="mb-5">
                            <VBtn
                                color="primary"
                                class="white--text mr-3"
                                width="114"
                                :to="{ name: 'EventTypes' }"
                            >
                                {{ lang.YES }}
                            </VBtn>
                            <VBtn
                                text
                                outlined
                                width="114"
                                @click="cancelDialog = false"
                            >
                                {{ lang.NEVERMIND }}
                            </VBtn>
                        </div>
                    </VCardActions>
                </VCard>
            </VDialog>
        </VRow>
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
import momentTimezone from 'moment-timezone';
import { mapActions, mapGetters, mapMutations } from 'vuex';
import * as eventTypeMutations from '@/store/modules/eventType/types/mutations';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';
import * as eventTypeActions from '@/store/modules/eventType/types/actions';
import moment from 'moment';
import AvailabilityDialog from '@/components/events/AvailabilityDialog';
export default {
    name: 'CreateEventTypeBooking',
    components: {
        AvailabilityDialog
    },
    data() {
        return {
            lang: enLang,
            customDuration: '',
            cancelDialog: false,
            availabilityDialog: false,
            availabilityIncrementsSelected: '',
            maxEventsPerDay: '',
            preventEventsHours: '',
            timeZoneDialog: false,
            focus: '',
            type: 'month',
            eventDialog: false,
            tab: null,
            date: new Date().toISOString().substr(0, 10),
            menu: false,
            timeZones: momentTimezone.tz.names(),
            exampleAvailability: {
                type: 'day',
                date: '',
                startDate: '',
                endDate: '',
                startTime: '',
                endTime: ''
            },
            form: {
                name: '',
                location: '',
                description: '',
                slug: '',
                color: '',
                duration: 30,
                customDuration: 0,
                timezone: moment.tz.guess(),
                dateRange: {
                    type: 'period',
                    value: 60,
                    subType: 'calendar',
                    date: []
                },
                availabilities: {}
            },
            items: [
                {
                    title: 'address on the map',
                    icon: 'mdi-google-maps'
                },
                {
                    title: 'zoom',
                    icon: 'mdi-video-box'
                },
                {
                    title: 'skype',
                    icon: 'mdi-skype'
                }
            ],
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
                        this.lang.FIELD_MUST_BE_VALUE_OR_MORE_THAN.replace(
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
                    v.length >= 2 ||
                    this.lang.EVENT_LINK_LABEL +
                        ' ' +
                        this.lang.FIELD_MUST_BE_VALUE_OR_MORE_THAN.replace(
                            'value',
                            2
                        ),

                v =>
                    /^([a-z0-9]|-|_)+$/.test(v) ||
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
            ],
            selectedDay: null,
            defaultPanel: 1
        };
    },

    computed: {
        ...mapGetters('eventType', {
            eventTypeForm: eventTypeGetters.GET_EVENT_TYPE_FORM
        }),
        rules() {
            return [
                this.form.duration > 0 ||
                    this.form.customDuration > 0 ||
                    'At least one item should be selected'
            ];
        },
        startTime() {
            let startTime = '';
            if (this.selectedDay && this.selectedDay.date) {
                startTime = this.form.availabilities[this.selectedDay.date][0][
                    'startTime'
                ];
            }

            return startTime;
        },
        endTime() {
            let endTime = '';
            if (this.selectedDay && this.selectedDay.date) {
                endTime = this.form.availabilities[this.selectedDay.date][0][
                    'endTime'
                ];
            }

            return endTime;
        },
        radioTimeZone() {
            return [this.lang.LOCAL, this.lang.LOCKED];
        },
        radioTimeZoneChecked() {
            return this.lang.LOCAL;
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
        },
        color() {
            return this.form.color || this.eventTypeForm.color;
        },
        name() {
            return this.form.name || this.eventTypeForm.name;
        },
        location() {
            return this.form.location || this.eventTypeForm.location;
        },
        description() {
            return this.form.description || this.eventTypeForm.description;
        },
        slug() {
            return this.form.slug || this.eventTypeForm.slug;
        },
        duration() {
            return (this.form.customDuration || this.form.duration) + ' min';
        },
        disabled() {
            return this.eventTypeForm.disabled;
        },
        dateDuration() {
            let result = '';
            switch (this.form.dateRange.type) {
                case 'period':
                    result =
                        this.form.dateRange.value +
                        ' ' +
                        (this.form.dateRange.type === 'calendar'
                            ? this.lang.DAYS_FORMAT_ITEMS_CALENDAR
                            : this.lang.DAYS_FORMAT_ITEMS_BUSINESS);
                    break;
                case 'range':
                    if (this.form.dateRange.date.length === 1) {
                        result = this.form.dateRange.date[0];
                    } else {
                        result = `from ${this.form.dateRange.date[0]} to ${this.form.dateRange.date[1]}`;
                    }
                    break;
                case 'indefinitely':
                    result = 'indefinitely';
                    break;
            }

            return result;
        }
    },

    methods: {
        ...mapMutations('eventType', {
            setEventTypeForm: eventTypeMutations.SET_EVENT_TYPE_FORM
        }),
        ...mapActions('eventType', {
            addEventType: eventTypeActions.ADD_EVENT_TYPE
        }),
        clickNext() {
            this.defaultPanel = 1;
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
        changeDuration(val) {
            this.form.customDuration = 0;
            this.form.duration = val;
        },
        changeCustomDuration(val) {
            this.form.duration = 0;
            this.form.customDuration = val;
        },
        changeTimezone(data) {
            this.form.timezone = data;
        },
        changeStartTime(time) {
            this.form.availabilities[this.selectedDay.date][0][
                'startTime'
            ] = time;
            this.form.availabilities[this.selectedDay.date][0]['startDate'] =
                this.selectedDay.date + ' ' + time + ':00';
        },
        changeEndTime(time) {
            this.form.availabilities[this.selectedDay.date][0][
                'endTime'
            ] = time;
            this.form.availabilities[this.selectedDay.date][0]['endDate'] =
                this.selectedDay.date + ' ' + time + ':00';
        },
        viewEventDialog(data) {
            this.selectedDay = data;
            if (!this.form.availabilities[this.selectedDay.date]) {
                this.form.availabilities[this.selectedDay.date] = [];
                this.form.availabilities[this.selectedDay.date].push({
                    ...this.exampleAvailability
                });
                this.form.availabilities[this.selectedDay.date][0][
                    'date'
                ] = this.selectedDay.date;
            }
            this.eventDialog = !this.eventDialog;
        },

        prev() {
            this.$refs.calendar.prev();
        },
        next() {
            this.$refs.calendar.next();
        },
        changeDateRange(data) {
            this.availabilityDialog = false;
            this.form.dateRange = data;
        },
        cancelDateRange() {
            this.availabilityDialog = false;
            this.form.dateRange.type = 'period';
            this.form.dateRange.value = 60;
            this.form.dateRange.subType = 'calendar';
            this.form.dateRange.date = [];
        },
        async saveEventType() {
            try {
                if (!this.$refs.form.validate()) {
                    return;
                }

                await this.addEventType({
                    ...this.form,
                    ...{
                        name: this.name,
                        location: this.location,
                        description: this.description,
                        slug: this.slug,
                        color: this.color,
                        disabled: this.disabled
                    }
                });
                this.$router.push({ name: 'EventTypes' });
            } catch (error) {
                this.showErrorMessage(error.message);
            }
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
    width: 55px;
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

.custom-text {
    text-transform: none;
}

/deep/ .v-dialog {
    overflow-x: hidden;
}

.edit-clicked {
    cursor: pointer;
    color: var(--v-primary-base);
}
</style>
