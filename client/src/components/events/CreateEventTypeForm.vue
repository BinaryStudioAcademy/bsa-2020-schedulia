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
        >
        </VTextField>

        <div class="mb-2">
            <label>{{ lang.LOCATION_LABEL }}</label>
        </div>

        <VSelect
            :value="data.locationType"
            :items="items"
            @change="changeEventTypeProperty('locationType', $event)"
            outlined
            :clearable="true"
            placeholder="Option"
            dense
            class="mb-3"
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
        >
        </VTextarea>

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
                :to="{ name: 'EventTypes' }"
            >
                {{ lang.CANCEL }}
            </VBtn>
            <VBtn
                @click="clickNext"
                color="primary"
                class="white--text"
                width="114"
            >
                {{ lang.NEXT }}
            </VBtn>
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
        <VDialog :value="showMapDialog" max-width="390" persistent>
            <div class="set-location-container">
                <h3 class="mb-4">{{ lang.SET_MEETING_LOCATION }}</h3>
                <div class="basemap">
                    <MglMap
                        :accessToken="accessToken"
                        :mapStyle="'mapbox://styles/mapbox/streets-v11'"
                        @click="onMapClick"
                    >
                        <MglNavigationControl position="top-right" />
                        <MglGeolocateControl position="top-right" />
                        <MglMarker
                            v-if="coordinates.length"
                            :coordinates="coordinates"
                            color="red"
                        />
                    </MglMap>
                </div>
                <VBtn
                    color="primary"
                    class="white--text mt-4"
                    width="114"
                    @click="onCloseMapDialog"
                    >{{ lang.OK }}</VBtn
                >
            </div>
        </VDialog>
        <VDialog :value="showZoomDialog" max-width="390" persistent>
            <div class="set-location-container">
                <h3 class="mb-4">{{ lang.SET_MEETING_LOCATION }}</h3>
                <VTextField
                    :value="form.location"
                    @change="changeEventTypeProperty('location', $event)"
                    :placeholder="lang.ZOOM_CONFERENCE_LINK"
                    outlined
                    dense
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
                    :value="form.location"
                    @change="changeEventTypeProperty('location', $event)"
                    :placeholder="lang.SKYPE_CALL_DETAILS"
                    outlined
                    dense
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
import { mapActions } from 'vuex';
import * as actionEventType from '@/store/modules/eventType/types/actions';
import eventTypeMixin from '@/components/events/eventTypeMixin';
import '../../../node_modules/mapbox-gl/dist/mapbox-gl.css';
import {
    MglMap,
    MglNavigationControl,
    MglGeolocateControl,
    MglMarker
} from 'vue-mapbox';
const VUE_APP_MAPBOX_TOKEN = process.env.VUE_APP_MAPBOX_TOKEN;

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
        MglMap,
        MglNavigationControl,
        MglGeolocateControl,
        MglMarker
    },
    data() {
        return {
            cancelDialog: false,
            form: {
                name: '',
                location: '',
                locationType: '',
                description: '',
                slug: '',
                color: 'yellow'
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
            accessToken: VUE_APP_MAPBOX_TOKEN,
            showMapDialog: false,
            coordinates: [],
            showZoomDialog: false,
            showSkypeDialog: false,
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
            ]
        };
    },

    methods: {
        ...mapActions('eventType', {
            setEventType: actionEventType.SET_EVENT_TYPE
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
            return value.replace(/\s/g, '-');
        },
        onMapClick(ev) {
            this.coordinates = [
                ev.mapboxEvent.lngLat.lng,
                ev.mapboxEvent.lngLat.lat
            ];
            this.changeEventTypeProperty(
                'location',
                this.coordinates.toString()
            );
        },
        onCloseMapDialog() {
            this.showMapDialog = false;
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
.v-text-field {
    width: 506px;
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

.set-location-container {
    background-color: white;
    padding: 30px 20px 15px 20px;
}

.basemap {
    width: 350px;
    min-width: 250px;
    height: 250px;
}
</style>
