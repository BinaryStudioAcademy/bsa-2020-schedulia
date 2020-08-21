<template>
    <VContainer>
        <VCard class="mt-7">
            <VRow align="center">
                <VCol cols="2" md="1" sm="1" lg="1">
                    <div>
                        <img
                            :src="colorById[data.color].image"
                            alt=""
                            :class="{'pl-3': $vuetify.breakpoint.xs,  'pl-10': $vuetify.breakpoint.smAndUp}"
                        />
                    </div>
                </VCol>
                <VCol cols="10" class="pl-lg-5 pl-sm-10">
                    <div>
                        <VCardTitle>
                            {{ lang.CREATE_EVENT_TYPE_TITLE }}
                        </VCardTitle>
                        <VCardSubtitle>
                            {{ data.name }}
                        </VCardSubtitle>
                    </div>
                </VCol>
            </VRow>
            <VDivider class="mx-4"></VDivider>
            <VRow>
                <VCol
                        cols="10"
                        offset-sm="3"
                        offset-md="3"
                        md="6" sm="6"
                        :class="{'ml-10': $vuetify.breakpoint.xs}"
                >
                    <VForm class="mt-9 mb-16" ref="form">
                        <div class="mb-2">
                            <label>{{ lang.EVENT_NAME_LABEL }}*</label>
                        </div>

                        <VTextField
                            :value="data.name"
                            @change="changeName"
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
                            class="mb-3"
                        >
                            <template slot="selection" slot-scope="data">
                                <VFlex xs2 md1>
                                    <VIcon>
                                        {{ data.item.icon }}
                                    </VIcon>
                                </VFlex>
                                <VFlex >
                                    {{ data.item.title}}
                                </VFlex>
                            </template>

                            <template slot="item" slot-scope="data">
                                <VFlex xs2 md1>
                                    <VIcon>
                                        {{ data.item.icon }}
                                    </VIcon>
                                </VFlex>
                                <VFlex >
                                    {{ data.item.title}}
                                </VFlex>
                            </template>

                        </VSelect>

                        <div class="mb-2">
                            <label>{{ lang.DESCRIPTION_LABEL }}</label>
                        </div>

                        <VTextarea
                            :value="data.description"
                            @change="changeDescription"
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
                            @input="changeSlug"
                            dense
                            class="mb-4 app-textfield"
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
                                        :class="{'mr-5': $vuetify.breakpoint.xs, 'mr-7 ml-3': $vuetify.breakpoint.smAndUp,}"
                                        v-on:click="setColor(id)"
                                    >
                                        <VOverlay
                                            absolute
                                            :value="data.color === id"
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
                                    @click.stop="cancelDialog = true"
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
                    </VForm>
                </VCol>
            </VRow>
        </VCard>
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
    </VContainer>
</template>

<script>
import enLang from '@/store/modules/i18n/en.js';
import { mapGetters, mapMutations } from 'vuex';
import * as eventTypeMutations from '@/store/modules/eventType/types/mutations';
import * as eventTypeGetters from '@/store/modules/eventType/types/getters';

export default {
    name: 'CreateEventTypeForm',
    data() {
        return {
            lang: enLang,
            cancelDialog: false,
            form: {
                name: '',
                location: '',
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
                        ),
            ]
        };
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
        }
    },

    methods: {
        ...mapMutations('eventType', {
            setEventTypeForm: eventTypeMutations.SET_EVENT_TYPE_FORM
        }),
        clickNext() {
            if (this.$refs.form.validate()) {
                this.setEventTypeForm(this.form);
                this.$router.push({ name: 'newEventEdit' });
            }

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
</style>
