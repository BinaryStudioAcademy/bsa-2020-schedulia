<template>
    <VForm class="mt-9 mb-16" ref="form">
        <div class="mb-2">
            <label>{{ lang.EVENT_NAME_LABEL }}*</label>
        </div>
        <VTextField
            :value="data.name"
            @input="changeEventTypeProperty('name', $event)"
            :rules="nameRules"
            outlined
            class="app-textfield"
            dense
            id="event-type-name"
        ></VTextField>

        <div class="mb-2">
            <label>{{ lang.LOCATION_LABEL }}*</label>
        </div>

        <div class="mb-3">
            <VSelect
                :value="data.locationType"
                :items="items"
                :rules="locationRules"
                @change="changeEventTypeProperty('locationType', $event)"
                outlined
                :clearable="true"
                placeholder="Option"
                dense
                class="mb-1"
                id="event-type-location-type"
            >
                <template slot="selection" slot-scope="data">
                    <VFlex xs2 md1>
                        <VIcon>{{ data.item.icon }}</VIcon>
                    </VFlex>
                    <VFlex>{{ data.item.title }}</VFlex>
                </template>

                <template slot="item" slot-scope="data">
                    <VFlex xs2 md1>
                        <VIcon>{{ data.item.icon }}</VIcon>
                    </VFlex>
                    <VFlex>{{ data.item.title }}</VFlex>
                </template>
            </VSelect>
            <FindLocationForm class="find-location-form" v-if="showGeocoder" />
        </div>

        <div class="mb-2" v-if="user.chatito_active">
            <label>Chatito workspace (Notifications)*</label>
        </div>

        <VTextField
            v-if="user.chatito_active"
            :value="data.chatito_workspace"
            @input="changeEventTypeProperty('chatito_workspace', $event)"
            :rules="chatitoRules"
            outlined
            class="app-textfield"
            dense
        ></VTextField>

        <div class="mb-2">
            <label>{{ lang.DESCRIPTION_LABEL }}</label>
        </div>

        <VTextarea
            :value="data.description"
            @change="changeEventTypeProperty('description', $event)"
            :rules="descRules"
            placeholder="Placeholder"
            outlined
            class="mb-3"
            id="event-type-description"
        ></VTextarea>

        <div class="mb-2">
            <label>{{ lang.EVENT_LINK_LABEL }}*</label>
        </div>

        <VTextField
            :rules="eventLinkRules"
            outlined
            :value="data.slug"
            @input="changeEventTypeProperty('slug', $event)"
            dense
            class="mb-4 app-textfield"
            required
            id="event-type-slug"
        ></VTextField>

        <div class="mb-2">
            <label>{{ lang.EVENT_TAGS_LABEL }}</label>
        </div>

        <VCombobox
            :value="data.tagChecks"
            :items="setAllTags"
            :search-input.sync="search"
            hide-selected
            @input="changeEventTypeProperty('tagChecks', $event)"
            :label="lang.ADD_SOME_TAGS"
            multiple
            small-chips
            dense
            solo
            flat
            outlined
        >
            <template v-slot:no-data>
                <VListItem>
                    <VListItemContent>
                        <VListItemTitle>
                            {{ lang.NO_RESULT_MATCHING }} "<strong>{{
                                search
                            }}</strong
                            >". {{ lang.PRESS_ENTER_TO_CREATE }}
                        </VListItemTitle>
                    </VListItemContent>
                </VListItem>
            </template>
        </VCombobox>

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
                        alt
                        width="44"
                        height="44"
                        class="image-circle"
                        :class="{
                            'mr-5': $vuetify.breakpoint.xs,
                            'mr-7 ml-3': $vuetify.breakpoint.smAndUp
                        }"
                        v-on:click="changeEventTypeProperty('color', id)"
                    >
                        <VOverlay
                            absolute
                            :value="data.color === id"
                            class="rounded-circle"
                            color="eventColor"
                        >
                            <img
                                :src="require('@/assets/images/icon_check.png')"
                                alt
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
                :to="{ name: 'EventTypes' }"
                >{{ lang.CANCEL }}</VBtn
            >
            <VBtn
                @click="clickNext"
                color="primary"
                class="white--text"
                width="114"
                >{{ lang.NEXT }}</VBtn
            >
        </div>
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
                            >{{ lang.YES }}</VBtn
                        >
                        <VBtn
                            text
                            outlined
                            width="114"
                            @click="cancelDialog = false"
                            >{{ lang.NEVERMIND }}</VBtn
                        >
                    </div>
                </VCardActions>
            </VCard>
        </VDialog>
        <VDialog :value="showZoomDialog" max-width="390" persistent>
            <div class="set-location-container">
                <h3 class="mb-4">{{ lang.SET_MEETING_LOCATION }}</h3>
                <VTextField
                    :value="data.location"
                    @change="changeEventTypeProperty('location', $event)"
                    :placeholder="lang.ZOOM_CONFERENCE_LINK"
                    outlined
                    dense
                    id="event-type-location-zoom"
                ></VTextField>
                <VBtn
                    color="primary"
                    class="white--text"
                    width="114"
                    @click="onCloseZoomDialog"
                    >{{ lang.OK }}</VBtn
                >
            </div>
        </VDialog>
        <VDialog :value="showSkypeDialog" max-width="390" persistent>
            <div class="set-location-container">
                <h3 class="mb-4">{{ lang.SET_MEETING_LOCATION }}</h3>
                <VTextField
                    :value="data.location"
                    @change="changeEventTypeProperty('location', $event)"
                    :placeholder="lang.SKYPE_CALL_DETAILS"
                    outlined
                    dense
                    id="event-type-location-skype"
                ></VTextField>
                <VBtn
                    color="primary"
                    class="white--text"
                    width="114"
                    @click="onCloseSkypeDialog"
                    >{{ lang.OK }}</VBtn
                >
            </div>
        </VDialog>
    </VForm>
</template>

<script>
import * as i18nGetters from '@/store/modules/i18n/types/getters';
import { mapGetters, mapActions } from 'vuex';
import eventTypeMixin from '@/components/events/eventTypeMixin';
import FindLocationForm from './FindLocationForm';
import * as eventTypesActions from '@/store/modules/eventTypes/types/actions';
import * as eventTypesGetters from '@/store/modules/eventTypes/types/getters';

export default {
    name: 'CreateEventTypeForm',
    mixins: [eventTypeMixin],
    props: {
        isBooking: {
            type: Boolean,
            default: false
        }
    },
    components: {
        FindLocationForm
    },
    data() {
        return {
            tags: ['Gaming', 'Programming', 'Vue', 'Vuetify'],
            search: null,
            cancelDialog: false,
            items: [
                {
                    key: 'address',
                    title: 'address on the map',
                    icon: 'mdi-google-maps'
                },
                {
                    key: 'zoom',
                    title: 'zoom',
                    icon: 'mdi-video-box'
                }
            ],
            showZoomDialog: false,
            showSkypeDialog: false,
            colors: [
                'yellow',
                'red',
                'blue',
                'green',
                'purple',
                'turquoise',
                'pink',
                'dark_blue'
            ],
            chatitoRules: [v => !!v || 'Please provide Chatito workspace name'],
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
            locationRules: [v => !!v || this.lang.SELECT_LOCATION]
        };
    },
    computed: {
        ...mapGetters('i18n', {
            lang: i18nGetters.GET_LANGUAGE_CONSTANTS
        }),
        ...mapGetters('eventTypes', {
            getEventTypesTags: eventTypesGetters.GET_ALL_EVENT_TYPES_TAGS
        }),

        setAllTags() {
            let allTags = [];

            this.getEventTypesTags.forEach(tag => {
                allTags.push(tag.name);
            });

            return allTags;
        }
    },

    mounted() {
        this.setEventTypesTags({ searchString: '' });
    },

    methods: {
        ...mapActions('eventTypes', {
            setEventTypesTags: eventTypesActions.FETCH_EVENT_TYPES_TAGS
        }),

        clickNext() {
            if (this.$refs.form.validate()) {
                if (this.isBooking) {
                    this.$emit('changePanel');
                } else {
                    this.$router.push({ name: 'newEventTypeEdit' });
                }
            }
        },
        getSlug(value) {
            return value.replace(/\s/g, '-').toLowerCase();
        },
        onCloseZoomDialog() {
            this.showZoomDialog = false;
        },
        onCloseSkypeDialog() {
            this.showSkypeDialog = false;
        }
    }
};
</script>

<style scoped>
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

.set-location-container {
    background-color: white;
    padding: 30px 20px 15px 20px;
}
</style>
